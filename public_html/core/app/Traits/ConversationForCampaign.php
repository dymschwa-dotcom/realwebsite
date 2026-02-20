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
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

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

        $compact  = array_merge($compact, compact('pageTitle', 'participant', 'conversationMessage', 'campaign', 'lastId', 'relatedJobs'));
        return view($this->activeTemplate . $userType . '.campaign.conversation', $compact);
    }

    public function sendMessage(Request $request, $id) {
        $userType    = $this->userType;
        $participant = Participant::where('id', $id);

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
        // We still save to the $id passed, but since inbox reads ALL, it stays unified
        $message->participant_id = $participant->id;
        $message->user_id        = $userType == 'user' ? auth()->id() : $receiver->id;
        $message->influencer_id  = $userType == 'user' ? $receiver->id : authInfluencerId();
        $message->sender         = $userType == 'user' ? 'brand' : 'influencer';
        $message->message        = $request->message;

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

        $conversationCount   = CampaignConversation::whereIn('participant_id', $participantIds)->count();
        $conversationMessage = CampaignConversation::whereIn('participant_id', $participantIds)
            ->limit($request->messageCount)
            ->orderBy('id', 'desc')
            ->get();
            
        $html                = view($this->activeTemplate . 'conversation.messages', compact('conversationMessage'))->render();
        $scrollAvailable     = $request->messageCount > ($conversationCount + 10) ? false : true;
        return response()->json(['html' => $html, 'scrollAvailable' => $scrollAvailable]);
    }

    public function sendProposal(Request $request, $id) {
        // ... (Keep your validation code here) ...

        // Allow sending proposals even if accepted
        $participant = Participant::whereIn('status', [Status::PARTICIPATE_INQUIRY, Status::PARTICIPATE_REQUEST_ACCEPTED])
            ->where('influencer_id', auth()->guard('influencer')->id())
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
}