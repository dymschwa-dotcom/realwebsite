<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Influencer;
use App\Models\InviteCampaign;
use App\Models\Platform;
use App\Models\Tag;
use App\Rules\FileTypeValidate;
use App\Traits\CampaignHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller {

    public function index() {
        $pageTitle = 'Campaign History';
        $user = auth()->user();

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
        $directWorkstreams = \App\Models\Participant::whereHas('campaign', function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('campaign_type', 'invite'); // Shadow campaigns
            })
            ->whereNotIn('status', [Status::PARTICIPATE_REQUEST_REJECTED]) // Exclude dead ends
            ->with(['influencer', 'campaign'])
            ->get()
            ->groupBy('influencer_id');

        // Existing search/filter logic for the table (kept for backward compatibility or "All" view)
        $campaigns = Campaign::where('user_id', $user->id);
        if (request()->search) {
            $search = request()->search;
            $campaigns = $campaigns->where('title', 'like', "%$search%");
        }
        $campaigns = $campaigns->with('participants')->latest()->paginate(getPaginate());

        return view('Template::user.campaign.history', compact('pageTitle', 'campaigns', 'generalCampaigns', 'directWorkstreams'));
    }

    public function create($step = 0, $slug = null, $edit = null) {
        $pageTitle   = 'Create Campaign';
        $tags        = Tag::active()->orderBy('name')->get();
        $allPlatform = Platform::active()->orderBy('name')->get();
        $brand       = auth()->user();
        $campaign    = null;

        // Check if we are coming from a specific inquiry/chat
        $participantId = request()->participant_id;

        $incompleteCampaign = Campaign::where('user_id', auth()->id())->inCompleted()->latest()->first();
        if ($incompleteCampaign && !$slug && !$participantId) {
            $campaign = $incompleteCampaign;
            $step     = $campaign->campaign_step;
        }

        if ($slug) {
            // Allow editing of inquiries (Status Approved)
            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->firstOrFail();
            $step     = $edit ? 0 : $campaign->campaign_step;
        }

        $categories = Category::active()->orderBy('name')->get();
        return view('Template::user.campaign.create', compact('pageTitle', 'tags', 'brand', 'allPlatform', 'step', 'campaign', 'categories', 'participantId'));
    }

    public function basic(Request $request, $slug = null) {
        $invalid = $this->basicDataValidation($request, $slug);
        if ($invalid['status']) {
            return response()->json(['error' => $invalid['message']]);
        }

        $campaign = $this->insertBasicData($request, $slug);

        if ($campaign['status']) {
            return response()->json(['error' => $invalid['message']]);
        }

        $campaign = $campaign['data'];

        if ($slug) {
            $campaign->platforms()->sync($request->platform);
        } else {
            $campaign->platforms()->attach($request->platform);
        }

        $html = view('Template::partials.campaign.content', compact('campaign'))->render();
        return response()->json([
            'step'          => $campaign->campaign_step,
            'html'          => $html,
            'campaign_slug' => $campaign->slug,
        ]);
    }

    protected function basicDataValidation($request, $slug) {
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|max:255',
            'platform'        => 'required|array|in:1,2,3,4',
            'campaign_type'   => 'required|string|in:general,invite',
            'payment_type'    => 'required|string|in:paid,giveway',
            'promoting_type'  => 'required|string|in:physical,digital',
            'send_product'    => 'required|string|in:yes,no',
            'content_creator' => 'required|string|in:influencer,yourself',
            'monetary_value'  => 'required_if:send_product,yes|nullable|numeric|gte:0',
            'image'           => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'content'         => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'txt', 'zip'])],
        ]);
        if ($validator->fails()) {
            return ['status' => true, 'message' => $validator->errors()->all()];
        }
        return ['status' => false];
    }

    protected function insertBasicData($request, $slug) {
        if ($slug) {
            $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->first();
            if (!$campaign) {
                return ['status' => true, 'message' => 'Campaign not found'];
            }
        } else {
            $campaign          = new Campaign();
            $campaign->user_id = auth()->id();
            $campaign->slug    = titleToKey(slug($request->title) . '-' . getTrx(6));
        }

        $campaign->title          = $request->title;
        $campaign->campaign_type  = $request->campaign_type;
        $campaign->payment_type   = $request->payment_type;
        $campaign->promoting_type = $request->promoting_type;
        $campaign->send_product   = $request->send_product;

        if ($request->send_product == 'yes') {
            $campaign->monetary_value = $request->monetary_value;
        } else {
            $campaign->monetary_value = 0;
        }

        $campaign->content_creator = $request->content_creator;
        $campaign->campaign_step   = Status::CAMPAIGN_CONTENT;

        if ($request->hasFile('image')) {
            try {
                $campaign->image = fileUploader($request->image, getFilePath('campaign'), getFileSize('campaign'), @$campaign->image);
            } catch (\Exception $e) {
                return ['status' => true, 'message' => 'Image could not be uploaded'];
            }
        }

        if ($request->hasFile('content') && $request->content_creator == 'yourself') {
            try {
                $campaign->content = fileUploader($request->content, getFilePath('content'), null, @$campaign->content);
            } catch (\Exception $e) {
                return ['status' => true, 'message' => 'File could not be uploaded'];
            }
        } else {
            if (@$campaign->content) {
                $filePath = getFilePath('content') . '/' . @$campaign->content;
                if ($filePath) {
                    unlink($filePath);
                }
                $campaign->content = null;
            }
        }

        $campaign->save();
        return ['status' => false, 'data' => $campaign];
    }

    public function content(Request $request, $slug) {
        $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->first();
        if (!$campaign) {
            return response()->json(['error' => 'Campaign not found']);
        }

        $isFacebookRequired  = in_array(1, $campaign->platformId) ? 'required' : 'nullable';
        $isInstagramRequired = in_array(2, $campaign->platformId) ? 'required' : 'nullable';
        $isYoutubeRequired   = in_array(3, $campaign->platformId) ? 'required' : 'nullable';
        $isTiktokRequired    = in_array(4, $campaign->platformId) ? 'required' : 'nullable';

        $validator = Validator::make($request->all(), [
            'facebook_type'        => "$isFacebookRequired|array|in:photo,video,text",
            'facebook_placement'   => "$isFacebookRequired|array|in:post,story,reels",
            'facebook_post_count'  => "$isFacebookRequired|integer|gt:0",

            'instagram_type'       => "$isInstagramRequired|array|in:photo,video,text",
            'instagram_placement'  => "$isInstagramRequired|array|in:post,story,reels",
            'instagram_post_count' => "$isInstagramRequired|integer|gt:0",

            'youtube_placement'    => "$isYoutubeRequired|array|in:video,short_video",
            'youtube_video_count'  => "$isYoutubeRequired|integer|gt:0",

            'tiktok_type'          => "$isTiktokRequired|array|in:video",
            'tiktok_placement'     => "$isTiktokRequired|array|in:video",
            'tiktok_video_count'   => "$isTiktokRequired|integer|gt:0",

            'video_length'         => 'nullable|integer|gt:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $contentRequirements = [
            'facebook_type'        => @$request->facebook_type,
            'facebook_placement'   => @$request->facebook_placement,
            'facebook_post_count'  => @$request->facebook_post_count,
            'instagram_type'       => @$request->instagram_type,
            'instagram_placement'  => @$request->instagram_placement,
            'instagram_post_count' => @$request->instagram_post_count,
            'youtube_placement'    => @$request->youtube_placement,
            'youtube_video_count'  => @$request->youtube_video_count,
            'tiktok_type'          => @$request->tiktok_type,
            'tiktok_placement'     => @$request->tiktok_placement,
            'tiktok_video_count'   => @$request->tiktok_video_count,
            'video_length'         => @$request->video_length,
        ];
        $campaign->content_requirements = $contentRequirements;
        $campaign->campaign_step        = Status::CAMPAIGN_ABOUT;
        $campaign->save();

        $tags = Tag::active()->orderBy('name')->get();
        $html = view('Template::partials.campaign.description', compact('campaign', 'tags'))->render();
        return response()->json([
            'step'          => $campaign->campaign_step,
            'html'          => $html,
            'campaign_slug' => $campaign->slug,
        ]);
    }

    public function description(Request $request, $slug) {
        $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->first();
        if (!$campaign) {
            return response()->json(['error' => 'Campaign not found']);
        }

        $validator = Validator::make($request->all(), [
            'description'      => 'required|string',
            'review_process'   => 'required|string',
            'approval_process' => 'required|string',
            'tags'             => 'nullable|array',
            'hash_tags'        => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $purifier                   = new \HTMLPurifier();
        $campaign->description      = htmlspecialchars_decode($purifier->purify($request->description));
        $campaign->review_process   = $request->review_process;
        $campaign->approval_process = $request->approval_process;
        $campaign->campaign_step    = Status::CAMPAIGN_INFLUENCER;
        $campaign->hash_tags        = $request->hash_tags ?? [];
        $campaign->save();

        $tagId = [];
        if ($request->tags) {
            foreach ($request->tags as $tag) {
            $tagExist = Tag::where('name', $tag)->first();
            if ($tagExist) {
                $tagId[] = $tagExist->id;
            } else {
                $newTag       = new Tag();
                $newTag->name = $tag;
                $newTag->save();
                $tagId[] = $newTag->id;
            }
        }
        }
        $campaign->tags()->sync($tagId);
        $categories = Category::active()->orderBy('name')->get();
        $html       = view('Template::partials.campaign.requirement', compact('campaign', 'categories'))->render();
        return response()->json([
            'step'          => $campaign->campaign_step,
            'html'          => $html,
            'campaign_slug' => $campaign->slug,
        ]);
    }

    public function requirement(Request $request, $slug) {
        $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->first();
        if (!$campaign) {
            return response()->json(['error' => 'Campaign not found']);
        }
        $isFacebookRequired  = in_array(1, $campaign->platformId) ? 'required' : 'nullable';
        $isInstagramRequired = in_array(2, $campaign->platformId) ? 'required' : 'nullable';
        $isYoutubeRequired   = in_array(3, $campaign->platformId) ? 'required' : 'nullable';
        $isTiktokRequired    = in_array(4, $campaign->platformId) ? 'required' : 'nullable';

        $validator = Validator::make($request->all(), [
            'category_id'              => 'required|array|min:1',
            'required_influencer'      => 'required|integer|gt:0',
            'gender'                   => 'required|array|min:1|in:male,female,other',
            'follower.facebook_start'  => "$isFacebookRequired|integer|gt:0",
            'follower.facebook_end'    => "$isFacebookRequired|integer|gt:follower.facebook_start",
            'follower.instagram_start' => "$isInstagramRequired|integer|gt:0",
            'follower.instagram_end'   => "$isInstagramRequired|integer|gt:follower.instagram_start",
            'follower.youtube_start'   => "$isYoutubeRequired|integer|gt:0",
            'follower.youtube_end'     => "$isYoutubeRequired|integer|gt:follower.youtube_start",
            'follower.tiktok_start'    => "$isTiktokRequired|integer|gt:0",
            'follower.tiktok_end'      => "$isTiktokRequired|integer|gt:follower.tiktok_start",
        ], [
            'follower.facebook_start'  => 'Follower range must be integer',
            'follower.facebook_end'    => 'Facebook follower range must be greater than start range',
            'follower.instagram_start' => 'Follower range must be integer',
            'follower.instagram_end'   => 'Instagram follower range must be greater than start range',
            'follower.youtube_start' => 'Follower range must be integer',
            'follower.youtube_end'     => 'Youtube follower range must be greater than start range',
            'follower.tiktok_start'    => 'Follower range must be integer',
            'follower.tiktok_end'      => 'TikTok follower range must be greater than start range',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $follower              = (object) $request->follower;
        $influencerRequirement = [
            'required_influencer'      => $request->required_influencer,
            'gender'                   => $request->gender,
            'follower_facebook_start'  => @$follower->facebook_start,
            'follower_facebook_end'    => @$follower->facebook_end,
            'follower_instagram_start' => @$follower->instagram_start,
            'follower_instagram_end'   => @$follower->instagram_end,
            'follower_youtube_start'   => @$follower->youtube_start,
            'follower_youtube_end'     => @$follower->youtube_end,
            'follower_tiktok_start'    => @$follower->tiktok_start,
            'follower_tiktok_end'      => @$follower->tiktok_end,
        ];

        $campaign->influencer_requirements = $influencerRequirement;
        $campaign->campaign_step           = Status::CAMPAIGN_BUDGET;
        $campaign->save();

        $activeCategories = Category::active()->whereIn('id', $request->category_id)->pluck('id');
        $campaign->categories()->sync($activeCategories);

        $html = view('Template::partials.campaign.budget', compact('campaign'))->render();
        return response()->json([
            'step'          => $campaign->campaign_step,
            'html'          => $html,
            'campaign_slug' => $campaign->slug,
        ]);
    }

    public function budget(Request $request, $slug) {
        $campaign = Campaign::where('user_id', auth()->id())->where('slug', $slug)->first();
        if (!$campaign) {
            return response()->json(['error' => 'Campaign not found']);
        }

        $budgetValidate = $campaign->payment_type == 'paid' ? 'required' : 'nullable';

        $validator = Validator::make($request->all(), [
            'budget'     => "$budgetValidate|numeric|gt:0",
            'start_date' => 'required|date_format:Y-m-d|after:yesterday',
            'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $campaign->budget     = @$request->budget ?? 0;
        $campaign->start_date = $request->start_date;
        $campaign->end_date   = $request->end_date;

        if (gs('campaign_approve')) {
            $campaign->status = Status::CAMPAIGN_APPROVED;
        } else {
            $campaign->status = Status::CAMPAIGN_PENDING;
        }

        $campaign->save();

        // Check if this campaign is linked to an Inquiry
        $participant = \App\Models\Participant::where('campaign_id', $campaign->id)->where('status', Status::PARTICIPATE_INQUIRY)->first();

        if ($participant) {
            // If it's an inquiry, the campaign is already "Approved".
            // We just need to handle the redirect back to the chat.
            return response()->json(['redirect_url' => route('user.participant.conversation.inbox', $participant->id)]);
        }

        $user      = $campaign->user;
        $shortCode = [
            'username'   => $user->username,
            'title'      => $campaign->title,
            'budget'     => showAmount($campaign->budget, currencyFormat: false),
            'start_date' => $campaign->start_date,
            'end_date'   => $campaign->end_date,
        ];

        if ($campaign->status == Status::CAMPAIGN_PENDING) {
            $adminNotification            = new AdminNotification();
            $adminNotification->user_id   = $user->id;
            $adminNotification->title     = 'New campaign request from ' . $user->username;
            $adminNotification->click_url = urlPath('admin.campaign.detail', $campaign->id);
            $adminNotification->save();
            notify($user, 'CAMPAIGN_REQUEST_PENDING', $shortCode);
            recentActivity('Campaign request is pending', $user->id);
        } else {
            notify($user, 'CAMPAIGN_REQUEST_APPROVED', $shortCode);
        }

        return response()->json(['redirect_url' => route('user.campaign.index')]);
    }

    public function view($id) {
        $pageTitle = 'Campaign Information';
        $campaign  = Campaign::where('user_id', auth()->id())->findOrFail($id);
        return view('Template::user.campaign.view', compact('pageTitle', 'campaign'));
    }

    public function inviteForm() {
        $campaign  = Campaign::ongoing()->invite()->where('user_id', auth()->id())->firstOrFail();
        $pageTitle = 'Invite for Campaign';
        return view('Template::user.campaign.invite_form', compact('pageTitle', 'campaign'));
    }

    public function getInfluencerUsername(Request $request) {
        $username    = trim($request->term);
        $influencers = Influencer::active();
        if ($username) {
            $influencers->where('username', 'LIKE', "%$username%");
        }
        $influencers = $influencers->searchable(['username'])->select('id', 'username as text')->paginate(10);

        $morePages = true;
        if (empty($influencers->nextPageUrl())) {
            $morePages = false;
        }
        $results = [
            "results"    => $influencers->items(),
            "pagination" => ["more" => $morePages],
        ];
        return response()->json($results);
    }

    public function sendInviteRequest(Request $request, $id) {
        $request->validate([
            'influencer_id' => 'required|array|min:1',
        ]);

        $brand                    = auth()->user();
        $campaign                 = Campaign::onGoing()->invite()->where('user_id', $brand->id)->findOrFail($id);
        $existInvitedInfluencerId = InviteCampaign::where('campaign_id', $campaign->id)->pluck('influencer_id')->toArray();

        foreach ($request->influencer_id as $influencerId) {
            $influencer = Influencer::active()->where('id', $influencerId)->first();
            if (!$influencer || in_array($influencer->id, $existInvitedInfluencerId)) {
                continue;
            }

            $invite                = new InviteCampaign();
            $invite->campaign_id   = $campaign->id;
            $invite->influencer_id = $influencer->id;
            $invite->save();

            notify($influencer, 'SEND_INVITE_REQUEST', [
                'username' => $influencer->username,
                'title'    => $campaign->title,
                'end_date' => $campaign->end_date,
            ]);
        }

        recentActivity('Sent invite request for campaign', $brand->id);
        $notify[] = ['success', 'Invite request sent successfully'];
        return back()->withNotify($notify);
    }

    public function previous($step = null, $slug = null) {
        $campaign    = Campaign::where('user_id', auth()->id())->where('slug', $slug)->whereIn('status', [Status::CAMPAIGN_INCOMPLETE, Status::CAMPAIGN_PENDING])->first();
        $allPlatform = Platform::active()->orderBy('name')->get();
        $tags        = Tag::active()->orderBy('name')->get();
        $categories  = Category::active()->orderBy('name')->get();

        if (!$campaign) {
            return response()->json(['error' => 'Invalid Request']);
        }

        $html = view('Template::partials.campaign.' . $step, compact('campaign', 'allPlatform', 'tags', 'categories'))->render();
        return response()->json([
            'html'            => $html,
            'step'            => $campaign->campaign_step - 1,
            'campaign_slug'   => $campaign->slug,
            'send_product'    => $campaign->send_product,
            'content_creator' => $campaign->content_creator,
        ]);
    }
}

