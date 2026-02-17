<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignConversation;
use App\Models\Participant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageCampaignController extends Controller {
    public function index() {
        $pageTitle = 'All Campaign';
        $campaigns = $this->getCampaign('');
        return view('admin.campaign.index', compact('pageTitle', 'campaigns'));
    }

    public function pending() {
        $pageTitle = 'Pending Campaign';
        $campaigns = $this->getCampaign('pending');
        return view('admin.campaign.index', compact('pageTitle', 'campaigns'));
    }

    public function approved() {
        $pageTitle = 'Approved Campaign';
        $campaigns = $this->getCampaign('approved');
        return view('admin.campaign.index', compact('pageTitle', 'campaigns'));
    }

    public function rejected() {
        $pageTitle = 'Rejected Campaign';
        $campaigns = $this->getCampaign('rejected');
        return view('admin.campaign.index', compact('pageTitle', 'campaigns'));
    }

    protected function getCampaign($scope) {
        if ($scope) {
            $campaigns = Campaign::$scope();
        } else {
            $campaigns = Campaign::where('status', '!=', Status::CAMPAIGN_INCOMPLETE);
        }
        return $campaigns->searchable(['title', 'user:username'])->with('user')->withCount('participants')->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function detail($id) {
        $pageTitle = 'Campaign Detail';
        $campaign  = Campaign::with(['user' => function ($q) {
            $q->withCount('campaigns');
        }])->findOrFail($id);
        return view('admin.campaign.detail', compact('pageTitle', 'campaign'));
    }

    public function approve($id) {
        $campaign = Campaign::pending()->with('user')->findOrFail($id);
        $user     = $campaign->user;
        $general  = gs();

        if ($general->campaign_charge) {
            if ($campaign->campaign_approval_charge > $user->balance) {
                $notify[] = ['error', 'Brand does not have sufficient balance'];
                return back()->withNotify($notify);
            }

            $user->balance -= $general->campaign_approval_charge;
            $user->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $user->id;
            $transaction->amount       = $general->campaign_approval_charge;
            $transaction->post_balance = $user->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '-';
            $transaction->details      = 'Balance deduct for campaign approve';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'campaign_charge';
            $transaction->save();

            notify(@$user, 'CAMPAIGN_APPROVAL_CHARGE', [
                'brand'  => $campaign->user->username,
                'charge' => showAmount($general->campaign_approval_charge,currencyFormat:false),
                'trx'    => $transaction->trx,
                'title'  => $campaign->title,
            ]);
        }

        $campaign->status = Status::CAMPAIGN_APPROVED;
        $campaign->save();

        $shortCode = [
            'username'   => $user->username,
            'title'      => $campaign->title,
            'budget'     => showAmount($campaign->budget,currencyFormat:false),
            'start_date' => $campaign->start_date,
            'end_date'   => $campaign->end_date,
        ];
        notify($user, 'CAMPAIGN_REQUEST_APPROVED', $shortCode);

        $notify[] = ['success', 'Campaign approved successfully'];
        return back()->withNotify($notify);
    }

    public function reject(Request $request, $id) {
        $campaign         = Campaign::pending()->with('user')->findOrFail($id);
        $campaign->status = Status::CAMPAIGN_REJECTED;
        $campaign->reason = $request->reason;
        $campaign->save();

        $user      = $campaign->user;
        $shortCode = [
            'username'   => $user->username,
            'title'      => $campaign->title,
            'budget'     => showAmount($campaign->budget,currencyFormat:false),
            'start_date' => $campaign->start_date,
            'end_date'   => $campaign->end_date,
            'reason'     => $campaign->reason,

        ];
        notify($user, 'CAMPAIGN_REQUEST_REJECTED', $shortCode);
        $notify[] = ['success', 'Campaign rejected successfully'];
        return back()->withNotify($notify);
    }

    public function participants(Request $request, $id) {
        $campaign     = Campaign::findOrFail($id);
        $participants = $campaign->participants();
        if ($request->status && $request->status != 'all') {
            $status = $request->status;
            $participants->$status();
        }
        $participants = $participants->with('influencer', 'campaign')->searchable(['participant_number', 'influencer:username,firstname,lastname'])->orderBy('id', 'desc')->paginate(getPaginate());
        $pageTitle    = 'Particapant List';
        return view('admin.campaign.participants', compact('pageTitle', 'participants', 'campaign'));
    }

    public function conversation($id) {
        $participant   = Participant::with('campaign', 'influencer', 'userConversation')->findOrFail($id);
        $pageTitle     = 'Campaign Conversation - ' . $participant->participant_number;
        $conversations = $participant->userConversation->take(10);
        return view('admin.campaign.conversation', compact('pageTitle', 'participant', 'conversations'));
    }

    public function sendMessage(Request $request, $id) {
        $participant = Participant::findOrFail($id);
        $validator   = Validator::make($request->all(), [
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        $conversation                 = new CampaignConversation();
        $conversation->participant_id = $participant->id;
        $conversation->user_id        = $participant->campaign->user_id;
        $conversation->influencer_id  = $participant->influencer_id;
        $conversation->admin_id       = auth()->guard('admin')->id();
        $conversation->sender         = 'admin';
        $conversation->message        = $request->message;
        $conversation->save();
        return view('admin.conversation.last_message', compact('conversation'));
    }

    public function viewMessage(Request $request) {
        $conversations = CampaignConversation::where('participant_id', $request->participant_id)->take($request->messageCount)->orderBy('id', 'desc')->get();
        return view('admin.conversation.messages', compact('conversations'));
    }

    public function complete($id) {
        $participant         = Participant::reported()->findOrFail($id);
        $participant->status = Status::CAMPAIGN_JOB_COMPLETED;
        $participant->save();

        $campaign   = $participant->campaign;
        $brand      = $campaign->user;
        $influencer = $participant->influencer;

        if ($campaign->payment_type == 'paid') {
            $influencer->balance += $participant->budget;
        }

        $influencer->increment('order_completed');
        $influencer->save();

        if ($campaign->payment_type == 'paid') {
            $transaction                = new Transaction();
            $transaction->influencer_id = $influencer->id;
            $transaction->amount        = $participant->budget;
            $transaction->post_balance  = $influencer->balance;
            $transaction->charge        = 0;
            $transaction->trx_type      = '+';
            $transaction->details       = 'Campaign job completed';
            $transaction->trx           = getTrx();
            $transaction->remark        = 'campaign_completed';
            $transaction->save();

            notify(@$influencer, 'CAMPAIGN_JOB_COMPLETED', [
                'influencer'         => @$influencer->username,
                'brand'              => $campaign->user->username,
                'participant_number' => $participant->participant_number,
                'budget'             => showAmount($participant->budget,currencyFormat:false),
                'trx'                => $transaction->trx,
                'title'              => $campaign->title,
            ]);
        }

        notify(@$brand, 'IN_FAVOUR_OF_INFLUENCER', [
            'title'              => $campaign->title,
            'influencer'         => @$participant->influencer->username,
            'brand'              => $campaign->user->username,
            'participant_number' => $participant->participant_number,
        ]);

        $notify[] = ['success', 'Campaign job completed successfully'];
        return back()->withNotify($notify);
    }

    public function refund($id) {
        $participant         = Participant::reported()->findOrFail($id);
        $participant->status = Status::CAMPAIGN_JOB_REFUNDED;
        $participant->save();

        $campaign = $participant->campaign;
        if ($campaign->payment_type == 'paid') {
            $brand = $campaign->user;
            $brand->balance += $participant->budget;
            $brand->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $brand->id;
            $transaction->amount       = $participant->budget;
            $transaction->post_balance = $brand->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Campaign job payment refunded';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'campaign_refund';
            $transaction->save();

            notify(@$brand, 'IN_FAVOUR_OF_BRAND', [
                'title'              => $campaign->title,
                'brand'              => $brand->username,
                'participant_number' => $participant->participant_number,
                'budget'             => showAmount($participant->budget,currencyFormat:false),
                'trx'                => $transaction->trx,
            ]);
        }

        notify($participant->influencer, 'CAMPAIGN_JOB_REJECTED', [
            'title'              => $campaign->title,
            'influencer'         => @$participant->influencer->username,
            'brand'              => $campaign->brand_name,
            'participant_number' => $participant->participant_number,
        ]);

        $notify[] = ['success', 'Campaign job payment refunded successfully'];
        return back()->withNotify($notify);
    }
}
