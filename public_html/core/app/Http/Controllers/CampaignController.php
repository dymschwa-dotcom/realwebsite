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
        $campaigns  = Campaign::onGoing()->general();
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
     * FIXED: Returns keys 'message_html' and 'last_id' to match your Blade JS
     */
    public function sendMessage(Request $request) {
        $request->validate([
            'conversation_id' => 'required|integer',
            'campaign_id'     => 'required|integer',
            'message'         => 'nullable|string',
            'attachment'      => 'nullable|file|max:51200', 
        ]);

        $isInfluencer = auth()->guard('influencer')->check();
        $authId       = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();
        $authType     = $isInfluencer ? 'influencer' : 'user';

        $message = new Message();
        $message->conversation_id = $request->conversation_id;
        $message->campaign_id     = $request->campaign_id;
        $message->sender_id       = $authId;
        $message->sender_type     = $authType;
        $message->message         = $request->message ?? 'Deliverable Uploaded';
        $message->type            = $request->hasFile('attachment') ? 'work_submission' : 'text';

        if ($request->hasFile('attachment')) {
            try {
                $file = $request->file('attachment');
                $path = public_path('assets/support/ticket');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
                
                $message->attachment = $filename;
                $message->original_filename = $file->getClientOriginalName();
            } catch (\Exception $exp) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => 'File upload failed.']);
                }
                return back()->withNotify([['error', 'File System Error: ' . $exp->getMessage()]]);
            }
        }

        $message->save();

        // Update conversation timestamp for sorting in the inbox 
        Conversation::where('id', $message->conversation_id)->update(['updated_at' => now()]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Message sent successfully',
                // Updated key name to match your influencer.conversation.view JS 
                'message_html' => view($this->activeTemplate . 'partials.message_bubble', compact('message'))->render(),
                'last_id' => $message->id 
            ]);
        }

        return back()->withNotify([['success', 'Message sent successfully']]);
    }

    /**
     * Polling for New Messages
     * FIXED: Returns 'html' and 'last_id' as required by your setInterval script
     */
    public function getNewMessages(Request $request, $id) {
        $isInfluencer = auth()->guard('influencer')->check();
        $authId = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();
        $lastId = $request->last_id ?? 0;

        // Get messages in this conversation newer than the last displayed ID 
        $newMessages = Message::where('conversation_id', $id)
            ->where('id', '>', $lastId)
            ->where('sender_id', '!=', $authId)
            ->orderBy('id', 'asc')
            ->get();

        $html = '';
        $currentLastId = $lastId;

        foreach($newMessages as $msg) {
            $html .= view($this->activeTemplate . 'partials.message_bubble', ['message' => $msg])->render();
            $currentLastId = $msg->id;
        }

        // Mark incoming messages as read upon fetching 
        if ($newMessages->count() > 0) {
            Message::whereIn('id', $newMessages->pluck('id'))->update(['is_read' => 1]);
        }

        return response()->json([
            'html' => $html, // Matches data.html in your blade [cite: 3]
            'last_id' => $currentLastId // Matches data.last_id in your blade [cite: 3]
        ]);
    }

    /**
     * View specific conversation and its messages
     */
    public function viewConversation($id) {
        $pageTitle = "Conversation View";
        $isInfluencer = auth()->guard('influencer')->check();
        $authId = $isInfluencer ? auth()->guard('influencer')->id() : auth()->id();

        $conversation = Conversation::where('id', $id)->where(function($q) use ($authId, $isInfluencer) {
            $isInfluencer ? $q->where('influencer_id', $authId) : $q->where('user_id', $authId);
        })->firstOrFail();

        // Mark incoming messages as read 
        Message::where('conversation_id', $id)->where('sender_id', '!=', $authId)->update(['is_read' => 1]);

        $messages = Message::where('conversation_id', $id)->orderBy('created_at', 'asc')->get();
        $conversations = Conversation::where($isInfluencer ? 'influencer_id' : 'user_id', $authId)
            ->with($isInfluencer ? 'user' : 'influencer')
            ->orderBy('updated_at', 'desc')->get();

        $view = $isInfluencer ? 'influencer.conversation.view' : 'user.conversation.view';
        return view($this->activeTemplate . $view, compact('pageTitle', 'conversation', 'messages', 'conversations'));
    }

    /**
     * Update Deliverable Status (Approve/Reject)
     */
    public function updateWorkStatus(Request $request) {
        $request->validate([
            'message_id' => 'required|integer',
            'status'     => 'required|in:approved,revision_requested',
            'reason'     => 'nullable|string|max:500'
        ]);

        $message = Message::findOrFail($request->message_id);
        $message->status = $request->status;
        $message->admin_note = ($request->status == 'revision_requested') ? $request->reason : null;
        $message->save();

        return response()->json([
            'status' => 'success', 
            'message' => $request->status == 'approved' ? 'Deliverable approved!' : 'Revision request sent.'
        ]);
    }

    /**
     * Reusable filter logic
     */
    protected function getFilterCampaign($campaigns, $platforms) {
        if (request()->category) {
            $categoryIds = Category::active()->whereIn('slug', request()->category)->pluck('id')->toArray();
            $campaigns->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('campaign_categories.category_id', $categoryIds);
            });
        }
        return $campaigns;
    }

    /**
     * File Download Helper
     */
    public function downloadAttachment($filename) {
        $fullPath = public_path('assets/support/ticket/') . $filename;
        if (!file_exists($fullPath)) return back()->withNotify([['error', 'File not found.']]);
        return response()->download($fullPath);
    }
}