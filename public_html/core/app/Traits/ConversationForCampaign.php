<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\CampaignConversation;
use App\Models\Participant;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ConversationForCampaign {
    protected $userType;
    protected $user = null;

    public function inbox($id) {
        $userType = $this->userType;
        
        // 1. Get the current participant to identify the pair
        if ($userType == 'user') {
            $participant = Participant::authCampaign()->with('influencer')->findOrFail($id);
            $influencer  = $participant->influencer;
            $brandId     = auth()->id();
            $influencerId = $influencer->id;
            $compact     = compact('influencer');
        } else {
            $participant = Participant::where('influencer_id', authInfluencerId())->withWhereHas('campaign', function ($query) {
                $query->with('user');
            })->findOrFail($id);
            $user        = $participant->campaign->user;
            $brandId     = $user->id;
            $influencerId = authInfluencerId();
            $compact     = compact('user');
        }

        // 2. UNIFIED CHAT: Get all IDs for this specific pair
        $participantIds = Participant::where('influencer_id', $influencerId)
            ->whereHas('campaign', function($q) use ($brandId) {
                $q->where('user_id', $brandId);
            })->pluck('id');

        $pageTitle           = 'Conversation';
        
        // 3. Load messages from ALL related shadow campaigns
        $conversationMessage = CampaignConversation::whereIn('participant_id', $participantIds)
            ->with(['participant.campaign', 'user', 'influencer'])
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $galleryAttachments = CampaignConversation::whereIn('participant_id', $participantIds)
            ->with('participant') // Load participant to check status
            ->where(function($q) {
                $q->whereNotNull('attachments')->orWhere('is_deliverable', 1);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->flatMap(function ($msg) use ($id) {
                // FILTER: Only show files from the current active campaign (participant ID)
                if ($msg->participant_id != $id) return [];

                $files = json_decode($msg->attachments, true);
                $mapped = [];
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $mapped[] = (object) [
                            'filename' => $file,
                            'original_name' => explode('_', $file, 2)[1] ?? $file,
                            'message_id' => $msg->id,
                            'participant_id' => $msg->participant_id,
                            'job_status' => $msg->participant->status, // Add job status
                            'created_at' => $msg->created_at,
                            'sender' => $msg->sender,
                            'extension' => pathinfo($file, PATHINFO_EXTENSION),
                            'is_deliverable' => $msg->is_deliverable,
                            'approval_status' => $msg->approval_status,
                            'rejection_reason' => $msg->rejection_reason
                        ];
                    }
                }

                // Handle Link Deliverables (messages marked as deliverable without files)
                if ($msg->is_deliverable && empty($files) && $msg->message) {
                    $mapped[] = (object) [
                        'filename' => null,
                        'original_name' => 'Link Deliverable',
                        'message_id' => $msg->id,
                        'participant_id' => $msg->participant_id,
                        'job_status' => $msg->participant->status,
                        'created_at' => $msg->created_at,
                        'sender' => $msg->sender,
                        'extension' => 'link',
                        'is_deliverable' => $msg->is_deliverable,
                        'approval_status' => $msg->approval_status,
                        'rejection_reason' => $msg->rejection_reason
                    ];
                }
                return $mapped;
            });

        $lastId   = @$conversationMessage->first()->id; // Changed to first() because of desc order
        $campaign = $participant->campaign;
        
                        // FETCH ALL OTHER JOBS with this specific influencer for this brand
        $relatedJobs = Participant::where('influencer_id', $influencerId)
            ->whereHas('campaign', function($q) use ($brandId) {
                 $q->where('user_id', $brandId);
            })
            ->with('campaign')
            ->orderByRaw("FIELD(status, " . Status::CAMPAIGN_JOB_COMPLETED . ") ASC") // Move completed to bottom
            ->orderBy('id', 'desc')
            ->get();

        $compact  = array_merge($compact, compact('pageTitle', 'participant', 'conversationMessage', 'campaign', 'lastId', 'relatedJobs', 'galleryAttachments'));
        return view($this->activeTemplate . $userType . '.campaign.conversation', $compact);
    }

    public function sendMessage(Request $request, $id) {
        $userType    = $this->userType;

        // VALIDATE TARGET PARTICIPANT IF PROVIDED
        $targetParticipantId = $request->target_participant_id ?? $id;
        $participant = Participant::where('id', $targetParticipantId);

        if ($userType == 'user') {
            $participant = $participant->authCampaign()->with('influencer')->first();
            $receiver    = $participant->influencer;
            $status      = Status::INFLUENCER_BAN;
        } else {
            $participant = $participant->where('influencer_id', authInfluencerId())->first();
            $receiver    = $participant->campaign->user;
            $status      = Status::USER_BAN;
        }

        if (!$participant) {
            return response()->json(['error' => 'Invalid campaign found']);
        }

        // ADDITIONAL VALIDATION: Ensure target participant belongs to the same pair if it's different from $id
        if ($targetParticipantId != $id) {
            $originalParticipant = Participant::findOrFail($id);
            if ($userType == 'user') {
                if ($participant->influencer_id != $originalParticipant->influencer_id) {
                     return response()->json(['error' => 'Invalid target campaign']);
                }
            } else {
                if ($participant->campaign->user_id != $originalParticipant->campaign->user_id) {
                     return response()->json(['error' => 'Invalid target campaign']);
                }
            }
        }

        $validate = 'nullable';
        if (!$request->hasFile('attachments') && !$request->message) {
            $validate = 'required';
        }

        $validator = Validator::make($request->all(), [
            'message'       => $validate,
            'attachments'   => 'nullable|array',
            'attachments.*' => ['required', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'txt'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        if (!$receiver || $receiver->status == $status) {
            return response()->json(['error' => ucfirst($userType) . " is now banned from admin"]);
        }

        $message                 = new CampaignConversation();
        // We now use the validated $participant->id
        $message->participant_id = $participant->id;
        $message->user_id        = $userType == 'user' ? auth()->id() : $receiver->id;
        $message->influencer_id  = $userType == 'user' ? $receiver->id : authInfluencerId();
        $message->sender         = $userType == 'user' ? 'brand' : 'influencer';
        $message->message        = $request->message;
        // ADDITION: Flag is_deliverable if selected on front-end
        $message->is_deliverable = $request->is_deliverable ? 1 : 0;

        // AUTO-STATUS UPDATE: Mark as delivered if influencer sends a deliverable
        if ($userType == 'influencer' && $message->is_deliverable && $participant->status == Status::PARTICIPATE_REQUEST_ACCEPTED) {
            $participant->status = Status::CAMPAIGN_JOB_DELIVERED;
            $participant->save();

            notify($participant->campaign->user, 'CAMPAIGN_JOB_DELIVERED', [
                'brand'              => $participant->campaign->user->username,
                'influencer'         => $participant->influencer->username,
                'title'              => $participant->campaign->title,
                'participant_number' => $participant->participant_number,
            ]);

            recentActivity('Influencer delivered your campaign job via message', $participant->campaign->user_id);
        }

        if ($request->hasFile('attachments')) {
            $arrFile = [];
            foreach ($request->file('attachments') as $file) {
                try {
                    $arrFile[] = fileUploader($file, getFilePath('conversation'));
                } catch (\Exception $exp) {
                    return response()->json(['error' => 'Couldn\'t upload your image']);
                }
            }
            $message->attachments = json_encode($arrFile);
        }
        $message->save();
        $message->load('participant'); // Load participant for unified view compatibility
        $html = view($this->activeTemplate . 'conversation.last_message', compact('message'))->render();
        return response()->json(['html' => $html, 'lastId' => $message->id]);
    }

    public function viewMessage(Request $request) {
        // UNIFIED VIEW MESSAGE
        $currentParticipant = Participant::find($request->participant_id);
        $participantIds = Participant::where('influencer_id', $currentParticipant->influencer_id)
            ->whereHas('campaign', function($q) use ($currentParticipant) {
                $q->where('user_id', $currentParticipant->campaign->user_id);
            })->pluck('id');

        $query = CampaignConversation::whereIn('participant_id', $participantIds)
            ->with(['participant.campaign', 'user', 'influencer']);

        // NEW: If last_id is provided, only get messages newer than that (Polling)
        if ($request->last_id) {
            $conversationMessage = $query->where('id', '>', $request->last_id)
                ->orderBy('id', 'asc')
                ->get();
            
            $html = '';
            foreach($conversationMessage as $message) {
                $html .= view($this->activeTemplate . 'conversation.last_message', compact('message'))->render();
            }
            return response()->json(['html' => $html, 'last_id' => $conversationMessage->last()?->id]);
        }

        // Locate specific message logic
        if ($request->locate_id) {
             $newerCount = CampaignConversation::whereIn('participant_id', $participantIds)
                 ->where('id', '>=', $request->locate_id)
                 ->count();
             $request->merge(['messageCount' => $newerCount + 5]); 
        }

        $conversationCount   = CampaignConversation::whereIn('participant_id', $participantIds)->count();
        $conversationMessage = $query->limit($request->messageCount)
            ->orderBy('id', 'desc')
            ->get();
            
        $html                = view($this->activeTemplate . 'conversation.messages', compact('conversationMessage'))->render();
        $scrollAvailable     = $request->messageCount > ($conversationCount + 10) ? false : true;
        return response()->json(['html' => $html, 'scrollAvailable' => $scrollAvailable]);
    }

    public function sendProposal(Request $request, $id) {
        // ... validation code here ...

        // Allow sending proposals regardless of current job status
        $participant = Participant::where('influencer_id', auth()->guard('influencer')->id())
            ->findOrFail($id);

        $influencer = auth()->guard('influencer')->user();
        $brand      = $participant->campaign->user;

        $campaign               = new \App\Models\Campaign();
        $campaign->user_id      = $brand->id;
        $campaign->title        = $request->title;
        $campaign->slug         = slug($campaign->title) . '-' . getTrx(5);
        $campaign->campaign_type = 'invite';
        $campaign->payment_type = 'paid';
        $campaign->budget       = $request->price;
        $campaign->status       = Status::CAMPAIGN_APPROVED;
        $campaign->start_date   = now();
        $campaign->end_date     = now()->addDays((int) $request->delivery_time);
        $campaign->description  = $request->description;
        $campaign->save();
        $campaign->platforms()->attach($request->platform_id);

        $proposal                     = new Participant();
        $proposal->campaign_id        = $campaign->id;
        $proposal->influencer_id      = $influencer->id;
        $proposal->budget             = $request->price;
        $proposal->status             = Status::PARTICIPATE_PROPOSAL;
        $proposal->participant_number = getTrx();
        $proposal->save();

        recentActivity('Sent a custom proposal to ' . $brand->username, 0, $influencer->id);

        $notify[] = ['success', 'Proposal sent successfully!'];
        return back()->withNotify($notify);
    }

    public function acceptProposal($id) {
        $proposal = Participant::where('status', Status::PARTICIPATE_PROPOSAL)
            ->whereHas('campaign', function($q) {
                $q->where('user_id', auth()->id());
            })->findOrFail($id);

        $brand = auth()->user();

        if ($brand->balance < $proposal->budget) {
            $notify[] = ['error', 'Insufficient balance to accept this proposal'];
            return back()->withNotify($notify);
        }

        $brand->balance -= $proposal->budget;
        $brand->save();

        // ... (Keep your Transaction code here) ...

        $proposal->status = Status::PARTICIPATE_REQUEST_ACCEPTED;
        $proposal->save();

        $notify[] = ['success', 'Proposal accepted and hired!'];
        
        // REDIRECT BACK: This keeps the Brand on the same chat page they were on
        return back()->withNotify($notify);
    }

    public function approveDeliverable(Request $request) {
        $message = CampaignConversation::where('id', $request->message_id)
            ->firstOrFail();

        $participant = Participant::findOrFail($message->participant_id);

        // Security check: Only the brand of this campaign can approve
        if ($this->userType == 'user' && $participant->campaign->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $message->approval_status = 1;
        $message->save();

        return response()->json(['success' => true, 'message' => 'Deliverable approved successfully!']);
    }

    public function rejectDeliverable(Request $request) {
        $message = CampaignConversation::where('id', $request->message_id)
            ->firstOrFail();

        $participant = Participant::findOrFail($message->participant_id);

        if ($this->userType == 'user' && $participant->campaign->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized']);
        }

        $message->approval_status = 2;
        $message->rejection_reason = $request->reason;
        $message->save();

        // AUTO-STATUS UPDATE: Move status back to "Accepted" (In Progress) so influencer can resubmit
        if ($participant->status == Status::CAMPAIGN_JOB_DELIVERED) {
            $participant->status = Status::PARTICIPATE_REQUEST_ACCEPTED;
            $participant->save();

            recentActivity('Brand requested a revision on your delivery', 0, $participant->influencer_id);
        }

        return response()->json(['success' => true, 'message' => 'Revision requested successfully!']);
    }
}

