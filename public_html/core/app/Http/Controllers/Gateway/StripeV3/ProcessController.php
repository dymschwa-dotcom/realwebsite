<?php

namespace App\Http\Controllers\Gateway\StripeV3;

use App\Constants\Status;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProcessController extends Controller
{

    public static function process($deposit)
    {
        $StripeAcc = json_decode($deposit->gatewayCurrency()->gateway_parameter);
        $alias = $deposit->gateway->alias;
        \Stripe\Stripe::setApiKey("$StripeAcc->secret_key");
        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'billing_address_collection' => 'required',
                'tax_id_collection' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'trx' => $deposit->trx,
                    'success_action' => $deposit->success_action,
                    'success_action_data' => $deposit->success_action_data,
                ],
                'line_items' => [[
                    'price_data'=>[
                        'unit_amount' => round($deposit->final_amount,2) * 100,
                        'currency' => "$deposit->method_currency",
                        'product_data'=>[
                            'name' => gs('site_name'),
                            'description' => 'Deposit with Stripe',
                            'images' => [siteLogo()],
                        ]
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'cancel_url' => $deposit->failed_url ? (str_starts_with($deposit->failed_url, 'http') ? $deposit->failed_url : route('home').$deposit->failed_url) : route('home').'/user/deposit/history',
                'success_url' => $deposit->success_url ? (str_starts_with($deposit->success_url, 'http') ? $deposit->success_url : route('home').$deposit->success_url) : route('home').'/user/deposit/history',
            );
        } catch (\Exception $e) {
            $send['error'] = true;
            $send['message'] = $e->getMessage();
            return json_encode($send);
        }

        $send['view'] = 'user.payment.'.$alias;
        $send['session'] = $session;
        $send['StripeJSAcc'] = $StripeAcc;
        $deposit->btc_wallet = json_decode(json_encode($session))->id;
        $deposit->save();
        return json_encode($send);
    }


    public function ipn(Request $request)
    {
        $StripeAcc = GatewayCurrency::where('gateway_alias','StripeV3')->orderBy('id','desc')->first();
        $gateway_parameter = json_decode($StripeAcc->gateway_parameter);


        \Stripe\Stripe::setApiKey($gateway_parameter->secret_key);

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $gateway_parameter->end_point; // main
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];


        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the checkout.session.completed event
        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            $deposit = Deposit::where('btc_wallet',  $session->id)->orderBy('id', 'DESC')->first();

            if($deposit && $deposit->status==Status::PAYMENT_INITIATE){

                // Restore metadata to deposit so userDataUpdate knows what to do
                if (isset($session->metadata->success_action)) {
                    $deposit->success_action = $session->metadata->success_action;
                    $deposit->success_action_data = $session->metadata->success_action_data;
                    $deposit->save();
                }

                // Capture Stripe details before updating user data
                $user = $deposit->user;
                if ($user) {
                    $user->kv = Status::KYC_VERIFIED;
                    $kycData = [
                        'stripe_session_id' => $session->id,
                        'verified_by' => 'Stripe Checkout',
                        'verified_at' => now()->toDateTimeString(),
                    ];

                    if (isset($session->customer_details->address)) {
                        $addr = $session->customer_details->address;
                        $user->address = $addr->line1 . ($addr->line2 ? ', ' . $addr->line2 : '');
                        $user->city = $addr->city;
                        $user->zip = $addr->postal_code;
                        $user->country_name = $addr->country;
                    }

                    if (!empty($session->customer_details->tax_ids)) {
                        $kycData['tax_id'] = $session->customer_details->tax_ids[0]->value;
                        $kycData['tax_type'] = $session->customer_details->tax_ids[0]->type;
                    }

                    $user->kyc_data = $kycData;
                    $user->save();
                }

                PaymentController::userDataUpdate($deposit);
            }
        }
        http_response_code(200);
    }
}

