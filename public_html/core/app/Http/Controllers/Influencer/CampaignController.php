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

   

    public function participate(Request $request, $id) {
        $campaign   = Campaign::onGoing()->findOrFail(decrypt($id));
        $influencer = authInfluencer();
        $invitedCampaign = InviteCampaign::inactive()->where('influencer_id', $influencer->id)->where('campaign_id', $campaign->id)->first();

        if ($campaign->campaign_type != 'invite' || !$invitedCampaign) {
            $this->validation($campaign, $influencer);
        }

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
        $adminNotification->click_url     = urlPath('admin.campaign.participants', $campaign->id);
        $adminNotification->save();

        notify($campaign->user, 'CAMPAIGN_PARTICIPANT_REQUEST', [
            'brand'              => @$campaign->user->username,
            'influencer'         => $influencer->username,
            'participant_number' => $participant->participant_number,
            'title'              => $campaign->title,
        ]);

        notify($influencer, 'PARTICIPATE_REQUEST_PENDING', [
            'influencer'         => $influencer->username,
            'brand'              => @$campaign->user->brand_name,
            'participant_number' => $participant->participant_number,
            'title'              => $campaign->title,
        ]);

        recentActivity('New participate request added your campaign', $campaign->user_id);
        recentActivity('Participate request sent successfully', 0, $influencer->id);

        // Auto-Archive Logic: If this was an Invite acceptance, close any open inquiries
        if ($campaign->campaign_type == 'invite') {
            Participant::where('influencer_id', $influencer->id)
                ->where('status', Status::PARTICIPATE_INQUIRY)
                ->whereHas('campaign', function($q) use ($campaign) {
                    $q->where('user_id', $campaign->user_id);
                })
                ->update(['status' => Status::CAMPAIGN_JOB_COMPLETED]);
        }

        $notify[] = ['success', 'Participate request sent successfully, wait for brand approval'];
        return back()->withNotify($notify);
    }

    protected function validation($campaign, $influencer) {
        // Stripe onboarding requirement removed to allow frictionless participation
        $gender = $campaign->influencer_requirements->gender;
        if (!in_array($influencer->gender, $gender)) {
            throw ValidationException::withMessages(["error" => "Doesn't match the target gender"]);
        }
        if (!$influencer->socialLink) {
            throw ValidationException::withMessages(["error" => "You have to connect social link"]);
        }
        foreach ($campaign->platforms as $platform) {
            $social = $influencer->socialLink()->where('platform_id', $platform->id)->first();
            if (!$social) {
                throw ValidationException::withMessages(["error" => "You don't have $platform->name follower"]);
            }
            $startFollowerRange = 'follower_' . strtolower($platform->name) . '_start';
            $endFollowerRange   = 'follower_' . strtolower($platform->name) . '_end';
            $campaignStartRange = $campaign->influencer_requirements->$startFollowerRange;
            $campaignEndRange   = $campaign->influencer_requirements->$endFollowerRange;

            if ($campaignStartRange > $social->followers) {
                throw ValidationException::withMessages(["error" => "You don't apply because of $platform->name follower's limitation"]);
            }
            if ($social->followers > $campaignEndRange) {
                throw ValidationException::withMessages(["error" => "You don't apply because of $platform->name follower's limitation"]);
            }
        }
    }

    public function log(Request $request) {
        $pageTitle    = 'My Campaigns';
        $participates = Participant::where('influencer_id', authInfluencerId());
        
        if ($request->status && $request->status != 'all') {
            $status = $request->status;
            $participates->$status();
        }

        $allParticipates = (clone $participates)->with('campaign.user')->searchable(['participant_number', 'campaign.user:brand_name'])->orderBy('id', 'desc')->get();
        
        $generalCampaigns = $allParticipates->filter(function($p) {
            return $p->campaign->campaign_type == 'general';
        });

        $directWorkstreams = $allParticipates->filter(function($p) {
            return $p->campaign->campaign_type != 'general';
        })->groupBy(function($p) {
            return $p->campaign->user_id;
        });

        $participates = $participates->with('campaign.user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::influencer.campaign.log', compact('pageTitle', 'participates', 'generalCampaigns', 'directWorkstreams'));
    }

    public function view($id) {
        $participate = Participant::where('influencer_id', authInfluencerId())->with('campaign')->findOrFail($id);
        $pageTitle   = 'Campaign - ' . $participate->participant_number;
        $campaign    = $participate->campaign;
        return view('Template::influencer.campaign.view', compact('pageTitle', 'participate', 'campaign'));
    }

    public function detail($id) {
        $participant = Participant::where('influencer_id', authInfluencerId())->with('campaign')->findOrFail($id);
        $pageTitle   = 'Detail Campaign - ' . $participant->participant_number;
        return view('Template::influencer.campaign.detail', compact('pageTitle', 'participant'));
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
        // ... rest of cancel function ...
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

            notify($brand, 'CAMPAIGN_JOB_CANCELED', [
                'title'              => $campaign->title,
                'brand'              => $brand->username,
                'influencer'         => $participant->influencer->username,
                'participant_number' => $participant->participant_number,
                'budget'             => showAmount($participant->budget,currencyFormat:false),
                'trx'                => $transaction->trx,
            ]);
        }

        recentActivity('Influencer canceled your campaign job', $participant->campaign->user_id);
        recentActivity('You have canceled the campaign job', 0, $participant->influencer_id);

        $notify[] = ['success', 'Campaign job canceled successfully'];
        return back()->withNotify($notify);
    }

    public function closeInquiry($id) {
        $participant = Participant::where('status', Status::PARTICIPATE_INQUIRY)
            ->where('influencer_id', authInfluencerId())
            ->findOrFail($id);

        $participant->status = Status::CAMPAIGN_JOB_COMPLETED;
        $participant->save();

        // Mark the shadow campaign as completed
        $participant->campaign->status = Status::CAMPAIGN_COMPLETED;
        $participant->campaign->save();

        $notify[] = ['success', 'Inquiry closed and archived successfully'];
        return back()->withNotify($notify);
    }

    public function invite() {
        $pageTitle       = 'Invited Campaigns';
        $inviteCampaigns = InviteCampaign::inactive()->where('influencer_id', authInfluencerId())->withWhereHas('campaign', function ($query) {
            $query->onGoing()->with('platforms')->withCount('participants');
        })->paginate(getPaginate());
        return view('Template::influencer.campaign.invite', compact('pageTitle', 'inviteCampaigns'));
    }
}