<?php

namespace App\Http\Middleware;

use Closure;
use App\Constants\Status;
use Illuminate\Http\Request;

class InfluencerKycMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        $influencer = authInfluencer();

        // Remove legacy check for KYC_PENDING redirects, as we use automated data-driven KYC

        // 1. Check Tax & Address
        if (!$influencer->tax_number || !$influencer->address) {
            $notify[] = ['error', 'Please complete your tax details (IRD/TFN and Address) in profile settings to proceed.'];
            return to_route('influencer.profile.setting')->withNotify($notify);
        }

        // 2. Check Stripe Onboarding
        if (!$influencer->stripe_onboarded || !$influencer->stripe_account_id) {
            $notify[] = ['error', 'Please complete your Stripe onboarding to proceed.'];
            return to_route('influencer.payment.index')->withNotify($notify);
        }

        // 3. Auto-sync KYC status if data is present but flag is not set
        if ($influencer->kv != Status::KYC_VERIFIED) {
            $influencer->kv = Status::KYC_VERIFIED;
            $influencer->save();
        }

        return $next($request);
    }
}

