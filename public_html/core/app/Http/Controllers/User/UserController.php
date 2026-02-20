<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\ReferralCommission;
use App\Models\Activity;
use App\Models\Campaign;
use App\Models\DeviceToken;
use App\Models\Form;
use App\Models\Participant;
use App\Models\Transaction;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    public function home() {
        $pageTitle = 'Dashboard';

        $user                         = auth()->user();
        $data['campaign']             = Campaign::where('user_id', $user->id)->count();
        $data['running_campaign']     = Campaign::where('user_id', $user->id)->approved()->running()->count();
        $data['pending_campaign']     = Campaign::where('user_id', $user->id)->pending()->count();
        $data['rejected_campaign']    = Campaign::where('user_id', $user->id)->rejected()->count();
        $data['incompleted_campaign'] = Campaign::where('user_id', $user->id)->inCompleted()->count();

        // 1. Fetch General Campaigns (The "Casting Calls")
        $generalCampaigns = Campaign::where('user_id', $user->id)
        ->where('campaign_type', 'general')
        ->whereIn('status', [Status::CAMPAIGN_APPROVED, Status::CAMPAIGN_COMPLETED]) // Filter active/relevant
        ->withCount(['participants as pending_count' => function($q) {
             $q->where('status', Status::PARTICIPATE_REQUEST_PENDING);
        }])
        ->withCount(['participants as hired_count' => function($q) {
             $q->where('status', Status::PARTICIPATE_REQUEST_ACCEPTED);
        }])
        ->latest()
        ->get();

        // 2. Fetch Shadow/Direct Campaigns (The "1-on-1s")
        // We strictly look for active participation records here
        $directWorkstreams = \App\Models\Participant::whereHas('campaign', function($q) use ($user) {
                $q->where('user_id', $user->id)
                ->where('campaign_type', 'invite'); // Shadow campaigns
            })
            ->whereNotIn('status', [Status::PARTICIPATE_REQUEST_REJECTED]) // Exclude dead ends
            ->with(['influencer', 'campaign'])
            ->get()
            ->groupBy('influencer_id'); 
            // ^ This GroupBy is the magic. It turns 10 rows into 3 Influencer Relationships.

        $totalParticipant = Participant::completed()->whereHas('campaign', function ($q) {
            $q->where('user_id', auth()->id());
        });

        $participantCopy = clone $totalParticipant;

        $data['total_spending']    = $participantCopy->sum('budget');
        $data['total_participant'] = $participantCopy->count();

        $activities = Activity::where('user_id', $user->id)->latest()->take(5)->get();

        return view('Template::user.dashboard', compact('pageTitle', 'data', 'activities', 'generalCampaigns', 'directWorkstreams'));
    }

    public function depositHistory(Request $request) {
        $pageTitle = 'Deposit History';
        $deposits  = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function transactions() {
        $pageTitle = 'Transactions';
        $remarks   = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('user_id', auth()->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        return view('Template::user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm() {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form      = Form::where('act', 'kyc')->first();
        return view('Template::user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData() {
        $user      = auth()->user();
        $pageTitle = 'KYC Data';
        abort_if($user->kv == Status::VERIFIED, 403);
        return view('Template::user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request) {
        $form           = Form::where('act', 'kyc')->firstOrFail();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $user = auth()->user();
        foreach (@$user->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $userData                   = $formProcessor->processFormData($request, $formData);
        $user->kyc_data             = $userData;
        $user->kyc_rejection_reason = null;
        $user->kv                   = Status::KYC_PENDING;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function userData() {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request) {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
            'brand_name'   => 'required|string|max:40',
            'website'      => 'required|url|max:255',
            'image'        => ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;
        $user->brand_name   = $request->brand_name;
        $user->website      = $request->website;

        $user->country_name = @$request->country;
        $user->dial_code    = $request->mobile_code;

        $user->profile_complete = Status::YES;

        if ($request->hasFile('image')) {
            try {
                $user->image = fileUploader($request->image, getFilePath('brand'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->save();
        if (gs('brand_register_commission')) {
            ReferralCommission::brandRegisterCommission($user);
        }
        recentActivity('Registration process completed successfully', $user->id);
        $notify[] = ['success', 'Registration process completed successfully'];

        return to_route('user.home');
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

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
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
}
