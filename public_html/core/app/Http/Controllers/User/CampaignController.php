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

                return response()->json(['status' => 'success', 'message' => 'Proposal accepted and funded successfully!']);

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
        
        $campaign = null;
        if ($slug) {
            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->first();
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

            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->first() ?? new Campaign();
            $campaign->user_id       = auth()->id();
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
            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->firstOrFail();
            $requirements = [
                'facebook_type'         => $request->facebook_type,
                'facebook_placement'    => $request->facebook_placement,
                'facebook_post_count'   => $request->facebook_post_count,
                'instagram_type'        => $request->instagram_type,
                'instagram_placement'   => $request->instagram_placement,
                'instagram_post_count'  => $request->instagram_post_count,
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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function description(Request $request, $slug) {
        try {
            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->firstOrFail();
            $campaign->description      = $request->description;
            $campaign->review_process   = $request->review_process;
            $campaign->approval_process = $request->approval_process;
            $campaign->hash_tags        = $request->tags; 
            $campaign->save();

            $categories = Category::active()->orderBy('name')->get(); 
            return response()->json([
                'status'        => 'success',
                'step'          => 3,
                'html'          => view($this->activeTemplate . 'partials.campaign.requirement', compact('campaign', 'categories'))->render(),
                'campaign_slug' => $campaign->slug
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function requirement(Request $request, $slug) {
        try {
            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->firstOrFail();
            $reqData = [
                'gender'                   => $request->gender ?? [], 
                'required_influencer'      => (int) $request->required_influencer,
                'follower_facebook_start'  => $request->follower['facebook_start'] ?? 0,
                'follower_facebook_end'    => $request->follower['facebook_end'] ?? 0,
                'follower_instagram_start' => $request->follower['instagram_start'] ?? 0,
                'follower_instagram_end'   => $request->follower['instagram_end'] ?? 0,
                'follower_youtube_start'   => $request->follower['youtube_start'] ?? 0,
                'follower_youtube_end'     => $request->follower['youtube_end'] ?? 0,
            ];
            $campaign->influencer_requirements = $reqData;
            $campaign->save();

            return response()->json([
                'status'        => 'success',
                'step'          => 4,
                'html'          => view($this->activeTemplate . 'partials.campaign.budget', compact('campaign'))->render(),
                'campaign_slug' => $campaign->slug
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function budget(Request $request, $slug) {
        try {
            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->firstOrFail();
            $request->validate([
                'start_date' => 'required',
                'end_date'   => 'required',
                'budget'     => $campaign->payment_type == 'paid' ? 'required|numeric|gt:0' : 'nullable',
            ]);

            $campaign->start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
            $campaign->end_date   = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
            
            if ($campaign->payment_type == 'paid') {
                $campaign->budget = $request->budget;
            }

            $campaign->status = Status::CAMPAIGN_PENDING; 
            $campaign->save();

            return response()->json([
                'status'       => 'success',
                'message'      => 'Campaign created successfully!',
                'redirect_url' => route('user.campaign.index') 
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Submission failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a review for an influencer
     */
    public function storeReview(Request $request) {
        $request->validate([
            'rating'        => 'required|integer|min:1|max:5',
            'review'        => 'required|string|max:500',
            'campaign_id'   => 'required|integer',
            'influencer_id' => 'required|integer',
        ]);

        $user = auth()->user();
        $existingReview = Review::where('user_id', $user->id)
                                ->where('campaign_id', $request->campaign_id)
                                ->where('influencer_id', $request->influencer_id)
                                ->exists();

        if ($existingReview) {
            return back()->withNotify([['error', 'You have already reviewed this influencer for this campaign.']]);
        }

        $review = new Review();
        $review->user_id       = $user->id;
        $review->influencer_id = $request->influencer_id;
        $review->campaign_id   = $request->campaign_id;
        $review->rating        = $request->rating;
        $review->review        = $request->review;
        $review->save();

        $influencer = Influencer::find($request->influencer_id);
        if($influencer) {
            $avgRating = Review::where('influencer_id', $influencer->id)->avg('rating');
            $influencer->rating = $avgRating;
            $influencer->save();
        }

        return back()->withNotify([['success', 'Review submitted successfully!']]);
    }
}