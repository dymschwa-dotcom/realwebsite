<?php

namespace App\Http\Controllers\Influencer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Lib\ReferralCommission;
use App\Models\Activity;
use App\Models\Category;
use App\Models\DeviceToken;
use App\Models\Form;
use App\Models\Influencer;
use App\Models\Participant;
use App\Models\Platform;
use App\Models\Review;
use App\Models\SocialLink;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\InfluencerPackage;
use App\Models\ProfileGallery;
use Illuminate\Support\Facades\DB;

class InfluencerController extends Controller {
    public function home() {
        $pageTitle         = 'Dashboard';
        $influencer        = Influencer::where('id', authInfluencerId())->withCount('allReferrals')->first();
        $completedCampaign = Participant::where('influencer_id', $influencer->id)->completed()->count();
        $totalWithdraws    = Withdrawal::where('influencer_id', $influencer->id)->sum('amount');
        $activities        = Activity::where('influencer_id', $influencer->id)->latest()->take(5)->get();
        return view('Template::influencer.dashboard', compact('pageTitle', 'completedCampaign', 'totalWithdraws', 'activities', 'influencer'));
    }

    public function show2faForm() {
        $ga         = new GoogleAuthenticator();
        $influencer = auth()->guard('influencer')->user();
        $secret     = $ga->createSecret();
        $qrCodeUrl  = $ga->getQRCodeGoogleUrl($influencer->username . '@' . gs('site_name'), $secret);
        $pageTitle  = '2FA Security';
        return view('Template::influencer.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request) {
        $influencer = auth()->guard('influencer')->user();
        $request->validate([
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($influencer, $request->code, $request->key);
        if ($response) {
            $influencer->tsc = $request->key;
            $influencer->ts  = Status::ENABLE;
            $influencer->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request) {
        $request->validate([
            'code' => 'required',
        ]);

        $influencer = auth()->guard('influencer')->user();
        $response   = verifyG2fa($influencer, $request->code);
        if ($response) {
            $influencer->tsc = null;
            $influencer->ts  = Status::DISABLE;
            $influencer->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions() {
        $pageTitle = 'Transactions';
        $remarks   = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('influencer_id', auth()->guard('influencer')->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        return view('Template::influencer.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm() {
        if (auth()->guard('influencer')->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('influencer.home')->withNotify($notify);
        }
        if (auth()->guard('influencer')->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('influencer.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form      = Form::where('act', 'influencer_kyc')->first();
        return view('Template::influencer.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData() {
        $influencer = auth()->guard('influencer')->user();
        $pageTitle  = 'KYC Data';
        abort_if($influencer->kv == Status::VERIFIED, 403);
        return view('Template::influencer.kyc.info', compact('pageTitle', 'influencer'));
    }

    public function kycSubmit(Request $request) {
        $form           = Form::where('act', 'influencer_kyc')->firstOrFail();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $influencer = auth()->guard('influencer')->user();
        foreach (@$influencer->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $influencerData                   = $formProcessor->processFormData($request, $formData);
        $influencer->kyc_data             = $influencerData;
        $influencer->kyc_rejection_reason = null;
        $influencer->kv                   = Status::KYC_PENDING;
        $influencer->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('influencer.home')->withNotify($notify);

    }

    public function influencerData() {
        $influencer = auth()->guard('influencer')->user();

        // Allow influencers who are at step 2 to go back to step 1
        if ($influencer->profile_step > 2) {
            return to_route('influencer.home');
        }

        $pageTitle  = 'Influencer Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $categories = Category::active()->select('id', 'name')->get();
        $platforms  = Platform::active()->get();

        return view('Template::influencer.user_data', compact('pageTitle', 'influencer', 'countries', 'mobileCode', 'categories', 'platforms'));
    }

    public function influencerDataSubmit(Request $request) {

        $influencer = auth()->guard('influencer')->user();

        if ($influencer->profile_step > 2) {
            return to_route('influencer.home');
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));

        $request->validate([
            'country_code'  => 'required|in:' . $countryCodes,
            'country'       => 'required|string|max:100',
            'mobile_code'   => 'required|string|max:20',
            'username'      => 'required|min:6|max:40|unique:influencers,username,' . $influencer->id,
            'mobile'        => 'required',
            'gender'        => 'required|string|in:male,female,other',
            'birth_date'    => 'required|date|date_format:Y-m-d|before:' . now()->subYears(18)->format('Y-m-d'),
            'category'      => 'required|array|min:1',
            'social_link'   => 'required|array|min:1',
            'social_link.*' => 'nullable|string',
            'followers'     => 'required|array',
            'followers.*'   => 'nullable|integer|min:0',
            'image'         => [Rule::requiredIf(function() use ($influencer) { return !$influencer->image; }), 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ], [
            'social_link.*.string' => 'Invalid social link format',
            'category.required'    => 'Please select at least one category',
            'social_link.required' => 'Please provide at least one social media link',
            'image.required'       => 'Profile image is required',
            'birth_date.before'    => 'You must be at least 18 years old to join.',
        ]);

        if ($request->username && preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        return DB::transaction(function () use ($request, $influencer) {
            $influencer->country_code = $request->country_code;
            $influencer->mobile       = $request->mobile;
            $influencer->username     = $request->username;
            $influencer->gender       = $request->gender;
            $influencer->birth_date   = $request->birth_date;

            $influencer->city         = $request->city;
            $influencer->region       = $request->region;
            $influencer->country_name = @$request->country;
            $influencer->dial_code    = $request->mobile_code;

            $influencer->profile_complete = Status::NO; // Keep as NO until Step 2 is finished
            $influencer->profile_step     = 2;

            if ($request->hasFile('image')) {
                try {
                    $oldImage = $influencer->image;
                    $influencer->image = fileUploader($request->image, getFilePath('influencer'), getFileSize('influencer'), $oldImage, getFileThumb('influencer'));
                } catch (\Exception $exp) {
                    throw new \Exception('Couldn\'t upload your image');
                }
            }

        $influencer->save();

            // Category Sync
            $influencer->categories()->sync($request->category);

            // Social Links - Only save if we have a value
            $influencer->socialLink()->delete(); // Clear old ones if user hit back button
            foreach ($request->social_link as $key => $item) {
                if ($item) {
                    $social                = new SocialLink();
                    $social->influencer_id = $influencer->id;
                    $social->platform_id   = $key;
                    $social->social_link   = $item;
                    $social->followers     = $request->followers[$key] ?? 0;
                    $social->save();
                }
            }

            if (gs('influencer_register_commission')) {
                ReferralCommission::influencerRegisterCommission($influencer);
            }

            recentActivity('Registration process completed successfully', 0, $influencer->id);
            return to_route('influencer.packages');
        });
    }

    public function packages() {
        $influencer = authInfluencer();
        if ($influencer->profile_step < 2) {
            return to_route('influencer.data');
        }
        $pageTitle = 'Influencer Packages & Portfolio';
        return view('Template::influencer.packages', compact('pageTitle', 'influencer'));
    }
    public function packagesSubmit(Request $request) {
        $influencer = authInfluencer();
        if ($influencer->profile_step < 2) {
            return to_route('influencer.data');
        }

        $request->validate([
            'package'                 => 'required|array|min:1',
            'package.*.name'          => 'required|string|max:255',
            'package.*.description'   => 'required|string',
            'package.*.price'         => 'required|numeric|min:0',
            'package.*.platform_id'   => 'required|integer',
            'package.*.delivery_time' => 'required|integer|min:1',
            'package.*.post_count'    => 'required|integer|min:1',
            'package.*.video_length'  => 'nullable|integer|min:0',
            'about'                   => 'required|string|min:50',
            'images'                  => 'nullable|array|max:12',
            'images.*'                => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'package.required' => 'Please add at least one package',
            'about.required'   => 'The about section is required to introduce yourself',
            'about.min'        => 'The about section must be at least 50 characters',
        ]);

        if ($influencer->galleries->count() < 3 && (!$request->hasFile('images') || count($request->file('images')) + $influencer->galleries->count() < 3)) {
            $notify[] = ['error', 'Please upload at least 3 portfolio images to showcase your work.'];
            return back()->withNotify($notify)->withInput();
        }

        return DB::transaction(function () use ($request, $influencer) {
            InfluencerPackage::where('influencer_id', $influencer->id)->delete();

            foreach ($request->package as $item) {
                if (empty($item['name']) || !isset($item['price'])) {
                    continue;
                }
                $package                = new InfluencerPackage();
                $package->influencer_id = $influencer->id;
                $package->name          = $item['name'];
                $package->description   = @$item['description'] ?? 'No description';
                $package->price         = $item['price'];
                $package->platform_id   = @$item['platform_id'];
                $package->delivery_time = @$item['delivery_time'] ?? 7;
                $package->post_count    = @$item['post_count'] ?? 1;
                $package->video_length  = @$item['video_length'];
                $package->save();
            }

            $influencer->bio          = $request->about;
            $influencer->profile_step = 3;
            $influencer->profile_complete = Status::YES;
            $influencer->save();

            if ($request->hasFile('images')) {
                $lastOrder = ProfileGallery::where('influencer_id', $influencer->id)->max('sort_order') ?? 0;
                foreach ($request->file('images') as $image) {
                    try {
                        $newImage = fileUploader($image, getFilePath('profileGallery'), getFileSize('profileGallery'), null, getFileThumb('profileGallery'));
                        $gallery                = new ProfileGallery();
                        $gallery->influencer_id = $influencer->id;
                        $gallery->image         = $newImage;
                        $gallery->sort_order    = ++$lastOrder;
                        $gallery->save();
                    } catch (\Exception $exp) {
                        throw new \Exception('Failed to upload gallery images');
                    }
                }
            }

            $notify[] = ['success', 'Onboarding completed successfully! Your profile is now live.'];
            return to_route('influencer.home')->withNotify($notify);
        });
    }

    public function removeGallery($id) {
        $gallery = ProfileGallery::where('influencer_id', authInfluencerId())->where('id', $id)->firstOrFail();
        fileManager()->removeFile(getFilePath('profileGallery') . '/' . $gallery->image);
        $gallery->delete();

        return response()->json(['success' => true, 'message' => 'Image removed successfully']);
    }

    public function sortGallery(Request $request) {
        $request->validate([
            'sort' => 'required|array',
            'sort.*' => 'integer'
        ]);

        foreach ($request->sort as $index => $id) {
            ProfileGallery::where('influencer_id', authInfluencerId())->where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function uploadGalleryAjax(Request $request) {
        $influencer = authInfluencer();

        // Hard Limit: Max 12 items
        if ($influencer->galleries->count() >= 12) {
            return response()->json(['success' => false, 'message' => 'Maximum 12 portfolio items allowed']);
        }

        $request->validate([
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        try {
            $newImage = fileUploader($request->image, getFilePath('profileGallery'), getFileSize('profileGallery'), null, getFileThumb('profileGallery'));
            $gallery                = new ProfileGallery();
            $gallery->influencer_id = $influencer->id;
            $gallery->image         = $newImage;
            $gallery->sort_order    = ProfileGallery::where('influencer_id', $influencer->id)->max('sort_order') + 1;
            $gallery->save();

            return response()->json([
                'success' => true,
                'id' => $gallery->id,
                'src' => getImage(getFilePath('profileGallery') . '/' . $gallery->image)
            ]);
        } catch (\Exception $exp) {
            return response()->json(['success' => false, 'message' => 'Failed to upload image']);
        }
    }

    public function addVideoGalleryAjax(Request $request) {
        $influencer = authInfluencer();

        // Hard Limit: Max 12 items
        if ($influencer->galleries->count() >= 12) {
            return response()->json(['success' => false, 'message' => 'Maximum 12 portfolio items allowed']);
        }

        $request->validate([
            'video_url' => 'required|url|max:255'
        ]);

        $videoUrl = $request->video_url;
        $videoType = 'video';
        $thumbUrl = null;

        if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
            $videoType = 'youtube';
            $thumbUrl = $this->getYoutubeThumbnail($videoUrl);
        } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
            $videoType = 'vimeo';
        }

        $gallery                = new ProfileGallery();
        $gallery->influencer_id = $influencer->id;
        $gallery->video_url     = $videoUrl;
        $gallery->video_type    = $videoType;
        $gallery->image         = $thumbUrl ?? 'video_default.png'; // Fallback
        $gallery->sort_order    = ProfileGallery::where('influencer_id', $influencer->id)->max('sort_order') + 1;
        $gallery->save();

        return response()->json([
            'success' => true,
            'id' => $gallery->id,
            'src' => $gallery->image,
            'video' => true
        ]);
    }

    private function getYoutubeThumbnail($url) {
        $videoId = "";
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $videoId = $match[1];
        }
        return $videoId ? "https://img.youtube.com/vi/$videoId/hqdefault.jpg" : null;
    }

    public function addDeviceToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken                = new DeviceToken();
        $deviceToken->influencer_id = auth()->guard('influencer')->user()->id;
        $deviceToken->token         = $request->token;
        $deviceToken->is_app        = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function downloadAttachment($fileHash) {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title     = slug(gs('site_name')) . '- attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function reviews() {
        $pageTitle = 'Reviews';
        $reviews   = Review::where('influencer_id', authInfluencerId())->with('user:id,username', 'participant')->searchable(['participant:participant_number', 'user:username'])->latest()->paginate(getPaginate());
        return view('Template::influencer.reviews', compact('pageTitle', 'reviews'));
    }

    public function downloadPayoutReceipt($trx) {
        $transaction = Transaction::where('influencer_id', auth()->guard('influencer')->id())->where('trx', $trx)->firstOrFail();
        $influencer = auth()->guard('influencer')->user();
        $pageTitle = 'Payout Receipt - ' . $trx;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Template::influencer.payout_receipt', compact('transaction', 'influencer', 'pageTitle'));
        return $pdf->download('payout-receipt-' . $trx . '.pdf');
    }

}
