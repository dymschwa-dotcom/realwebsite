<?php

namespace App\Http\Controllers\Influencer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Campaign;
use App\Models\Participant;
use App\Models\Transaction;
use App\Traits\ConversationForCampaign;
use Illuminate\Http\Request;

class ParticipantController extends Controller {

    use ConversationForCampaign;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->userType = 'user';
    }

    public function list(Request $request, $id) {
        $pageTitle    = 'Participants List';
        $campaign     = Campaign::where('user_id', auth()->id())->findOrFail($id);
        $participants = $campaign->participants();
        if ($request->status && $request->status != 'all') {
            $status = $request->status;
            $participants->$status();
        }
        $participants = $participants->searchable(['participant_number', 'influencer:username'])->with('influencer')->withCount('review')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.campaign.participants', compact('pageTitle', 'campaign', 'participants'));
    }

    public function accept($id) {
        $participant = Participant::pending()->authCampaign()->with('influencer')->findOrFail($id);

        $acceptParticipant = Participant::accepted()->where('campaign_id', $participant->campaign_id)->count();
        if ($acceptParticipant >= $participant->campaign->influencer_requirements->required_influencer) {
            $notify[] = ['error', 'The required influencer limit is over'];
            return back()->withNotify($notify);
        }

        $brand    = auth()->user();
        if(!$brand->address || !$brand->tax_number) {
            $notify[] = ['error', 'Please complete your business profile (Address and Tax ID) in settings before hiring.'];
            return to_route('user.profile.setting')->withNotify($notify);
        }
        
        $campaign = $participant->campaign;
        if ($participant->budget > $brand->balance) {
            $notify[] = ['error', 'Insufficient balance in your account'];
            return back()->withNotify($notify);
        }

        $participant->status = Status::PARTICIPATE_REQUEST_ACCEPTED;
        $participant->save();
        $influencer = $participant->influencer;

        if ($participant->budget > 0) {
            $brand->balance -= $participant->budget;
            $brand->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $brand->id;
            $transaction->amount       = $participant->budget;
            $transaction->post_balance = $brand->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '-';
            $transaction->details      = 'Accepted the influencer for the campaign';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'campaign';
            $transaction->save();

            notify($brand, 'BRAND_ACCEPT_REQUEST', [
                'brand'              => $brand->username,
                'influencer'         => $influencer->username,
                'title'              => $campaign->title,
                'budget'             => showAmount($participant->budget,currencyFormat:false),
                'post_balance'       => showAmount($brand->balance,currencyFormat:false),
                'trx'                => $transaction->trx,
                'participant_number' => $participant->participant_number,
            ]);
        }

        notify($influencer, 'PARTICIPATE_REQUEST_ACCEPTED', [
            'influencer'         => $influencer->username,
            'brand'              => $brand->username,
            'participant_number' => $participant->participant_number,
            'title'              => $campaign->title,
        ]);

        recentActivity('You have accepted the ' . $influencer->username . ' participation request', $brand->id);
        recentActivity($brand->username . ' has accepted your participant request', 0, $influencer->id);

        $notify[] = ['success', 'Campaign participation request accepted successfully'];
        return back()->withNotify($notify);
    }

    public function reject($id) {
        $participant         = Participant::pending()->authCampaign()->with('influencer')->findOrFail($id);
        $participant->status = Status::PARTICIPATE_REQUEST_REJECTED;
        $participant->save();

        $brand      = auth()->user();
        $influencer = $participant->influencer;
        notify($influencer, 'PARTICIPATE_REQUEST_REJECTED', [
            'influencer'         => @$influencer->username,
            'brand'              => $brand->username,
            'participant_number' => $participant->participant_number,
            'title'              => @$participant->campaign->title,
        ]);

        recentActivity('You have rejected the ' . $influencer->username . ' participation request', $brand->id);
        recentActivity($brand->username . ' has rejected your participation request', 0, $influencer->id);

        $notify[] = ['success', 'Campaign participation request rejected successfully'];
        return back()->withNotify($notify);
    }

    public function detail($id) {
        $pageTitle = 'Campaign Detail';
        $applicant = Participant::authCampaign()->with(['influencer' => function ($query) {
            $query->withCount('jobCompleted', 'jobRunning');
        }])->findOrFail($id);
        return view('Template::user.campaign.detail', compact('pageTitle', 'applicant'));
    }

    public function completed($id) {
        $participant         = Participant::delivered()->authCampaign()->with('influencer')->findOrFail($id);
        $participant->status = Status::CAMPAIGN_JOB_COMPLETED;
        $participant->save();

        $influencer = $participant->influencer;
        $campaign   = $participant->campaign;

        if ($campaign->payment_type == 'paid') {
            $influencer->balance += $participant->campaign->budget;
        }

        $influencer->increment('order_completed');
        $influencer->save();

        if ($campaign->payment_type == 'paid') {
            $transaction                = new Transaction();
            $transaction->influencer_id = $influencer->id;
            $transaction->amount        = $participant->budget;
            $transaction->post_balance  = $influencer->balance;
            $transaction->charge        = 0;
            $transaction->trx_type      = '+';
            $transaction->details       = 'Campaign job completed';
            $transaction->trx           = getTrx();
            $transaction->remark        = 'campaign_completed';
            $transaction->save();

            notify(@$influencer, 'CAMPAIGN_JOB_COMPLETED', [
                'influencer'         => @$influencer->username,
                'brand'              => $participant->campaign->user->username,
                'participant_number' => $participant->participant_number,
                'budget'             => showAmount($participant->budget,currencyFormat:false),
                'trx'                => $transaction->trx,
            ]);
        }

        recentActivity('You have decided your campaign job is completed', @$campaign->user->id);
        recentActivity(@$campaign->user->username . ' has decided campaign job is completed', 0, $influencer->id);

        $notify[] = ['success', 'The campaign job completed successfully'];
        return back()->withNotify($notify);

    }
    public function reported(Request $request, $id) {
        $request->validate([
            'report_reason' => 'required|string',
        ]);

        $participant                = Participant::delivered()->authCampaign()->with('influencer')->findOrFail($id);
        $participant->report_reason = $request->report_reason;
        $participant->status        = Status::CAMPAIGN_JOB_REPORTED;
        $participant->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $participant->campaign->user_id;
        $adminNotification->title     = 'Campaign job is reported by ' . $participant->campaign->user->username;
        $adminNotification->click_url = route('admin.campaign.conversation', $participant->id);
        $adminNotification->save();

        notify(@$participant->influencer, 'CAMPAIGN_JOB_REPORTED', [
            'influencer'         => @$participant->influencer->username,
            'brand'              => $participant->campaign->user->username,
            'participant_number' => $participant->participant_number,
            'title'              => $participant->campaign->title,
            'reason'             => $participant->report_reason,
        ]);

        $brand = $participant->campaign->user;
        recentActivity('You have reported on your campaign job', @$brand->id);
        recentActivity(@$brand->username . ' has reported campaign job', 0, @$participant->influencer->id);

        $notify[] = ['success', 'The campaign job reported to successfully'];
        return back()->withNotify($notify);
    }
}
