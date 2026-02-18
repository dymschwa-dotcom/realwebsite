<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Participant;
use App\Models\Review;
use App\Models\Transaction; // FIXED: Added Import
use App\Models\Influencer;  // FIXED: Added Import
use App\Traits\CampaignHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // FIXED: Added for Transaction safety

class CampaignController extends Controller {

    use CampaignHistory;
    public $activeTemplate;

    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }

    /**
     * Brand Campaign History
     */
    public function history() {
        $pageTitle = 'Campaign History';
        $user      = auth()->user();
        
        $query = Campaign::where('user_id', $user->id);
        $allCount = (clone $query)->count();

        if (request()->routeIs('user.campaign.pending')) {
            $pageTitle = 'Pending Campaigns';
            $query = $query->where('status', Status::CAMPAIGN_PENDING);
        } elseif (request()->routeIs('user.campaign.approved')) {
            $pageTitle = 'Approved Campaigns';
            $query = $query->where('status', Status::CAMPAIGN_APPROVED);
        } elseif (request()->routeIs('user.campaign.rejected')) {
            $pageTitle = 'Rejected Campaigns';
            $query = $query->where('status', Status::CAMPAIGN_REJECTED);
        }

        $campaigns = $query->withCount('participants')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        return view($this->activeTemplate . 'user.campaign.history', compact('pageTitle', 'campaigns', 'allCount'));
    }

    /**
     * Update Custom Proposal Status (The Accept/Reject Logic)
     */
    public function updateProposalStatus(Request $request) {
        $request->validate([
            'participant_id' => 'required|integer',
            'status'         => 'required|in:accept,reject'
        ]);

        $participant = Participant::findOrFail($request->participant_id);
        $user = auth()->user();

        if ($request->status == 'accept') {
            // 1. Balance Check
            if ($user->balance < $participant->budget) {
                return response()->json(['status' => 'error', 'message' => 'Insufficient balance to accept this proposal.']);
            }

            try {
                // 2. Database Transaction for Atomicity
                DB::transaction(function() use ($user, $participant) {
                    // Deduct money
                    $user->balance -= $participant->budget;
                    $user->save();

                    // Update Participant status (1 = Approved/Active)
                    $participant->status = 1; 
                    $participant->save();

                    // Log Transaction
                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = $participant->budget;
                    $transaction->post_balance = $user->balance;
                    $transaction->charge = 0;
                    $transaction->trx_type = '-';
                    $transaction->details = 'Funded proposal for contract #' . $participant->participant_number;
                    $transaction->trx = getTrx();
                    $transaction->remark = 'proposal_payment';
                    $transaction->save();
                });

                // Return redirect URL for the frontend
                $redirectUrl = $participant->campaign_id 
                    ? route('user.campaign.view', ['id' => $participant->campaign_id]) 
                    : route('user.campaign.index');
                
                return response()->json([
                    'status'       => 'success', 
                    'message'      => 'Proposal accepted and funded successfully!',
                    'redirect_url' => $redirectUrl 
                ]);

            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
            }
        }

        if ($request->status == 'reject') {
            $participant->status = 3; // 3 = Rejected
            $participant->save();
            return response()->json(['status' => 'success', 'message' => 'Proposal rejected.']);
        }
    }

    /**
     * Campaign Creation Wizard Steps
     */
    public function create($step = 0, $slug = null) {
        $pageTitle = 'Create Campaign';
        $step      = (int) $step; 
        
        $isInfluencer = auth()->guard('influencer')->check();
        $userId       = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();
        $userColumn   = $isInfluencer ? 'influencer_id' : 'user_id';

        $campaign = null;
        if ($slug) {
            $campaign = Campaign::where($userColumn, $userId)->where('slug', $slug)->first();
        }

        // If influencer is starting fresh, allow capturing conversation context
        if ($isInfluencer && request()->has('conversation_id')) {
            session()->put('active_conversation_id', request()->conversation_id);
        }

        $categories   = Category::active()->orderBy('name')->get();
        $allPlatform  = Platform::active()->orderBy('name')->get();
        
        return view($this->activeTemplate . 'user.campaign.create', compact('pageTitle', 'categories', 'allPlatform', 'step', 'campaign'));
    }

    public function basic(Request $request, $slug = null) {
        try {
            $request->validate([
                'title'         => 'required|string|max:255',
                'campaign_type' => 'required',
                'payment_type'  => 'required',
                'platform'      => 'required|array', 
            ]);

            $isInfluencer = auth()->guard('influencer')->check();
            $userId       = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();
            $userColumn   = $isInfluencer ? 'influencer_id' : 'user_id';

            $campaign = Campaign::where($userColumn, $userId)->where('slug', $slug)->first() ?? new Campaign();
            
            if ($isInfluencer) {
                $campaign->influencer_id = $userId;
                // Since this is created by an influencer, it's a private proposal
                $campaign->is_private = 1;

                // Try to find the Brand ID from the active conversation
                if (session()->has('active_conversation_id')) {
                    $conversation = \App\Models\Conversation::find(session()->get('active_conversation_id'));
                    if ($conversation) {
                        $campaign->user_id = $conversation->user_id;
                    }
                }
            } else {
                $campaign->user_id = $userId;
            }

            $campaign->title         = $request->title; 
            $campaign->campaign_type = $request->campaign_type;
            $campaign->payment_type  = $request->payment_type;

            if (!$campaign->exists) {
                $campaign->slug = Str::slug($request->title) . '-' . time();
            }
            
            $campaign->save();
            $campaign->platforms()->sync($request->platform);
            
            return response()->json([
                'status'        => 'success',
                'step'          => 1,
                'html'          => view($this->activeTemplate . 'partials.campaign.content', compact('campaign'))->render(),
                'campaign_slug' => (string) $campaign->slug 
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function content(Request $request, $slug) {
        try {
            $isInfluencer = auth()->guard('influencer')->check();
            $userId       = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();
            $userColumn   = $isInfluencer ? 'influencer_id' : 'user_id';

            $campaign = Campaign::where($userColumn, $userId)->where('slug', $slug)->firstOrFail();
            $requirements = [
                'facebook_type'         => $request->facebook_type,
                'facebook_placement'    => $request->facebook_placement,
                'facebook_post_count'   => $request->facebook_post_count,
                'instagram_type'        => $request->instagram_type,
                'instagram_placement'   => $request->instagram_placement,
                'instagram_post_count'  => $request->instagram_post_count,
                'tiktok_type'           => $request->tiktok_type,
                'tiktok_placement'      => $request->tiktok_placement,
                'tiktok_video_count'    => $request->tiktok_video_count,
                'youtube_type'          => $request->youtube_type,
                'youtube_placement'     => $request->youtube_placement,
                'youtube_video_count'   => $request->youtube_video_count,
                'video_length'          => $request->video_length,
            ];
            $campaign->content_requirements = json_encode($requirements);
            $campaign->save();

            $tags = Category::active()->orderBy('name')->get(); 
            return response()->json([
                'status'        => 'success',
                'step'          => 2,
                'html'          => view($this->activeTemplate . 'partials.campaign.description', compact('campaign', 'tags'))->render(),
                'campaign_slug' => $campaign->slug
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function previous($step, $slug = null) {
        $step = (int) $step;
        $step--;

        if ($step < 0) {
            $step = 0; // Prevent going to negative steps
        }

        // Specific logic for BRAND "previous" action
        return redirect()->route('user.campaign.create', ['step' => $step, 'slug' => $slug]);
    }
}

