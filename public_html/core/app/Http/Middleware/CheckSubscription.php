<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class CheckSubscription
{
    public function handle($request, $next)
{
    $user = auth()->user();

    // 1. If NOT logged in, kick them to the login page
    if (!$user) {
        return redirect()->route('user.login');
    }

    // 2. Check if subscribed and if the plan is still valid
    if (!$user->is_subscribed || ($user->plan_expiry && \Carbon\Carbon::parse($user->plan_expiry)->isPast())) {
        
        // If they were subscribed but it's now past due, update the DB
        if ($user->is_subscribed) {
            $user->is_subscribed = 0;
            $user->save();
        }

        $notify[] = ['error', 'You need an active subscription to access this feature.'];
        return redirect()->route('user.subscribe.activate')->withNotify($notify);
    }

    return $next($request);
}
}