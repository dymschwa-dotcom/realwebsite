<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Page;
use App\Models\Platform;
use App\Models\User;
use App\Models\Message; 
use App\Models\Conversation;
use App\Models\Participant;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CampaignController extends Controller {

    public $activeTemplate;

    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }

    /**
     * Display all public campaigns with filtering
     */
    public function all(Request $request) {
        $pageTitle  = 'All Campaign';
        $platforms  = Platform::active()->orderBy('name')->get();
        $campaigns  = Campaign::onGoing()->general()->where('is_private', 0); // EXCLUDE PRIVATE
        $campaigns  = $this->getFilterCampaign($campaigns, $platforms);
        
        $campaigns  = $campaigns->searchable(['title'])
            ->withCount('participants')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());
            
        $countries  = User::active()->whereHas('campaigns')->pluck('country_name')->unique();
        $categories = Category::active()->orderBy('name')->get();
        $sections   = Page::where('tempname', $this->activeTemplate)->where('slug', 'campaign')->first();
        
        return view($this->activeTemplate . 'campaigns', compact('pageTitle', 'campaigns', 'platforms', 'countries', 'categories', 'sections'));
    }

    /**
     * Display the list of all conversations for the authenticated user
     */
    public function conversationIndex() {
        $pageTitle = 'My Conversations';
        $isInfluencer = auth()->guard('influencer')->check();
        $authId = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();

        $query = Conversation::query();
        if ($isInfluencer) {
            $query->where('influencer_id', $authId)->with('user');
        } else {
            $query->where('user_id', $authId)->with('influencer');
        }

        $conversations = $query->with('lastMessage')
            ->orderBy('updated_at', 'desc')
            ->paginate(getPaginate());

        $view = $isInfluencer ? 'influencer.conversation.index' : 'user.conversation.index';
        return view($this->activeTemplate . $view, compact('pageTitle', 'conversations'));
    }

    /**
     * Shared Campaign Detail View (Slug Based)
     */
    public function detail($slug) {
        $campaign = Campaign::with(['platforms', 'categories', 'user', 'participants'])
            ->where('slug', $slug)
            ->firstOrFail();
            
        $pageTitle  = 'Campaign Detail';
        $influencer = auth()->guard('influencer')->user();
        $user       = auth()->user(); 

        abort_if(!$influencer && !$user && $campaign->campaign_type == 'invite', 404);

        $isOwner = $user && $user->id == $campaign->user_id;
        $alreadyApplied = false;

        if ($influencer) {
            $alreadyApplied = Participant::where('campaign_id', $campaign->id)
                ->where('influencer_id', $influencer->id)
                ->exists();
        }

        return view($this->activeTemplate . 'campaign_detail', compact('pageTitle', 'campaign', 'isOwner', 'alreadyApplied'));
    }

    /**
     * Send Message / Work Submission
     */
    public function sendMessage(Request $request) {
        $request->validate([
            'conversation_id' => 'required|integer',
            'campaign_id'     => 'nullable|integer',
            'message'         => 'nullable|string',
            'attachment'      => 'nullable|file|max:51200', 
        ]);

        $isInfluencer = auth()->guard('influencer')->check();
        $authId       = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();

        try {
            $conversation = Conversation::findOrFail($request->conversation_id);

            $message                  = new Message();
            $message->conversation_id = $conversation->id;
            $message->sender_id       = $authId;
            $message->sender_type     = $isInfluencer ? 'influencer' : 'user';
            $message->message         = $request->message;

            if ($request->hasFile('attachment')) {
                try {
                    $message->attachments = fileUploader($request->attachment, getFilePath('conversation'));
                } catch (\Exception $exp) {
                    return response()->json(['status' => 'error', 'message' => 'Could not upload your attachment']);
                }
            }

            $message->save();

            $conversation->updated_at = now();
            $conversation->save();

            $view = $isInfluencer ? 'influencer.conversation.last_message' : 'user.conversation.last_message';
            $message_html = view($this->activeTemplate . $view, compact('message'))->render();

            return response()->json([
                'status'       => 'success',
                'message_html' => $message_html,
                'last_id'      => $message->id
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * View a single conversation
     */
    public function viewConversation($id) {
        $pageTitle = 'View Conversation';
        $isInfluencer = auth()->guard('influencer')->check();
        $authId = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();

        $query = Conversation::where('id', $id);
        if ($isInfluencer) {
            $query->where('influencer_id', $authId);
        } else {
            $query->where('user_id', $authId);
        }

        $conversation = $query->with(['messages', 'user', 'influencer'])->firstOrFail();

        // Fetch conversations list for the sidebar
        $convQuery = Conversation::query();
        if ($isInfluencer) {
            $convQuery->where('influencer_id', $authId)->with('user');
        } else {
            $convQuery->where('user_id', $authId)->with('influencer');
        }
        $conversations = $convQuery->with('lastMessage')->orderBy('updated_at', 'desc')->get();

        // Mark messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_type', $isInfluencer ? 'user' : 'influencer')
            ->update(['is_read' => 1]);

        $view = $isInfluencer ? 'influencer.conversation.view' : 'user.conversation.view';
        return view($this->activeTemplate . $view, compact('pageTitle', 'conversation', 'conversations'));
    }

    /**
     * Download attachment
     */
    public function downloadAttachment($file) {
        $path = getFilePath('conversation');
        $fullPath = $path . '/' . $file;
        if (!file_exists($fullPath)) {
            abort(404);
        }
        return response()->download($fullPath);
    }

    /**
     * Get new messages for polling
     */
    public function getNewMessages(Request $request, $id) {
        $isInfluencer = auth()->guard('influencer')->check();
        $authId = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();

        $lastId = $request->last_id;
        $messages = Message::where('conversation_id', $id)
            ->where('id', '>', $lastId)
            ->where('sender_type', $isInfluencer ? 'user' : 'influencer')
            ->get();

        $html = '';
        $view = $isInfluencer ? 'influencer.conversation.last_message' : 'user.conversation.last_message';

        foreach ($messages as $message) {
            $html .= view($this->activeTemplate . $view, compact('message'))->render();
            $message->is_read = 1;
            $message->save();
        }

        return response()->json([
            'html'    => $html,
            'last_id' => $messages->count() > 0 ? $messages->last()->id : $lastId
        ]);
    }

    /**
     * Update work status (approve/reject/revision)
     */
    public function updateWorkStatus(Request $request) {
        $request->validate([
            'message_id' => 'required|integer',
            'status'     => 'required|in:approved,revision_requested,rejected'
        ]);

        $message = Message::findOrFail($request->message_id);
        $message->status = $request->status;
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Work status updated successfully'
        ]);
    }

    protected function getFilterCampaign($campaigns, $platforms) {
        if (request()->platform) {
            $campaigns = $campaigns->whereHas('platforms', function ($q) {
                $q->where('slug', request()->platform);
            });
        }
        if (request()->category) {
            $campaigns = $campaigns->whereHas('categories', function ($q) {
                $q->where('slug', request()->category);
            });
        }
        if (request()->country) {
            $campaigns = $campaigns->whereHas('user', function ($q) {
                $q->where('country_name', request()->country);
            });
        }
        return $campaigns;
    }
}

