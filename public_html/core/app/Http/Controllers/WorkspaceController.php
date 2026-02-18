<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Campaign;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Participant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkspaceController extends Controller
{
    public $activeTemplate;

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    /**
     * Shared View for Conversation/Workspace
     */
    public function view($id)
    {
        $isInfluencer = auth()->guard('influencer')->check();
        $user = $isInfluencer ? auth()->guard('influencer')->user() : auth()->user();
        $authId = $user->id;

        $query = Conversation::where('id', $id);
        if ($isInfluencer) {
            $query->where('influencer_id', $authId);
        } else {
            $query->where('user_id', $authId);
        }

        $conversation = $query->with(['messages.participant', 'user', 'influencer', 'campaign'])->firstOrFail();

        // Mark messages as read
        Message::where('conversation_id', $conversation->id)
            ->where('sender_type', $isInfluencer ? 'user' : 'influencer')
            ->update(['is_read' => 1]);

        $pageTitle = "Workspace with " . ($isInfluencer ? $conversation->user->fullname : $conversation->influencer->fullname);

        // Sidebar list
        $convQuery = Conversation::query();
        if ($isInfluencer) {
            $convQuery->where('influencer_id', $authId)->with('user');
        } else {
            $convQuery->where('user_id', $authId)->with('influencer');
        }
        $conversations = $convQuery->with('lastMessage')->orderBy('updated_at', 'desc')->get();

        return view($this->activeTemplate . 'shared.workspace', compact('pageTitle', 'conversation', 'conversations', 'isInfluencer'));
    }

    /**
     * Send Message (Text, Attachment, or Proposal)
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'message'         => 'nullable|string',
            'attachment'      => 'nullable|file|max:51200',
            'type'            => 'nullable|string',
            'budget'          => 'nullable|numeric|min:0'
        ]);

        $isInfluencer = auth()->guard('influencer')->check();
        $user = $isInfluencer ? auth()->guard('influencer')->user() : auth()->user();
        $authId = $user->id;

        try {
            $conversation = Conversation::findOrFail($request->conversation_id);

            // Handle Proposal logic
            $participantId = null;
            if ($request->type == 'contract_proposal') {
                $participant = new Participant();
                $participant->influencer_id      = $authId;
                $participant->campaign_id        = $conversation->campaign_id;
                $participant->budget             = $request->budget;
                $participant->participant_number = getTrx();
                $participant->status             = 0; // Pending
                    $participant->save();
                $participantId = $participant->id;
            }

            $message                  = new Message();
            $message->conversation_id = $conversation->id;
            $message->sender_id       = $authId;
            $message->sender_type     = $isInfluencer ? 'influencer' : 'user';
            $message->message         = $request->message;
            $message->type            = $request->type ?? 'text';
            $message->participant_id  = $participantId;
            
            // Link to the active campaign in the conversation
            if ($conversation->campaign_id) {
                $message->campaign_id = $conversation->campaign_id;
            }

            if ($request->hasFile('attachment')) {
                try {
                    $message->attachment = fileUploader($request->attachment, getFilePath('conversation'));
                } catch (\Exception $exp) {
                    return response()->json(['status' => 'error', 'message' => 'Could not upload attachment']);
                }
            }

            $message->save();

            $conversation->updated_at = now();
            $conversation->save();

            $message_html = view($this->activeTemplate . 'partials.message_bubble', compact('message'))->render();
            return response()->json([
                'status'       => 'success',
                'message'      => 'Message sent successfully',
                'message_html' => $message_html,
                'last_id'      => $message->id
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

    /**
     * Accept or Reject a Proposal
     */
    public function updateProposal(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|integer',
            'status'         => 'required|in:accept,reject'
        ]);

        $participant = Participant::findOrFail($request->participant_id);
        $brand = auth()->user(); // Only brands can accept/reject proposals in this context

        if (!$brand) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized']);
        }

        if ($request->status == 'accept') {
            if ($brand->balance < $participant->budget) {
                return response()->json(['status' => 'error', 'message' => 'Insufficient balance.']);
            }

            try {
                DB::transaction(function() use ($brand, $participant) {
                    $brand->balance -= $participant->budget;
                    $brand->save();

                    $participant->status = 1; // Active
                    $participant->save();

                    // Update related campaign if it exists
                    if ($participant->campaign) {
                        $participant->campaign->status = 1; // Active
                        $participant->campaign->save();
                    }

                    $transaction = new Transaction();
                    $transaction->user_id = $brand->id;
                    $transaction->amount = $participant->budget;
                    $transaction->post_balance = $brand->balance;
                    $transaction->trx_type = '-';
                    $transaction->details = 'Funded contract #' . $participant->participant_number;
                    $transaction->trx = getTrx();
                    $transaction->remark = 'proposal_payment';
                    $transaction->save();
                });

                return response()->json(['status' => 'success', 'message' => 'Proposal accepted!']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }

        $participant->status = 3; // Rejected
        $participant->save();
        return response()->json(['status' => 'success', 'message' => 'Proposal rejected.']);
    }

    /**
     * Download File
     */
    public function download($file)
    {
        $path = getFilePath('conversation');
        $fullPath = $path . '/' . $file;
        if (!file_exists($fullPath)) abort(404);
        return response()->download($fullPath);
    }

    /**
     * Polling for new messages
     */
    public function getNewMessages(Request $request, $id)
    {
        $isInfluencer = auth()->guard('influencer')->check();
        $lastId = $request->last_id;

        $messages = Message::where('conversation_id', $id)
            ->where('id', '>', $lastId)
            ->where('sender_type', $isInfluencer ? 'user' : 'influencer')
            ->get();

        $html = '';
        foreach ($messages as $message) {
            $html .= view($this->activeTemplate . 'partials.message_bubble', compact('message'))->render();
            $message->is_read = 1;
            $message->save();
        }

        return response()->json([
            'html'    => $html,
            'last_id' => $messages->count() > 0 ? $messages->last()->id : $lastId
        ]);
    }
}

