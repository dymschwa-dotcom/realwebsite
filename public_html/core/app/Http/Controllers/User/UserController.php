<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Influencer;
use App\Models\Campaign;
use App\Models\Participant;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;

class UserController extends Controller
{
    protected $activeTemplate;

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    /**
     * Brand Dashboard
     */
     
     public function index()
{
    $pageTitle = 'Dashboard';
    $user = auth()->user();

    // ADD THIS LINE HERE TOO
    $allCount = \App\Models\Campaign::where('user_id', $user->id)->count();

    // AND ADD IT TO COMPACT HERE
    return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'allCount'));
}
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();

        // 1. Financial Stats
        $data['total_spending']       = $user->deposits()->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        
        // 2. Campaign Stats
        $data['total_campaigns'] = \App\Models\Campaign::where('user_id', $user->id)->count();
        $data['active_campaigns']     = Campaign::where('user_id', $user->id)->where('status', Status::CAMPAIGN_APPROVED)->count();
        $data['pending_campaign']     = Campaign::where('user_id', $user->id)->where('status', Status::CAMPAIGN_PENDING)->count();
        $data['rejected_campaign']    = Campaign::where('user_id', $user->id)->where('status', Status::CAMPAIGN_REJECTED)->count();
        $data['incompleted_campaign'] = Campaign::where('user_id', $user->id)->where('status', Status::CAMPAIGN_INCOMPLETE)->count();

        $data['running_campaign']     = Campaign::where('user_id', $user->id)
                                        ->where('status', Status::CAMPAIGN_APPROVED)
                                        ->where('end_date', '>', now())
                                        ->count();
        
        // 3. Interaction Stats
        $data['total_messages']       = Conversation::where('user_id', $user->id)->count();
        $data['total_participant']    = Participant::whereHas('campaign', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        // 4. Recent Campaigns List
        $data['campaign'] = Campaign::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 5. FIXED: Fetch Activity/Transaction Logs
        $activities = $user->deposits()->with('gateway')->orderBy('id', 'desc')->take(10)->get();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'user', 'data', 'activities'));
    }

    // ... (rest of the controller methods remain the same)
    
    public function startConversation($id)
    {
        $user = auth()->user();
        $influencer = Influencer::findOrFail($id);
        $conversation = Conversation::where('user_id', $user->id)->where('influencer_id', $influencer->id)->first();

        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->user_id = $user->id;
            $conversation->influencer_id = $influencer->id;
            $conversation->save();

            $message = new Message();
            $message->conversation_id = $conversation->id;
            $message->sender_id       = $user->id;
            $message->sender_type     = 'user';
            $message->message         = "Hi " . $influencer->firstname . ", I'm interested in working with you!";
            $message->type            = 'text';
            $message->is_read         = Status::NO;
            $message->save();
        }
        return redirect()->route('user.conversation.view', $conversation->id);
    }

    public function conversationIndex()
    {
        $pageTitle = 'Messages';
        $user = auth()->user();
        $conversations = Conversation::where('user_id', $user->id)->with(['influencer', 'lastMessage'])->orderBy('updated_at', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.conversation.index', compact('pageTitle', 'conversations'));
    }

    public function viewConversation($id)
{
    $pageTitle = "Conversation View";
    $user = auth()->user();
    
    // The "with" part is the magic fix. It loads the participant link.
    $conversation = Conversation::where('user_id', $user->id)
        ->with(['messages.participant', 'influencer']) 
        ->findOrFail($id);

    $messages = $conversation->messages;
    
    // Mark messages as read while we are here
    $conversation->messages()->where('sender_type', 'influencer')->update(['is_read' => 1]);

    return view($this->activeTemplate . 'user.conversation.view', compact('pageTitle', 'conversation', 'messages'));
}

    public function sendMessage(Request $request)
    {
        $request->validate(['conversation_id' => 'required|exists:conversations,id', 'message' => 'required|string']);
        $user = auth()->user();
        $conversation = Conversation::where('user_id', $user->id)->findOrFail($request->conversation_id);
        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id       = $user->id;
        $message->sender_type     = 'user';
        $message->message         = $request->message;
        $message->type            = 'text';
        $message->is_read         = Status::NO;
        $message->save();
        $conversation->touch();
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message_html' => view('templates.basic.partials.message_bubble', compact('message'))->render(), 'last_id' => $message->id]);
        }
        return back()->withNotify([['success', 'Message sent successfully']]);
    }

    public function updateWorkStatus(Request $request)
    {
        $request->validate(['message_id' => 'required|exists:messages,id', 'status' => 'required|in:approved,revision_requested,rejected']);
        $userId = auth()->id();
        $message = Message::whereHas('conversation', function($q) use ($userId) { $q->where('user_id', $userId); })->where('type', 'work_submission')->findOrFail($request->message_id);
        $message->status = $request->status;
        $message->save();
        return response()->json(['status' => 'success', 'new_status' => $request->status, 'message' => 'Work status updated successfully']);
    }

    public function downloadAttachment($file)
    {
        $path = getFilePath('verify_work');
        $fullPath = $path . '/' . $file;
        if (!file_exists($fullPath)) return back()->withNotify([['error', 'File not found.']]);
        return response()->download($fullPath);
    }

    public function getNewMessages(Request $request, $id)
    {
        $last_id = $request->last_id;
        $newMessages = Message::where('conversation_id', $id)->where('id', '>', $last_id)->where('sender_type', 'influencer')->get();
        $html = '';
        foreach ($newMessages as $message) {
            $html .= view('templates.basic.partials.message_bubble', compact('message'))->render();
            $message->is_read = Status::YES;
            $message->save();
        }
        return response()->json(['html' => $html, 'last_id' => $newMessages->count() > 0 ? $newMessages->last()->id : $last_id]);
    }

    public function profile()
    {
        $pageTitle = 'Profile Setting';
        $user = auth()->user();
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate(['firstname' => 'required|string', 'lastname' => 'required|string']);
        $user = auth()->user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->save();
        return back()->withNotify([['success', 'Profile updated successfully']]);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {
        $request->validate(['current_password' => 'required', 'password' => 'required|confirmed']);
        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return back()->withNotify([['success', 'Password changed successfully']]);
        }
        return back()->withNotify([['error', 'The current password doesn\'t match!']]);
    }
    public function transactions(Request $request)
{
    $pageTitle = 'Transactions';
    $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
    
    $transactions = Transaction::where('user_id', auth()->id());

    if ($request->search) {
        $transactions = $transactions->where('trx', $request->search);
    }

    if ($request->type) {
        $type = $request->type == 'plus' ? '+' : '-';
        $transactions = $transactions->where('trx_type', $type);
    }

    if ($request->remark) {
        $transactions = $transactions->where('remark', $request->remark);
    }

    $transactions = $transactions->orderBy('id','desc')->paginate(getPaginate());
    
    return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks'));
}
}