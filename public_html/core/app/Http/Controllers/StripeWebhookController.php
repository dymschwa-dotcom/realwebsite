<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'account.updated':
                $account = $event->data->object;
                $this->handleAccountUpdate($account);
                break;
            
            // Add other events as needed
            default:
                Log::info('Unhandled Stripe event type ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleAccountUpdate($account)
    {
        $influencer = Influencer::where('stripe_account_id', $account->id)->first();
        
        if ($influencer) {
            // Check if they are still eligible to receive transfers
            $canReceiveTransfers = $account->details_submitted && 
                                  $account->charges_enabled && 
                                  $account->payouts_enabled;
            
            $influencer->stripe_onboarded = $canReceiveTransfers;

            // Sync with internal KYC status
            if ($canReceiveTransfers) {
                $influencer->kv = Status::KYC_VERIFIED;
            }

            $influencer->save();
            
            Log::info("Influencer {$influencer->username} Stripe status updated: " . ($canReceiveTransfers ? 'Active' : 'Restricted'));
        }
    }
}

