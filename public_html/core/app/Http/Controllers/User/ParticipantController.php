<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Campaign;
use App\Models\Participant;
use App\Models\Transaction;
use App\Traits\ConversationForCampaign;
use Illuminate\Http\Request;

class ParticipantController extends Controller {

    use ConversationForCampaign;

    public function __construct() {

        $this->activeTemplate = activeTemplate();
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->userType = 'user';
    }

    public function list(Request $request, $id) {
        $pageTitle    = 'Participants List';
        $campaign     = Campaign::where('user_id', auth()->id())->findOrFail($id);
        $participants = $campaign->participants();
        if ($request->status && $request->status != 'all') {
            $status = $request->status;
            $participants->$status();
        }
        $participants = $participants->searchable(['participant_number', 'influencer:username'])->with('influencer')->withCount('review')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.campaign.participants', compact('pageTitle', 'campaign', 'participants'));
    }

    public function accept($id) {
        $participant = Participant::pending()->authCampaign()->with('influencer')->findOrFail($id);

        $acceptParticipant = Participant::accepted()->where('campaign_id', $participant->campaign_id)->count();
        if ($acceptParticipant >= $participant->campaign->influencer_requirements->required_influencer) {
            $notify[] = ['error', 'The required influencer limit is over'];
            return back()->withNotify($notify);
        }

        $brand    = auth()->user();
        
        $campaign = $participant->campaign;

        $general     = gs();
        $commission  = ($participant->budget * $general->brand_campaign_commission) / 100;
        
        $gstOnCommission = ($commission * $general->marketplace_commission_gst_rate) / 100;
        $gstOnService = ($participant->budget * $general->influencer_gst_rate) / 100;
        $gstAmount = $gstOnCommission + $gstOnService;
        
        $totalAmount = $participant->budget + $commission + $gstAmount;
        
        if ($totalAmount > $brand->balance) {
            $notify[] = ['info', 'Redirecting to secure checkout to complete hiring'];
            return to_route('user.deposit.index', [
                'amount'              => getAmount($totalAmount),
                'price'               => getAmount($participant->budget),
                'service_fee'         => getAmount($commission),
                'gst_amount'          => getAmount($gstAmount),
                'success_action'      => 'hire_influencer',
                'success_action_data' => json_encode(['participant_id' => $id]),
                'direct_checkout'     => 1, // Add flag for direct checkout
                'gateway'             => 'StripeV3' // Force Stripe for direct feel
            ])->withNotify($notify);
        }

        $influencer = $participant->influencer;

        $participant->status = Status::PARTICIPATE_REQUEST_ACCEPTED;
        $participant->gst_amount = $gstAmount;
        $participant->influencer_is_gst_registered = $influencer->is_gst_registered;
        $participant->influencer_country_code = $influencer->country_code;
        $participant->save();

        if ($participant->budget > 0) {
            $brand->balance -= $totalAmount;
            $brand->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $brand->id;
            $transaction->amount       = $totalAmount;
            $transaction->post_balance = $brand->balance;
            $transaction->charge       = $commission;
            $transaction->gst_amount   = $gstAmount;
            $transaction->trx_type     = '-';
            $transaction->details      = 'Accepted the influencer for the campaign (Incl. GST)';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'campaign';
            $transaction->save();

            notify($brand, 'BRAND_ACCEPT_REQUEST', [
                'brand'              => $brand->username,
                'influencer'         => $influencer->username,
                'title'              => $campaign->title,
                'budget'             => showAmount($participant->budget),
                'post_balance'       => showAmount($brand->balance),
                'trx'                => $transaction->trx,
                'participant_number' => $participant->participant_number,
            ]);
        }

        notify($influencer, 'PARTICIPATE_REQUEST_ACCEPTED', [
            'influencer'         => $influencer->username,
            'brand'              => $brand->username,
            'participant_number' => $participant->participant_number,
            'title'              => $campaign->title,
        ]);

        recentActivity('You have accepted the ' . $influencer->username . ' participation request', $brand->id);
        recentActivity($brand->username . ' has accepted your participant request', 0, $influencer->id);

        $notify[] = ['success', 'Campaign participation request accepted successfully'];
        return back()->withNotify($notify);
    }

    public function reject($id) {
        $participant         = Participant::pending()->authCampaign()->with('influencer')->findOrFail($id);
        $participant->status = Status::PARTICIPATE_REQUEST_REJECTED;
        $participant->save();

        $brand      = auth()->user();
        $influencer = $participant->influencer;
        notify($influencer, 'PARTICIPATE_REQUEST_REJECTED', [
            'influencer'         => @$influencer->username,
            'brand'              => $brand->username,
            'participant_number' => $participant->participant_number,
            'title'              => @$participant->campaign->title,
        ]);

        recentActivity('You have rejected the ' . $influencer->username . ' participation request', $brand->id);
        recentActivity($brand->username . ' has rejected your participation request', 0, $influencer->id);

        $notify[] = ['success', 'Campaign participation request rejected successfully'];
        return back()->withNotify($notify);
    }

    public function detail($id) {
        $pageTitle = 'Campaign Detail';
        $applicant = Participant::authCampaign()->with(['influencer' => function ($query) {
            $query->withCount('jobCompleted', 'jobRunning');
        }])->findOrFail($id);
        return view('Template::user.campaign.detail', compact('pageTitle', 'applicant'));
    }

    public function completed($id) {
        $participant         = Participant::delivered()->authCampaign()->with('influencer')->findOrFail($id);
        $participant->status = Status::CAMPAIGN_JOB_COMPLETED;
        
        $general = gs();
        
        // Calculate Marketplace Commission GST
        $commission = ($participant->budget * $general->influencer_campaign_commission) / 100;
        $commissionGst = ($commission * $general->marketplace_commission_gst_rate) / 100;
        
        // Calculate Influencer Service GST
            $influencerGst = ($participant->budget * $general->influencer_gst_rate) / 100;
        
        // Calculate 8.5% Return if not GST registered
        $gstReturn = 0;
        if (!$participant->influencer->is_gst_registered && $participant->influencer->country_code == 'NZ') {
            $gstReturn = ($participant->budget * $general->marketplace_gst_return_rate) / 100;
        }
        
        $participant->commission_gst_amount         = $commissionGst;
        $participant->influencer_gst_amount         = $influencerGst;
        $participant->marketplace_gst_return_amount = $gstReturn;
        
        $participant->save();
        $participant->campaign->status = Status::CAMPAIGN_COMPLETED; // This ensures the Campaign Dashboard shows 'Completed'
        $participant->campaign->save();
        
        $influencer = $participant->influencer;
        $campaign   = $participant->campaign;

        $payableAmount = $participant->budget - $commission;
        
        // Handle 8.5% return logic: Only add it if NOT registered and setting says to
        if (!$participant->influencer->is_gst_registered && $participant->influencer->country_code == 'NZ' && $general->marketplace_gst_return_to == 1) { // To Influencer
            $payableAmount += $gstReturn;
        }

        if ($campaign->payment_type == 'paid') {
            // NEW STRIPE CONNECT LOGIC - Ensure all platform KYC requirements are met
            if ($influencer->stripe_onboarded && $influencer->stripe_account_id && $influencer->tax_number && $influencer->address && $influencer->kv == Status::KYC_VERIFIED) {
                try {
                    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                    \Stripe\Transfer::create([
                        'amount'         => round($payableAmount * 100), // Stripe uses cents
                        'currency'       => strtolower($general->cur_text),
                        'destination'    => $influencer->stripe_account_id,
                        'transfer_group' => 'CAMPAIGN_' . $participant->id,
                        'description'    => 'Payment for Campaign: ' . $participant->campaign->title,
                    ]);

                    $participant->is_paid_via_stripe = true;
                    $participant->save();

                } catch (\Exception $e) {
                    $influencer->balance += $payableAmount;
                    \Log::error("Stripe Transfer Failed for Participant {$participant->id}: " . $e->getMessage());
                }
            } else {
                $influencer->balance += $payableAmount;
            }
        }

        $influencer->increment('order_completed');
        $influencer->save();

        if ($campaign->payment_type == 'paid') {
            $transaction                = new Transaction();
            $transaction->influencer_id = $influencer->id;
            $transaction->amount        = $payableAmount;
            $transaction->post_balance  = $influencer->balance;
            $transaction->charge        = $commission;
            $transaction->trx_type      = '+';
            $transaction->details       = 'Campaign job completed';
            if (!$participant->influencer->is_gst_registered && $participant->influencer->country_code == 'NZ' && $general->marketplace_gst_return_to == 1) {
                $transaction->details .= ' (Incl. GST Return)';
            }
            $transaction->trx           = getTrx();
            $transaction->remark        = 'campaign_completed';
            $transaction->save();

            notify(@$influencer, 'CAMPAIGN_JOB_COMPLETED', [
                'influencer'         => @$influencer->username,
                'brand'              => $participant->campaign->user->username,
                'participant_number' => $participant->participant_number,
                'budget'             => showAmount($payableAmount, currencyFormat: false),
                'trx'                => $transaction->trx,
            ]);
        }

        recentActivity('You have decided your campaign job is completed', @$campaign->user->id);
        recentActivity(@$campaign->user->username . ' has decided campaign job is completed', 0, $influencer->id);

        $notify[] = ['success', 'The campaign job completed successfully'];
        
        // Redirect to Review Form instead of just back
        return to_route('user.review.form', $participant->id)->withNotify($notify);

    }
    public function reported(Request $request, $id) {
        $request->validate([
            'report_reason' => 'required|string',
        ]);

        $participant                = Participant::delivered()->authCampaign()->with('influencer')->findOrFail($id);
        $participant->report_reason = $request->report_reason;
        $participant->status        = Status::CAMPAIGN_JOB_REPORTED;
        $participant->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $participant->campaign->user_id;
        $adminNotification->title     = 'Campaign job is reported by ' . $participant->campaign->user->username;
        $adminNotification->click_url = route('admin.campaign.conversation', $participant->id);
        $adminNotification->save();

        notify(@$participant->influencer, 'CAMPAIGN_JOB_REPORTED', [
            'influencer'         => @$participant->influencer->username,
            'brand'              => $participant->campaign->user->username,
            'participant_number' => $participant->participant_number,
            'title'              => $participant->campaign->title,
            'reason'             => $participant->report_reason,
        ]);

        $brand = $participant->campaign->user;
        recentActivity('You have reported on your campaign job', @$brand->id);
        recentActivity(@$brand->username . ' has reported campaign job', 0, @$participant->influencer->id);

        $notify[] = ['success', 'The campaign job reported to successfully'];
        return back()->withNotify($notify);
    }

    public function buyService(Request $request, $id) {
        $package = \App\Models\InfluencerPackage::findOrFail($id);
        $brand   = auth()->user();

        if ($brand->plan_id == 1) {
            $notify[] = ['error', 'Please upgrade your plan to purchase services.'];
            return to_route('pricing')->withNotify($notify);
        }
        
        $general     = gs();
        $commission  = ($package->price * $general->brand_campaign_commission) / 100;
        
        $gstOnCommission = ($commission * $general->marketplace_commission_gst_rate) / 100;
        
        $gstOnService = ($package->price * $general->influencer_gst_rate) / 100;

        $gstAmount = $gstOnCommission + $gstOnService;
        $totalAmount = $package->price + $commission + $gstAmount;
        
        if ($brand->balance < $totalAmount) {
            $notify[] = ['info', 'Redirecting to secure checkout to complete purchase'];
            return to_route('user.deposit.index', [
                'amount'              => getAmount($totalAmount),
                'price'               => getAmount($package->price),
                'service_fee'         => getAmount($commission),
                'gst_amount'          => getAmount($gstAmount),
                'success_action'      => 'buy_service',
                'success_action_data' => json_encode(['package_id' => $id])
            ])->withNotify($notify);
        }

        $influencer = \App\Models\Influencer::active()->findOrFail($package->influencer_id);

        // 1. Create a Shadow Campaign
        $campaign                = new Campaign();
        $campaign->user_id       = $brand->id;
        $campaign->title         = "Service: " . $package->name;
        $campaign->slug          = slug($campaign->title) . '-' . getTrx(5);
        $campaign->campaign_type = 'invite';
        $campaign->payment_type  = 'paid';
        $campaign->budget        = $package->price;
        $campaign->status        = Status::CAMPAIGN_APPROVED;
        $campaign->start_date    = now();
        $campaign->end_date      = now()->addDays($package->delivery_time ?? 30);
        $campaign->description   = $package->description;

        // Generic defaults for shadow campaigns
        $campaign->promoting_type  = 'digital';
        $campaign->send_product    = 'no';
        $campaign->content_creator = 'influencer';
        $campaign->campaign_step   = Status::CAMPAIGN_BUDGET;

        // Map requirements based on the platform
        $platform = \App\Models\Platform::find($package->platform_id);
        
        $campaign->content_requirements = [
            'post_count'   => $package->post_count ?? 1,
            'video_length' => $package->video_length,
        ];

        if ($platform) {
            $pName    = strtolower($platform->name);
        $countKey = in_array($pName, ['youtube', 'tiktok']) ? $pName . '_video_count' : $pName . '_post_count';

            $campaign->content_requirements[$countKey] = $package->post_count ?? 1;
            $campaign->content_requirements[$pName . '_type'] = [$pName == 'instagram' || $pName == 'facebook' ? 'photo' : 'video'];
            $campaign->content_requirements[$pName . '_placement'] = ['post'];
        }

        $campaign->influencer_requirements = [
            'required_influencer' => 1,
            'gender' => ['male', 'female', 'other'],
        ];
        $campaign->save();

        if ($package->platform_id) {
            $campaign->platforms()->attach($package->platform_id);
        }
        
        // 2. Create Participant (The Order)
        $participant                     = new Participant();
        $participant->campaign_id        = $campaign->id;
        $participant->influencer_id      = $influencer->id;
        $participant->budget             = $package->price;
        $participant->status             = Status::PARTICIPATE_REQUEST_ACCEPTED;
        $participant->participant_number = getTrx();
        $participant->gst_amount         = $gstAmount;
        $participant->influencer_is_gst_registered = $influencer->is_gst_registered;
        $participant->influencer_country_code = $influencer->country_code;
        $participant->save();

        // 3. Deduct Balance & Create Transaction
        $brand->balance -= $totalAmount;
        $brand->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $brand->id;
        $transaction->amount       = $totalAmount;
        $transaction->post_balance = $brand->balance;
        $transaction->charge       = $commission;
        $transaction->gst_amount   = $gstAmount;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Purchased service: ' . $package->name . ' (Incl. GST)';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'service_purchase';
        $transaction->save();

        // 4. Notifications
        notify($brand, 'BRAND_ACCEPT_REQUEST', [
            'brand'              => $brand->username,
            'influencer'         => $influencer->username,
            'title'              => $campaign->title,
            'budget'             => showAmount($package->price),
            'post_balance'       => showAmount($brand->balance),
            'trx'                => $transaction->trx,
            'participant_number' => $participant->participant_number,
        ]);

        notify($influencer, 'PARTICIPATE_REQUEST_ACCEPTED', [
            'influencer'         => $influencer->username,
            'brand'              => $brand->username,
            'participant_number' => $participant->participant_number,
            'title'              => $campaign->title,
        ]);
        recentActivity('You purchased service ' . $package->name . ' from ' . $influencer->username, $brand->id);
        recentActivity($brand->username . ' purchased your service ' . $package->name, 0, $influencer->id);

        $notify[] = ['success', 'Service purchased successfully!'];
        // Redirect to user.participant.detail instead of conversation inbox
        return to_route('user.participant.detail', $participant->id)->withNotify($notify);
    }

    public function hireFromInquiry(Request $request, $id) {
        $request->validate([
            'budget' => 'required|numeric|gt:0',
        ]);

        $participant = Participant::where('status', Status::PARTICIPATE_INQUIRY)
            ->whereHas('campaign', function($q) {
                $q->where('user_id', auth()->id());
            })->findOrFail($id);
        $brand = auth()->user();

        if ($brand->plan_id == 1) {
            $notify[] = ['error', 'Please upgrade your plan to hire influencers.'];
            return to_route('pricing')->withNotify($notify);
        }

        $general     = gs();
        $commission  = ($request->budget * $general->brand_campaign_commission) / 100;
        
        $gstOnCommission = ($commission * $general->marketplace_commission_gst_rate) / 100;
        $gstOnService = ($request->budget * $general->influencer_gst_rate) / 100;
        $gstAmount = $gstOnCommission + $gstOnService;
        
        $totalAmount = $request->budget + $commission + $gstAmount;
        
        if ($brand->balance < $totalAmount) {
            $notify[] = ['info', 'Redirecting to secure checkout to complete hiring'];
            return to_route('user.deposit.index', [
                'amount'              => getAmount($totalAmount),
                'price'               => getAmount($request->budget),
                'service_fee'         => getAmount($commission),
                'gst_amount'          => getAmount($gstAmount),
                'success_action'      => 'hire_from_inquiry',
                'success_action_data' => json_encode(['participant_id' => $id, 'budget' => $request->budget])
            ])->withNotify($notify);
        }

        // 1. Update Campaign Budget
        $campaign = $participant->campaign;
        $campaign->budget = $request->budget;
        $campaign->save();

        // 2. Update Participant
        $participant->budget     = $request->budget;
                $participant->status = Status::PARTICIPATE_REQUEST_ACCEPTED;
        $participant->gst_amount = $gstAmount;
        $participant->influencer_is_gst_registered = $participant->influencer->is_gst_registered;
        $participant->influencer_country_code = $participant->influencer->country_code;
        $participant->save();

        // 3. Deduct Balance & Create Transaction
        $brand->balance -= $totalAmount;
        $brand->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $brand->id;
        $transaction->amount       = $totalAmount;
        $transaction->post_balance = $brand->balance;
        $transaction->charge       = $commission;
        $transaction->gst_amount   = $gstAmount;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Hired from inquiry: ' . $campaign->title . ' (Incl. GST)';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'service_purchase';
        $transaction->save();

        $notify[] = ['success', 'Influencer hired successfully!'];
        return back()->withNotify($notify);
    }

    public function closeInquiry($id) {
        $participant = Participant::where('status', Status::PARTICIPATE_INQUIRY)->findOrFail($id);

        // 1. Mark the participant (job) as completed
        $participant->status = Status::CAMPAIGN_JOB_COMPLETED;
        $participant->save();

        // 2. Mark the shadow campaign as completed
        $participant->campaign->status = Status::CAMPAIGN_COMPLETED;
        $participant->campaign->save();

        $notify[] = ['success', 'Inquiry closed and archived successfully'];
        return back()->withNotify($notify);
    }

    public function sendProposal(Request $request, $id) {
        $request->validate([
            'title'         => 'required|string|max:255',
            'price'         => 'required|numeric|gt:0',
            'delivery_time' => 'required|integer|min:1',
            'platform_id'   => 'nullable|integer|exists:platforms,id',
            'post_count'    => 'nullable|integer|min:1',
            'video_length'  => 'nullable|integer|min:0',
            'description'   => 'required|string',
        ]);
        $participant = Participant::where('status', Status::PARTICIPATE_INQUIRY)
            ->where('influencer_id', auth()->guard('influencer')->id())
            ->findOrFail($id);

        $influencer = auth()->guard('influencer')->user();
        $brand      = $participant->campaign->user;

        // 1. Create a Shadow Campaign for the Proposal
        $campaign               = new \App\Models\Campaign();
        $campaign->user_id      = $brand->id;
        $campaign->title        = $request->title;
        $campaign->slug         = slug($campaign->title) . '-' . getTrx(5);
        $campaign->campaign_type = 'invite';
        $campaign->payment_type = 'paid';
        $campaign->budget       = $request->price;
        $campaign->status       = Status::CAMPAIGN_APPROVED;
        $campaign->start_date   = now();
        $campaign->end_date     = now()->addDays($request->delivery_time);
        $campaign->description  = $request->description;

        // Generic defaults
        $campaign->promoting_type  = 'digital';
        $campaign->send_product    = 'no';
        $campaign->content_creator = 'influencer';
        $campaign->campaign_step   = Status::CAMPAIGN_BUDGET;

        $platform = \App\Models\Platform::find($request->platform_id);

        if ($platform) {
            $pName    = strtolower($platform->name);
            $countKey = in_array($pName, ['youtube', 'tiktok']) ? $pName . '_video_count' : $pName . '_post_count';
            $campaign->content_requirements = [
                $countKey             => $request->post_count ?? 1,
                'video_length'        => $request->video_length,
                $pName . '_type'      => [$pName == 'instagram' || $pName == 'facebook' ? 'photo' : 'video'],
                $pName . '_placement' => ['post']
            ];
        } else {
            $campaign->content_requirements = [
                'post_count'   => $request->post_count ?? 1,
                'video_length' => $request->video_length
            ];
        }
        $campaign->save();
        if ($request->platform_id) {
            $campaign->platforms()->attach($request->platform_id);
        }

        // 2. Create the Proposal Participant record
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

        if ($brand->plan_id == 1) {
            $notify[] = ['error', 'Please upgrade your plan to accept proposals.'];
            return to_route('pricing')->withNotify($notify);
        }
        
        $general     = gs();
        $commission  = ($proposal->budget * $general->brand_campaign_commission) / 100;
        
        $gstOnCommission = ($commission * $general->marketplace_commission_gst_rate) / 100;
        $gstOnService = ($proposal->budget * $general->influencer_gst_rate) / 100;
        $gstAmount = $gstOnCommission + $gstOnService;
        
        $totalAmount = $proposal->budget + $commission + $gstAmount;
        
        if ($brand->balance < $totalAmount) {
            $notify[] = ['info', 'Redirecting to secure checkout to complete hiring'];
            return to_route('user.deposit.index', [
                'amount'              => getAmount($totalAmount),
                'price'               => getAmount($proposal->budget),
                'service_fee'         => getAmount($commission),
                'gst_amount'          => getAmount($gstAmount),
                'success_action'      => 'accept_proposal',
                'success_action_data' => json_encode(['proposal_id' => $id])
            ])->withNotify($notify);
        }

        // 1. Deduct Balance & Create Transaction
        $brand->balance -= $totalAmount;
        $brand->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $brand->id;
        $transaction->amount       = $totalAmount;
        $transaction->post_balance = $brand->balance;
        $transaction->charge       = $commission;
        $transaction->gst_amount   = $gstAmount;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Accepted proposal: ' . $proposal->campaign->title . ' (Incl. GST)';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'proposal_acceptance';
        $transaction->save();

        // 2. Move to Accepted Status
        $proposal->status     = Status::PARTICIPATE_REQUEST_ACCEPTED;
        $proposal->gst_amount = $gstAmount;
        $proposal->influencer_is_gst_registered = $proposal->influencer->is_gst_registered;
        $proposal->influencer_country_code = $proposal->influencer->country_code;
        $proposal->save();

        // 3. Auto-Archive: Close any open "General Inquiry" threads between these two users
        // This moves them from 'Inquiry' tab to 'Closed' tab as "Resolved"
        Participant::where('influencer_id', $proposal->influencer_id)
            ->where('status', Status::PARTICIPATE_INQUIRY)
            ->whereHas('campaign', function($q) use ($brand) {
                $q->where('user_id', $brand->id);
            })
            ->update(['status' => Status::CAMPAIGN_JOB_COMPLETED]);

        $notify[] = ['success', 'Proposal accepted and hired!'];
        // Redirect to conversation inbox (workspace) instead of detail
        return to_route('user.participant.conversation.inbox', $proposal->id)->withNotify($notify);
    }

    public function rejectProposal($id) {
        $proposal = Participant::where('status', Status::PARTICIPATE_PROPOSAL)
            ->whereHas('campaign', function($q) {
                $q->where('user_id', auth()->id());
            })->findOrFail($id);

        $proposal->status = Status::PARTICIPATE_REQUEST_REJECTED;
        $proposal->save();

        // Also mark the shadow campaign as cancelled so it doesn't clutter
        $proposal->campaign->status = Status::CAMPAIGN_JOB_CANCELED;
        $proposal->campaign->save();

        notify($proposal->influencer, 'PARTICIPATE_REQUEST_REJECTED', [
            'influencer'         => $proposal->influencer->username,
            'brand'              => auth()->user()->username,
            'participant_number' => $proposal->participant_number,
            'title'              => $proposal->campaign->title,
        ]);

        $notify[] = ['success', 'Proposal rejected successfully'];
        return back()->withNotify($notify);
    }

    public function createInquiry($influencerId) {
        $brand      = auth()->user();

        if ($brand->plan_id == 1) {
            $notify[] = ['error', 'Please upgrade your plan to message influencers.'];
            return to_route('pricing')->withNotify($notify);
        }

        $influencer = \App\Models\Influencer::active()->findOrFail($influencerId);

        // Check if an inquiry or participant already exists between them for a "General" purpose
        // to avoid duplicate inquiry threads.
        $existing = Participant::where('influencer_id', $influencer->id)
            ->whereHas('campaign', function($q) use ($brand) {
                $q->where('user_id', $brand->id)->where('title', 'LIKE', 'General Inquiry%');
            })
            ->whereNotIn('status', [Status::CAMPAIGN_JOB_COMPLETED, Status::CAMPAIGN_JOB_CANCELED, Status::CAMPAIGN_JOB_REFUNDED, Status::PARTICIPATE_REQUEST_REJECTED])
            ->first();

        if ($existing) {
            return to_route('user.participant.conversation.inbox', $existing->id);
        }

        // 1. Create a Shadow Campaign for the Inquiry
        $campaign               = new \App\Models\Campaign();
        $campaign->user_id      = $brand->id;
        $campaign->title        = "General Inquiry: " . $brand->username . " x " . $influencer->username;
        $campaign->slug         = slug($campaign->title) . '-' . getTrx(5);
        $campaign->campaign_type = 'invite';
        $campaign->payment_type = 'paid'; // Standard type
        $campaign->budget       = 0;
        $campaign->status       = Status::CAMPAIGN_APPROVED;
        $campaign->start_date   = now();
        $campaign->end_date     = now()->addYears(10);

        // Generic defaults
        $campaign->promoting_type  = 'digital';
        $campaign->send_product    = 'no';
        $campaign->content_creator = 'influencer';
        $campaign->campaign_step   = Status::CAMPAIGN_BUDGET;

        $campaign->influencer_requirements = [
            'required_influencer' => 1,
            'gender' => ['male', 'female', 'other'],
        ];
        $campaign->save();

        // 2. Create Participant (The Inquiry Thread)
        $participant                     = new \App\Models\Participant();
        $participant->campaign_id        = $campaign->id;
        $participant->influencer_id      = $influencer->id;
        $participant->budget             = 0;
        $participant->status             = Status::PARTICIPATE_INQUIRY;
        $participant->participant_number = getTrx();
        $participant->save();

        recentActivity('Started a conversation with ' . $influencer->username, $brand->id);

        return to_route('user.participant.conversation.inbox', $participant->id);
    }
}


