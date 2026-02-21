<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return $next($request);
        }

        // Basic routes that should always be accessible
        $allowedRoutes = [
            'user.home',
            'user.profile.setting',
            'user.change.password',
            'user.twofactor',
            'user.deposit.history',
            'user.transactions',
            'user.ticket.*',
            'pricing',
            'user.logout'
        ];

        foreach ($allowedRoutes as $route) {
            if ($request->routeIs($route)) {
                return $next($request);
            }
        }

        if (!$user->plan_id || ($user->plan_ends_at && $user->plan_ends_at < now())) {
            $notify[] = ['error', 'Please subscribe to a plan to access this feature.'];
            return to_route('pricing')->withNotify($notify);
        }

        return $next($request);
    }
}
