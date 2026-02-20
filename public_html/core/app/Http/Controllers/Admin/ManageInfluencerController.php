<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Constants\Status;
use App\Models\Influencer;
use App\Models\Withdrawal;
use App\Models\Participant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\NotificationLog;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\Auth;

class ManageInfluencerController extends Controller
{

    public function allUsers()
    {
        $pageTitle = 'All Influencers';
        $influencers = $this->userData();
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function activeUsers()
    {
        $pageTitle = 'Active Influencers';
        $influencers = $this->userData('active');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function bannedUsers()
    {
        $pageTitle = 'Banned Influencers';
        $influencers = $this->userData('banned');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function emailUnverifiedUsers()
    {
        $pageTitle = 'Email Unverified Influencers';
        $influencers = $this->userData('emailUnverified');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function kycUnverifiedUsers()
    {
        $pageTitle = 'KYC Unverified Influencers';
        $influencers = $this->userData('kycUnverified');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function kycPendingUsers()
    {
        $pageTitle = 'KYC Pending Influencers';
        $influencers = $this->userData('kycPending');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function emailVerifiedUsers()
    {
        $pageTitle = 'Email Verified Influencers';
        $influencers = $this->userData('emailVerified');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }


    public function mobileUnverifiedUsers()
    {
        $pageTitle = 'Mobile Unverified Influencers';
        $influencers = $this->userData('mobileUnverified');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }


    public function mobileVerifiedUsers()
    {
        $pageTitle = 'Mobile Verified Influencers';
        $influencers = $this->userData('mobileVerified');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }


    public function usersWithBalance()
    {
        $pageTitle = 'Influencers with Balance';
        $influencers = $this->userData('withBalance');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }


    protected function userData($scope = null)
    {
        if ($scope) {
            $influencers = Influencer::$scope();
        } else {
            $influencers = Influencer::query();
        }
        return $influencers->searchable(['username', 'email'])->orderBy('id', 'desc')->paginate(getPaginate());
    }


    public function detail($id)
    {
        $influencer = Influencer::findOrFail($id);
        $pageTitle = 'Influencer Detail - ' . $influencer->username;
        $totalWithdrawals = Withdrawal::where('influencer_id', $influencer->id)->approved()->sum('amount');
        $totalTransaction = Transaction::where('influencer_id', $influencer->id)->count();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $campaigns = Participant::where('influencer_id', $id)->get();

        $campaign['total']         = (clone $campaigns)->count();
        $campaign['pending']       = (clone $campaigns)->where('status', Status::PARTICIPATE_REQUEST_PENDING)->count();
        $campaign['accepted']      = (clone $campaigns)->where('status', Status::PARTICIPATE_REQUEST_ACCEPTED)->count();
        $campaign['rejected']      = (clone $campaigns)->where('status', Status::PARTICIPATE_REQUEST_REJECTED)->count();
        $campaign['delivered']     = (clone $campaigns)->where('status', Status::CAMPAIGN_JOB_DELIVERED)->count();
        $campaign['reported']      = (clone $campaigns)->where('status', Status::CAMPAIGN_JOB_REPORTED)->count();
        $campaign['canceled']      = (clone $campaigns)->where('status', Status::CAMPAIGN_JOB_CANCELED)->count();
        $campaign['completed']     = (clone $campaigns)->where('status', Status::CAMPAIGN_JOB_COMPLETED)->count();
        $campaign['pendingTicket'] = SupportTicket::where('influencer_id', $influencer->id)->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count();
        return view('admin.influencer.detail', compact('pageTitle', 'influencer', 'totalWithdrawals', 'totalTransaction', 'countries','campaign'));
        
    }


    public function kycDetails($id)
    {
        $pageTitle = 'KYC Details';
        $influencer = Influencer::findOrFail($id);
        return view('admin.influencer.kyc_detail', compact('pageTitle', 'influencer'));
    }

    public function kycApprove($id)
    {
        $influencer = Influencer::findOrFail($id);
        $influencer->kv = Status::KYC_VERIFIED;
        $influencer->save();

        notify($influencer, 'KYC_APPROVE', []);

        $notify[] = ['success', 'KYC approved successfully'];
        return to_route('admin.influencer.kyc.pending')->withNotify($notify);
    }

    public function kycReject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required'
        ]);
        $influencer = Influencer::findOrFail($id);
        $influencer->kv = Status::KYC_UNVERIFIED;
        $influencer->kyc_rejection_reason = $request->reason;
        $influencer->save();

        notify($influencer, 'KYC_REJECT', [
            'reason' => $request->reason
        ]);

        $notify[] = ['success', 'KYC rejected successfully'];
        return to_route('admin.influencer.kyc.pending')->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $influencer = Influencer::findOrFail($id);
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray   = (array)$countryData;
        $countries      = implode(',', array_keys($countryArray));

        $countryCode    = $request->country;
        $country        = $countryData->$countryCode->country;
        $dialCode       = $countryData->$countryCode->dial_code;

        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname' => 'required|string|max:40',
            'email' => 'required|email|string|max:40|unique:users,email,' . $influencer->id,
            'mobile' => 'required|string|max:40',
            'country' => 'required|in:' . $countries,
            'engagement' => 'nullable|string',
            'avg_views' => 'nullable|string',
            'primary_gender' => 'nullable|string',
        ]);

        $exists = Influencer::where('mobile', $request->mobile)->where('dial_code', $dialCode)->where('id', '!=', $influencer->id)->exists();
        if ($exists) {
            $notify[] = ['error', 'The mobile number already exists.'];
            return back()->withNotify($notify);
        }

        $influencer->mobile = $request->mobile;
        $influencer->firstname = $request->firstname;
        $influencer->lastname = $request->lastname;
        $influencer->email = $request->email;
        $influencer->engagement = $request->engagement;
        $influencer->avg_views = $request->avg_views;
        $influencer->primary_gender = $request->primary_gender;

        $influencer->address = $request->address;
        $influencer->city = $request->city;
        $influencer->state = $request->state;
        $influencer->zip = $request->zip;
        $influencer->country_name = @$country;
        $influencer->dial_code = $dialCode;
        $influencer->country_code = $countryCode;

        $influencer->ev = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $influencer->sv = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        if (!$request->kv) {
            $influencer->kv = Status::KYC_UNVERIFIED;
            if ($influencer->kyc_data) {
                foreach ($influencer->kyc_data as $kycData) {
                    if ($kycData->type == 'file') {
                        fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
                    }
                }
            }
            $influencer->kyc_data = null;
        } else {
            $influencer->kv = Status::KYC_VERIFIED;
        }
        $influencer->save();

        $notify[] = ['success', 'Influencer details updated successfully'];
        return back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act' => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $influencer = Influencer::findOrFail($id);
        $amount = $request->amount;
        $trx = getTrx();

        $transaction = new Transaction();

        if ($request->act == 'add') {
            $influencer->balance += $amount;

            $transaction->trx_type = '+';
            $transaction->remark = 'balance_add';

            $notifyTemplate = 'BAL_ADD';

            $notify[] = ['success', 'Balance added successfully'];
        } else {
            if ($amount > $influencer->balance) {
                $notify[] = ['error', $influencer->username . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $influencer->balance -= $amount;

            $transaction->trx_type = '-';
            $transaction->remark = 'balance_subtract';

            $notifyTemplate = 'BAL_SUB';
            $notify[] = ['success', 'Balance subtracted successfully'];
        }

        $influencer->save();

        $transaction->influencer_id = $influencer->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $influencer->balance;
        $transaction->charge = 0;
        $transaction->trx =  $trx;
        $transaction->details = $request->remark;
        $transaction->save();

        notify($influencer, $notifyTemplate, [
            'trx' => $trx,
            'amount' => showAmount($amount, currencyFormat: false),
            'remark' => $request->remark,
            'post_balance' => showAmount($influencer->balance, currencyFormat: false)
        ]);

        return back()->withNotify($notify);
    }

    public function login($id)
    {
        if (auth()->check()) {
            auth()->logout();
        }
        Auth::guard('influencer')->loginUsingId($id);
        return to_route('influencer.home');
    }

    public function status(Request $request, $id)
    {
        $influencer = Influencer::findOrFail($id);
        if ($influencer->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $influencer->status = Status::USER_BAN;
            $influencer->ban_reason = $request->reason;
            $notify[] = ['success', 'Influencer banned successfully'];
        } else {
            $influencer->status = Status::USER_ACTIVE;
            $influencer->ban_reason = null;
            $notify[] = ['success', 'Influencer unbanned successfully'];
        }
        $influencer->save();
        return back()->withNotify($notify);
    }


    public function showNotificationSingleForm($id)
    {
        $influencer = Influencer::findOrFail($id);
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.influencer.detail', $influencer->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $influencer->username;
        return view('admin.influencer.notification_single', compact('pageTitle', 'influencer'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required',
            'via'     => 'required|in:email,sms,push',
            'subject' => 'required_if:via,email,push',
            'image'   => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $imageUrl = null;
        if ($request->via == 'push' && $request->hasFile('image')) {
            $imageUrl = fileUploader($request->image, getFilePath('push'));
        }

        $template = NotificationTemplate::where('act', 'DEFAULT')->where($request->via . '_status', Status::ENABLE)->exists();
        if (!$template) {
            $notify[] = ['warning', 'Default notification template is not enabled'];
            return back()->withNotify($notify);
        }

        $influencer = Influencer::findOrFail($id);
        notify($influencer, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ], [$request->via], pushImage: $imageUrl);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $notifyToUser = Influencer::notifyToUser();
        $influencers        = Influencer::active()->count();
        $pageTitle    = 'Notification to Verified Influencers';

        if (session()->has('SEND_NOTIFICATION') && !request()->email_sent) {
            session()->forget('SEND_NOTIFICATION');
        }

        return view('admin.influencer.notification_all', compact('pageTitle', 'influencers', 'notifyToUser'));
    }

    public function sendNotificationAll(Request $request)
    {
        $request->validate([
            'via'                          => 'required|in:email,sms,push',
            'message'                      => 'required',
            'subject'                      => 'required_if:via,email,push',
            'start'                        => 'required|integer|gte:1',
            'batch'                        => 'required|integer|gte:1',
            'being_sent_to'                => 'required',
            'cooling_time'                 => 'required|integer|gte:1',
            'number_of_top_deposited_user' => 'required_if:being_sent_to,topDepositedUsers|integer|gte:0',
            'number_of_days'               => 'required_if:being_sent_to,notLoginUsers|integer|gte:0',
            'image'                        => ["nullable", 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'number_of_days.required_if'               => "Number of days field is required",
            'number_of_top_deposited_user.required_if' => "Number of top deposited user field is required",
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }


        $template = NotificationTemplate::where('act', 'DEFAULT')->where($request->via . '_status', Status::ENABLE)->exists();
        if (!$template) {
            $notify[] = ['warning', 'Default notification template is not enabled'];
            return back()->withNotify($notify);
        }

        if ($request->being_sent_to == 'selectedUsers') {
            if (session()->has("SEND_NOTIFICATION")) {
                $request->merge(['influencer' => session()->get('SEND_NOTIFICATION')['influencer']]);
            } else {
                if (!$request->user || !is_array($request->user) || empty($request->user)) {
                    $notify[] = ['error', "Ensure that the user field is populated when sending an email to the designated user group"];
                    return back()->withNotify($notify);
                }
            }
        }

        $scope          = $request->being_sent_to;
        $influencerQuery      = Influencer::oldest()->active()->$scope();

        if (session()->has("SEND_NOTIFICATION")) {
            $totalUserCount = session('SEND_NOTIFICATION')['total_user'];
        } else {
            $totalUserCount = (clone $influencerQuery)->count() - ($request->start - 1);
        }


        if ($totalUserCount <= 0) {
            $notify[] = ['error', "Notification recipients were not found among the selected user base."];
            return back()->withNotify($notify);
        }


        $imageUrl = null;

        if ($request->via == 'push' && $request->hasFile('image')) {
            if (session()->has("SEND_NOTIFICATION")) {
                $request->merge(['image' => session()->get('SEND_NOTIFICATION')['image']]);
            }
            if ($request->hasFile("image")) {
                $imageUrl = fileUploader($request->image, getFilePath('push'));
            }
        }

        $influencers = (clone $influencerQuery)->skip($request->start - 1)->limit($request->batch)->get();

        foreach ($influencers as $influencer) {
            notify($influencer, 'DEFAULT', [
                'subject' => $request->subject,
                'message' => $request->message,
            ], [$request->via], pushImage: $imageUrl);
        }

        return $this->sessionForNotification($totalUserCount, $request);
    }


    private function sessionForNotification($totalUserCount, $request)
    {
        if (session()->has('SEND_NOTIFICATION')) {
            $sessionData                = session("SEND_NOTIFICATION");
            $sessionData['total_sent'] += $sessionData['batch'];
        } else {
            $sessionData               = $request->except('_token');
            $sessionData['total_sent'] = $request->batch;
            $sessionData['total_user'] = $totalUserCount;
        }

        $sessionData['start'] = $sessionData['total_sent'] + 1;

        if ($sessionData['total_sent'] >= $totalUserCount) {
            session()->forget("SEND_NOTIFICATION");
            $message = ucfirst($request->via) . " notifications were sent successfully";
            $url     = route("admin.influencer.notification.all");
        } else {
            session()->put('SEND_NOTIFICATION', $sessionData);
            $message = $sessionData['total_sent'] . " " . $sessionData['via'] . "  notifications were sent successfully";
            $url     = route("admin.influencer.notification.all") . "?email_sent=yes";
        }
        $notify[] = ['success', $message];
        return redirect($url)->withNotify($notify);
    }

    public function countBySegment($methodName)
    {
        return Influencer::active()->$methodName()->count();
    }

    public function list()
    {
        $query = Influencer::active();

        if (request()->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . request()->search . '%')->orWhere('username', 'like', '%' . request()->search . '%');
            });
        }
        $influencers = $query->orderBy('id', 'desc')->paginate(getPaginate());
        return response()->json([
            'success' => true,
            'users'   => $influencers,
            'more'    => $influencers->hasMorePages()
        ]);
    }

    public function notificationLog($id)
    {
        $influencer = Influencer::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $influencer->username;
        $logs = NotificationLog::where('influencer_id', $id)->with('influencer')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'influencer'));
    }
}
