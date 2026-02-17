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
        if ($userType == 'user') {
            $participant = Participant::authCampaign()->with('influencer', 'userConversation')->findOrFail($id);
            $influencer  = $participant->influencer;
            $compact     = compact('influencer');
        } else {
            $participant = Participant::where('influencer_id', authInfluencerId())->withWhereHas('campaign', function ($query) {
                $query->with('user');
            })->with('userConversation')->findOrFail($id);
            $user    = $participant->campaign->user;
            $compact = compact('user');
        }

        $pageTitle           = 'Conversation';
        $conversationMessage = $participant->userConversation->take(10);
        $lastId              = @$conversationMessage->last()->id;
        $campaign            = $participant->campaign;
        $compact             = array_merge($compact, compact('pageTitle', 'participant', 'conversationMessage', 'campaign', 'lastId'));
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
        if (!$request->attachments && !$request->message) {
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
        $message->participant_id = $participant->id;
        $message->user_id        = $userType == 'user' ? auth()->id() : $receiver->id;
        $message->influencer_id  = $userType == 'user' ? $receiver->id : authInfluencerId();
        $message->sender         = $userType == 'user' ? 'brand' : 'influencer';
        $message->message        = $request->message;

        if ($request->hasFile('attachments')) {
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
        $conversationCount   = CampaignConversation::where('participant_id', $request->participant_id)->count();
        $conversationMessage = CampaignConversation::where('participant_id', $request->participant_id)->limit($request->messageCount)->orderBy('id', 'desc')->get();
        $html                = view($this->activeTemplate . 'conversation.messages', compact('conversationMessage'))->render();
        $scrollAvailable     = $request->messageCount > ($conversationCount + 10) ? false : true;
        return response()->json(['html' => $html, 'scrollAvailable' => $scrollAvailable]);
    }
}