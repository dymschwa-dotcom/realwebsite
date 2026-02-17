<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Service;
use App\Models\Campaign; 
use App\Models\Withdrawal;
use App\Models\Transaction; // Standard model for activity logs
use Illuminate\Http\Request;
use App\Constants\Status;
use Illuminate\Support\Facades\Schema;

class InfluencerController extends Controller
{
    protected $activeTemplate;

    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }

    public function home() {
        $pageTitle = 'Influencer Dashboard';
        $influencer = auth()->guard('influencer')->user();
        
        // General Widgets
        $widget['total_services'] = Service::where('influencer_id', $influencer->id)->count();
        $widget['total_conversations'] = Conversation::where('influencer_id', $influencer->id)->count();
        
        // Withdrawal Widget
        $totalWithdraws = Withdrawal::where('influencer_id', $influencer->id)
            ->where('status', Status::PAYMENT_SUCCESS)
            ->sum('amount');

        // Recent Activities (Transactions)
        $activities = Transaction::where('influencer_id', $influencer->id)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Campaign Widgets (with defensive check)
        $completedCampaign = 0;
        $ongoingCampaign = 0;

        if (Schema::hasColumn('campaigns', 'influencer_id')) {
            $completedCampaign = Campaign::where('influencer_id', $influencer->id)
                ->where('status', Status::CAMPAIGN_JOB_COMPLETED)
                ->count();
                
            $ongoingCampaign = Campaign::where('influencer_id', $influencer->id)
                ->where('status', Status::PARTICIPATE_REQUEST_ACCEPTED)
                ->count();
        }

        return view($this->activeTemplate . 'influencer.dashboard', compact(
            'pageTitle', 
            'widget', 
            'influencer', 
            'completedCampaign', 
            'ongoingCampaign', 
            'totalWithdraws',
            'activities'
        ));
    }

    public function conversations() {
        $pageTitle = 'My Messages';
        $influencer = auth()->guard('influencer')->user();
        
        $conversations = Conversation::where('influencer_id', $influencer->id)
            ->with(['user', 'lastMessage'])
            ->orderBy('updated_at', 'desc')
            ->paginate(getPaginate());
            
        return view($this->activeTemplate . 'influencer.conversation.index', compact('pageTitle', 'conversations'));
    }

    public function viewChat($id) {
        $influencerId = auth()->guard('influencer')->id();
        $conversation = Conversation::where('influencer_id', $influencerId)->with(['user', 'messages'])->findOrFail($id);
        
        $conversations = Conversation::where('influencer_id', $influencerId)
            ->with(['user', 'lastMessage'])
            ->orderBy('updated_at', 'desc')
            ->get();
            
        $pageTitle = 'Chat with ' . $conversation->user->fullname;

        Message::where('conversation_id', $id)
            ->where('sender_type', 'user')
            ->where('is_read', Status::NO)
            ->update(['is_read' => Status::YES]);

        return view($this->activeTemplate . 'influencer.conversation.view', compact('pageTitle', 'conversation', 'conversations'));
    }

    public function sendMessage(Request $request) {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message'         => 'required|string|max:1000',
        ]);
        
        $message = new Message();
        $message->conversation_id = $request->conversation_id;
        $message->sender_id       = auth()->guard('influencer')->id();
        $message->sender_type     = 'influencer';
        $message->message         = $request->message;
        $message->type            = 'text';
        $message->save();

        $conversation = Conversation::find($request->conversation_id);
        $conversation->touch();

        if($request->ajax()){
            return response()->json([
                'status' => 'success', 
                'message_html' => view($this->activeTemplate . 'partials.message_bubble', compact('message'))->render()
            ]);
        }
        return back();
    }

    public function submitWork(Request $request) {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message'         => 'required|string|max:1000',
            'attachment'      => 'required|mimes:zip,pdf,jpg,jpeg,png,mp4,mov|max:51200',
        ]);

        $influencerId = auth()->guard('influencer')->id();
        $conversation = Conversation::where('influencer_id', $influencerId)->findOrFail($request->conversation_id);

        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id       = $influencerId;
        $message->sender_type     = 'influencer';
        $message->message         = $request->message;
        $message->type            = 'work_submission';
        $message->status          = 'pending';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $message->original_filename = $file->getClientOriginalName();
            $path = getFilePath('verify_work'); 
            $message->attachment = fileUploader($file, $path);
        }

        $message->save();
        $conversation->touch();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Work submitted successfully!',
                'message_html' => view($this->activeTemplate . 'partials.message_bubble', compact('message'))->render()
            ]);
        }
        return back();
    }

    public function getNewMessages(Request $request, $id) {
        $last_id = $request->last_id;
        $newMessages = Message::where('conversation_id', $id)
            ->where('id', '>', $last_id)
            ->where('sender_type', 'user') 
            ->get();

        $html = '';
        foreach($newMessages as $message){
            $html .= view($this->activeTemplate . 'partials.message_bubble', compact('message'))->render();
            $message->is_read = Status::YES;
            $message->save();
        }

        return response()->json([
            'html' => $html,
            'last_id' => $newMessages->count() > 0 ? $newMessages->last()->id : $last_id
        ]);
    }

    public function downloadAttachment($file) {
        $path = getFilePath('verify_work');
        $fullPath = $path . '/' . $file;
        if (!file_exists($fullPath)) {
            return back()->withNotify([['error', 'File not found']]);
        }
        return response()->download($fullPath);
    }
    
    public function addServices()
{
    $pageTitle = 'Add Services';
    $influencer = auth()->guard('influencer')->user();
    
    $services = \App\Models\Service::where('influencer_id', $influencer->id)->get();
    return view($this->activeTemplate . 'influencer.add_services', compact('pageTitle', 'influencer','services'));
}
public function serviceSave(Request $request)
{
    // 1. Validate the array structure
    $request->validate([
        'services' => 'required|array|min:3',
        'services.*.title' => 'required|string|max:255',
        'services.*.price' => 'required|numeric|min:0',
        'services.*.description' => 'required|string|max:1000',
    ]);

    $influencer = auth()->guard('influencer')->user();

    // 2. Loop through each package (1, 2, and 3)
    foreach ($request->services as $item) {
        $service = new \App\Models\Service();
        $service->influencer_id = $influencer->id;
        $service->title         = $item['title'];
        $service->price         = $item['price'];
        $service->description   = $item['description'];
        $service->save();
    }

    $notify[] = ['success', 'All 3 service packages have been added to your profile!'];
    
    // 3. Return to dashboard
    return to_route('influencer.home')->withNotify($notify);
}

}