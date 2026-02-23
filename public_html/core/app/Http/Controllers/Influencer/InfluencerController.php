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

        if ($influencer->profile_complete == Status::YES) {
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

        if ($influencer->profile_step != 1) {
            return to_route('influencer.packages');
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code'  => 'nullable|in:' . $countryCodes,
            'country'       => 'nullable|in:' . $countries,
            'mobile_code'   => 'nullable|in:' . $mobileCodes,
            'username'      => 'required|unique:influencers,username|min:6',
            'mobile'        => 'nullable',
            'gender'        => 'nullable|string|in:male,female,other',
            'birth_date'    => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'category'      => 'nullable|array',
            'social_link'   => 'nullable|array',
            'social_link.*' => 'nullable|url',
            'followers'     => 'nullable|array',
            'followers.*'   => 'nullable|integer|min:0',
            'image'         => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ], [
            'social_link.*' => 'Invalid social link format',
        ]);

        if ($request->username && preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $influencer->country_code = $request->country_code;
        $influencer->mobile       = $request->mobile;
        $influencer->username     = $request->username;
        $influencer->gender       = $request->gender;
        $influencer->birth_date   = $request->birth_date;

        $influencer->city         = $request->city;
        $influencer->region       = $request->region;
        $influencer->country_name = @$request->country;
        $influencer->dial_code    = $request->mobile_code;

        $influencer->profile_complete = Status::YES;
        $influencer->profile_step     = 2;

        if ($request->hasFile('image')) {
            try {
                $influencer->image = fileUploader($request->image, getFilePath('influencer'), getFileSize('influencer'), null, getFileThumb('influencer'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $influencer->save();

        if ($request->category) {
        $influencer->categories()->sync($request->category);
        }

        if ($request->social_link) {
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
        }

        if (gs('influencer_register_commission')) {
            ReferralCommission::influencerRegisterCommission($influencer);
        }

        recentActivity('Registration process completed successfully', 0, $influencer->id);
        return to_route('influencer.packages');
    }

    public function packages() {
        $influencer = authInfluencer();
        if ($influencer->profile_step != 2) {
            return to_route('influencer.home');
        }
        $pageTitle = 'Influencer Packages & Portfolio';
        return view('Template::influencer.packages', compact('pageTitle', 'influencer'));
    }
    public function packagesSubmit(Request $request) {
        $influencer = authInfluencer();
        if ($influencer->profile_step != 2) {
            return to_route('influencer.home');
        }

        $request->validate([
            'package'                 => 'nullable|array',
            'package.*.name'          => 'nullable|string|max:255',
            'package.*.description'   => 'nullable|string',
            'package.*.price'         => 'nullable|numeric|min:0',
            'package.*.platform_id'   => 'nullable|integer',
            'package.*.delivery_time' => 'nullable|integer|min:1',
            'package.*.post_count'    => 'nullable|integer|min:1',
            'package.*.video_length'  => 'nullable|integer|min:0',
            'about'                   => 'nullable|string',
            'images'                  => 'nullable|array|max:12',
            'images.*'                => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($request->package) {
            foreach ($request->package as $item) {
                if (empty($item['name']) || !isset($item['price'])) {
                    continue;
                }
            $package                = new \App\Models\InfluencerPackage();
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
        }

        $influencer->bio          = $request->about;
        $influencer->profile_step = 3;
        $influencer->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $newImage = fileUploader($image, getFilePath('profileGallery'), getFileSize('profileGallery'), null, getFileThumb('profileGallery'));
                    $gallery                = new \App\Models\ProfileGallery();
                    $gallery->influencer_id = $influencer->id;
                    $gallery->image         = $newImage;
                    $gallery->save();
                } catch (\Exception $exp) {
                    // Skip failed uploads or handle as needed
                }
            }
        }

        $notify[] = ['success', 'Packages and portfolio updated successfully'];
        return to_route('influencer.home')->withNotify($notify);
    }

    public function addDeviceToken(Request $request) {
// ... existing code ...
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

