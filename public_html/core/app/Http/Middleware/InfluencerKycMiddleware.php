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
        if ($influencer->kv == Status::KYC_UNVERIFIED) {
            $notify[] = ['error', 'You are not KYC verified. For being KYC verified, please provide these information'];
            return to_route('influencer.kyc.form')->withNotify($notify);
        }
        if ($influencer->kv == Status::KYC_PENDING) {
            $notify[] = ['warning', 'Your documents for KYC verification is under review. Please wait for admin approval'];
            return to_route('influencer.home')->withNotify($notify);
        }
        return $next($request);
    }
}
