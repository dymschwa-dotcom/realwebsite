<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;
use Illuminate\Http\Request;

class KycMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // 1. Check Custom Criteria for Brands
        // brand_name + website + company_name + address
        if (!$user->brand_name || !$user->website || !$user->company_name || !$user->address) {
            $notify[] = ['error', 'Please complete your brand profile details (Name, Website, Company, and Address) to proceed.'];
            return to_route('user.profile.setting')->withNotify($notify);
        }

        // 2. Auto-sync KYC status
        if ($user->kv != Status::KYC_VERIFIED) {
            $user->kv = Status::KYC_VERIFIED;
            $user->save();
        }
        return $next($request);
    }
}

