<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;

class StripeConnectController extends Controller
{
    public function index()
    {
        $pageTitle = 'Payment Settings';
        $influencer = authInfluencer();
        return view('Template::influencer.payment.index', compact('pageTitle', 'influencer'));
    }

    public function connect()
    {
        $influencer = authInfluencer();
        
        $stripeSecret = config('services.stripe.secret');

        if (!$stripeSecret) {
            $notify[] = ['error', 'Stripe is not configured. Please ensure STRIPE_SECRET_KEY is in your .env file.'];
            return back()->withNotify($notify);
        }

        Stripe::setApiKey($stripeSecret);

        try {
            // 1. Create a Stripe Account if they don't have one
            if (!$influencer->stripe_account_id) {
                $account = Account::create([
                    'type' => 'express',
                    'email' => $influencer->email,
                    'capabilities' => [
                        'transfers' => ['requested' => true],
                    ],
                ]);
                $influencer->stripe_account_id = $account->id;
                $influencer->save();
            }

            // 2. If already onboarded, generate a Login Link to the Express Dashboard
            if ($influencer->stripe_onboarded) {
                $loginLink = Account::createLoginLink($influencer->stripe_account_id);
                return redirect($loginLink->url);
            }
            // 3. Otherwise, create the Account Link (The Onboarding URL)
            $accountLink = AccountLink::create([
                'account' => $influencer->stripe_account_id,
                'refresh_url' => route('influencer.payment.stripe.connect'), // Restart if it expires
                'return_url' => route('influencer.payment.stripe.callback'), // Success callback
                'type' => 'account_onboarding',
            ]);

            return redirect($accountLink->url);

        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    public function callback()
    {
        $influencer = authInfluencer();
        $stripeSecret = config('services.stripe.secret');
        Stripe::setApiKey($stripeSecret);

        try {
            $account = Account::retrieve($influencer->stripe_account_id);
            
            if ($account->details_submitted) {
                $influencer->stripe_onboarded = true;

                // Auto-verify Influencer if other criteria are met
                if ($influencer->tax_number && $influencer->address) {
                    $influencer->kv = \App\Constants\Status::KYC_VERIFIED;
                }

                $influencer->save();
                
                $notify[] = ['success', 'Stripe account connected successfully! You will now receive payments directly.'];
            } else {
                $notify[] = ['warning', 'Onboarding was not completed. Please try again.'];
            }

            return redirect()->route('influencer.payment.index')->withNotify($notify);

        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            return redirect()->route('influencer.payment.index')->withNotify($notify);
        }
    }
}

