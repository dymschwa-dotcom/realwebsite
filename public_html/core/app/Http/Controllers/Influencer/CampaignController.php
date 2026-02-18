<?php

namespace App\Http\Controllers\Influencer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Campaign;
use App\Models\InviteCampaign;
use App\Models\Participant;
use App\Models\Transaction;
use App\Traits\ConversationForCampaign;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampaignController extends Controller {
    use ConversationForCampaign;

    public function __construct() {
        $this->activeTemplate = activeTemplate();
        $this->middleware(function ($request, $next) {
            $this->user = authInfluencer();
            return $next($request);
        });
        $this->userType = 'influencer';
    }

    public function campaignLog(Request $request) {
        return $this->log($request);
    }

    public function showProposalForm($id) {
        $campaign  = Campaign::onGoing()->findOrFail($id);
        $pageTitle = 'Submit Proposal';
        $influencer = $this->user;

        $alreadyApplied = Participant::where('campaign_id', $campaign->id)
            ->where('influencer_id', $influencer->id)
            ->exists();

        if ($alreadyApplied) {
            $notify[] = ['error', 'You have already submitted a proposal for this campaign.';
            return back()->withNotify($notify);
        }

        return view($this->activeTemplate . 'influencer.campaign.propose', compact('campaign', 'pageTitle'));
    }

    public function participate(Request $request, $id) {
        $campaign   = Campaign::onGoing()->findOrFail(decrypt($id));
        $influencer = authInfluencer();
        $this->validation($campaign, $influencer);

        if ($campaign->payment_type == 'paid') {
            $request->validate([
                'budget' => "required|numeric|lte:$campaign->budget",
            ]);
        }

        $isPreviousApplied = Participant::where('influencer_id', $influencer->id)->where('campaign_id', $campaign->id)->exists();
        if ($isPreviousApplied) {
            $notify[] = ['error', 'You already participated in this campaign'];
            return back()->withNotify($notify);
        }

        $invitedCampaign = InviteCampaign::inactive()->where('influencer_id', $influencer->id)->where('campaign_id', $campaign->id)->first();
        if ($invitedCampaign) {
            $invitedCampaign->status = Status::ENABLE;
            $invitedCampaign->save();
        }

        $participant                = new Participant();
        $participant->influencer_id = $influencer->id;
        $participant->campaign_id   = $campaign->id;
        if ($campaign->payment_type == 'paid') {
            $participant->budget = $request->budget;
        }
        $participant->participant_number = getTrx();
        $participant->save();

        $adminNotification                = new AdminNotification();
        $adminNotification->influencer_id = $influencer->id;
        $adminNotification->title         = 'New participate request for campaign';
        $adminNotification->click_url      = urlPath('admin.campaign.participants', $campaign->id);
        $adminNotification->save();

        notify($campaign->user, 'CAMPAIGN_PARTICIPANT_REQUEST', [
            'brand'              => @$campaign->user->username,
            'influencer'         => $influencer->username,
            'participant_number' => $participant->participant_number,
            'title'              => $campaign->title,
        ]);

        recentActivity('New participate request added your campaign', $campaign->user_id);
        recentActivity('Participate request sent successfully', 0, $influencer->id);

        $notify[] = ['success', 'Participate request sent successfully, wait for brand approval'];
        return back()->withNotify($notify);
    }

    protected function validation($campaign, $influencer) {
        $gender = $campaign->influencer_requirements->gender;
        if (!in_array($influencer->gender, $gender)) {
            throw ValidationException::withMessages(["Doesn't match the target gender"]);
        }
        if (!$influencer->socialLink) {
            throw ValidationException::withMessages(["You have to connect social link"]);
        }
        if (!$influencer->kv) {
             throw ValidationException::withMessages(["You must complete KYC verification first."]);
        }
    }

    public function log(Request $request) {
        $pageTitle    = 'My Campaigns';
        $participates = Participant::where('influencer_id', authInfluencerId());
        
        if ($request->status && $request->status != 'all') {
            $status = $request->status;
            $participates->$status();
        }

        $campaigns = $participates->with('campaign.user')
            ->searchable(['participant_number', 'campaign.user:brand_name'])
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        return view($this->activeTemplate . 'influencer.campaign.log', compact('pageTitle', 'campaigns'));
    }

    public function view($id) {
        $participate = Participant::where('influencer_id', authInfluencerId())->with('campaign')->findOrFail($id);
        $pageTitle   = 'Campaign - ' . $participate->participant_number;
        $campaign    = $participate->campaign;
        return view($this->activeTemplate . 'influencer.campaign.view', compact('pageTitle', 'participate', 'campaign'));
    }

    public function detail($id) {
        $participant = Participant::where('influencer_id', authInfluencerId())->with('campaign')->findOrFail($id);
        $pageTitle   = 'Detail Campaign - ' . $participant->participant_number;
        return view($this->activeTemplate . 'influencer.campaign.detail', compact('pageTitle', 'participant'));
    }

    public function deliver($id) {
        $participant         = Participant::accepted()->where('influencer_id', authInfluencerId())->findOrFail($id);
        $participant->status = Status::CAMPAIGN_JOB_DELIVERED;
        $participant->save();

        notify($participant->campaign->user, 'CAMPAIGN_JOB_DELIVERED', [
            'brand'              => $participant->campaign->user->username,
            'influencer'         => $participant->influencer->username,
            'title'              => $participant->campaign->title,
            'participant_number' => $participant->participant_number,
        ]);

        recentActivity('Influencer delivered your campaign job', $participant->campaign->user_id);
        recentActivity('You have delivered the campaign job', 0, $participant->influencer_id);

        $notify[] = ['success', 'Campaign job delivered successfully'];
        return back()->withNotify($notify);
    }

    public function cancel($id) {
        $participant         = Participant::accepted()->where('influencer_id', authInfluencerId())->findOrFail($id);
        $participant->status = Status::CAMPAIGN_JOB_CANCELED;
        $participant->save();

        $campaign = $participant->campaign;

        if ($campaign->payment_type == 'paid') {
            $brand = $campaign->user;
            $brand->balance += $participant->budget;
            $brand->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $brand->id;
            $transaction->amount       = $participant->budget;
            $transaction->post_balance = $brand->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Influencer canceled the campaign job';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'campaign_cancel';
            $transaction->save();
        }

        recentActivity('Influencer canceled your campaign job', $participant->campaign->user_id);
        recentActivity('You have canceled the campaign job', 0, $participant->influencer_id);

        $notify[] = ['success', 'Campaign job canceled successfully'];
        return back()->withNotify($notify);
    }

    public function invite() {
        $pageTitle       = 'Invited Campaigns';
        $inviteCampaigns = InviteCampaign::inactive()->where('influencer_id', authInfluencerId())->withWhereHas('campaign', function ($query) {
            $query->onGoing()->with('platforms')->withCount('participants');
        })->paginate(getPaginate());
        return view($this->activeTemplate . 'influencer.campaign.invite', compact('pageTitle', 'inviteCampaigns'));
    }

  public function inviteSubmit(Request $request) {
    // 1. Validate
    $request->validate([
        'campaign_id'     => 'nullable|integer',
        'conversation_id' => 'required|integer',
        'message'         => 'required|string',
        'budget'          => 'required|numeric|min:1',
        'title'           => 'required|string|max:255',
    ]);

    $influencer = authInfluencer();

    // 2. Create Participant Record (The Contract)
    $participant                     = new Participant();
    $participant->influencer_id      = $influencer->id;
    $participant->campaign_id        = $request->campaign_id ?: null;
    $participant->budget             = $request->budget;
    $participant->participant_number = getTrx();
    $participant->invitation_letter  = $request->title;
    $participant->status             = 0;
    $participant->save();

    // 3. MANUAL MESSAGE SAVE (Don't use Trait functions here)
    $message = new \App\Models\Message();
    $message->conversation_id = $request->conversation_id;
    $message->sender_id       = $influencer->id;
    $message->sender_type     = 'influencer';
    $message->message         = $request->title; 
    $message->type            = 'contract_proposal'; // <--- THIS MUST BE HERE
    $message->participant_id  = $participant->id;
    $message->save();

    // 4. Return JSON for AJAX
    return response()->json([
        'status'       => 'success',
        'message'      => 'Proposal sent!',
        'message_html' => view($this->activeTemplate . 'partials.message_bubble', ['message' => $message])->render(),
        'last_id'      => $message->id
    ]);
}

    public function previous($step, $slug = null) {
        $step = (int) $step;
        $step--;

        if ($step < 0) {
            $step = 0;
        }

        // Specific logic for INFLUENCER "previous" action
        return redirect()->route('influencer.campaign.create.wizard', ['step' => $step, 'slug' => $slug]);
    }
}

