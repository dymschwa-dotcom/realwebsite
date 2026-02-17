<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\Influencer;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManageInfluencerController extends Controller
{
    /**
     * --- STATUS BASED LISTING METHODS ---
     */

    public function allUsers()
    {
        $pageTitle = 'All Influencers';
        $influencers = $this->influencerData();
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function activeUsers()
    {
        $pageTitle = 'Active Influencers';
        $influencers = $this->influencerData('active');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function bannedUsers()
    {
        $pageTitle = 'Banned Influencers';
        $influencers = $this->influencerData('banned');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function emailUnverifiedUsers()
    {
        $pageTitle = 'Email Unverified Influencers';
        $influencers = $this->influencerData('emailUnverified');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function mobileUnverifiedUsers()
    {
        $pageTitle = 'Mobile Unverified Influencers';
        $influencers = $this->influencerData('mobileUnverified');
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    /**
     * Helper to pull influencer data based on model scopes
     */
    protected function influencerData($scope = null)
    {
        $query = Influencer::orderBy('id', 'desc');
        if ($scope) {
            $query->$scope(); 
        }
        return $query->paginate(getPaginate());
    }

    /**
     * --- DETAIL & UPDATE ---
     */

    public function detail($id)
    {
        $influencer = Influencer::findOrFail($id);
        $pageTitle = 'Influencer Detail - ' . $influencer->username;
        
        $totalWithdrawals = Withdrawal::where('influencer_id', $influencer->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $totalTransaction = Transaction::where('influencer_id', $influencer->id)->count();
        
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $campaigns = Participant::where('influencer_id', $id)->get();
        $campaign['total']     = $campaigns->count();
        $campaign['completed'] = $campaigns->where('status', Status::CAMPAIGN_JOB_COMPLETED)->count();

        return view('admin.influencer.detail', compact('pageTitle', 'influencer', 'totalWithdrawals', 'totalTransaction', 'countries', 'campaign'));
    }

    public function update(Request $request, $id)
    {
        $influencer = Influencer::findOrFail($id);

        $request->validate([
            'firstname'       => 'required|string|max:40',
            'lastname'        => 'required|string|max:40',
            'email'           => 'required|email|unique:influencers,email,' . $influencer->id,
            'mobile'          => 'required',
            'engagement_rate' => 'nullable|string|max:40',
            'avg_reach'       => 'nullable|string|max:40',
            'primary_gender'  => 'nullable|string|max:40',
        ]);

        $influencer->firstname = $request->firstname;
        $influencer->lastname  = $request->lastname;
        $influencer->email     = $request->email;
        $influencer->mobile    = $request->mobile;

        // Save manual Audience Insights
        $influencer->engagement_rate = $request->engagement_rate;
        $influencer->avg_reach       = $request->avg_reach;
        $influencer->primary_gender  = $request->primary_gender;

        if ($request->country) {
            $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')), true);
            $code = $request->country;
            if (isset($countryData[$code])) {
                $influencer->country_code = $code;
                $influencer->country_name = $countryData[$code]['country'];
                $influencer->dial_code    = $countryData[$code]['dial_code'];
            }
        }

        $influencer->ev = $request->ev ? Status::YES : Status::NO;
        $influencer->sv = $request->sv ? Status::YES : Status::NO;
        $influencer->ts = $request->ts ? Status::YES : Status::NO;
        
        // This logic ensures if the checkbox is missing in the request, we don't accidentally ban them.
        $influencer->status = $request->status ? Status::USER_ACTIVE : Status::USER_BAN;
        $influencer->kv = $request->kv ? Status::KYC_VERIFIED : Status::KYC_UNVERIFIED; 

        $influencer->save();

        $notify[] = ['success', 'Influencer details updated successfully'];
        return back()->withNotify($notify);
    }

    /**
     * FIXED: Added missing status method for Ban/Unban toggle
     */
    public function status(Request $request, $id)
    {
        $influencer = Influencer::findOrFail($id);
        if ($influencer->status == Status::USER_ACTIVE) {
            $request->validate(['reason' => 'required']);
            $influencer->status = Status::USER_BAN;
            $influencer->ban_reason = $request->reason;
            $notification = 'Influencer banned successfully';
        } else {
            $influencer->status = Status::USER_ACTIVE;
            $influencer->ban_reason = null;
            $notification = 'Influencer unbanned successfully';
        }
        $influencer->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    /**
     * --- KYC MANAGEMENT ---
     */

    public function kycUnverifiedUsers()
    {
        $pageTitle = 'KYC Unverified Influencers';
        $influencers = Influencer::kycUnverified()->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function kycPendingUsers()
    {
        $pageTitle = 'KYC Pending Influencers';
        $influencers = Influencer::kycPending()->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.influencer.list', compact('pageTitle', 'influencers'));
    }

    public function kycDetails($id)
    {
        $influencer = Influencer::findOrFail($id);
        $pageTitle = 'KYC Details - ' . $influencer->username;
        return view('admin.influencer.kyc_details', compact('pageTitle', 'influencer'));
    }

    public function kycApprove($id)
    {
        $influencer = Influencer::findOrFail($id);
        $influencer->kv = Status::KYC_VERIFIED;
        $influencer->save();

        $notify[] = ['success', 'KYC approved successfully'];
        return back()->withNotify($notify);
    }

    public function kycReject(Request $request, $id)
    {
        $request->validate(['reason' => 'required']);
        $influencer = Influencer::findOrFail($id);
        $influencer->kv = Status::KYC_UNVERIFIED; 
        $influencer->save();

        $notify[] = ['success', 'KYC rejected successfully'];
        return back()->withNotify($notify);
    }

    /**
     * --- ACTIONS ---
     */

    public function addSubBalance(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|gt:0', 'act' => 'required|in:add,sub']);
        $influencer = Influencer::findOrFail($id);

        if ($request->act == 'add') {
            $influencer->balance += $request->amount;
        } else {
            $influencer->balance -= $request->amount;
        }

        $influencer->save();
        $notify[] = ['success', 'Balance updated successfully'];
        return back()->withNotify($notify);
    }

    /**
     * LOGIN AS INFLUENCER
     */
    public function login($id)
    {
        Auth::guard('web')->logout();
        request()->session()->flush();
        Auth::guard('influencer')->loginUsingId($id);
        return to_route('influencer.home');
    }
}