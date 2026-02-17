<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckServiceCount
{
    public function handle(Request $request, Closure $next)
    {
        $influencer = auth()->guard('influencer')->user();

        // If not logged in, just continue (the 'influencer' middleware handles this)
        if (!$influencer) {
            return $next($request);
        }

        // Count their services
        $serviceCount = $influencer->services()->count();

        // If they have less than 3, and they aren't already on the 'add services' page
        if ($serviceCount < 3 && !$request->routeIs('influencer.services.*')) {
            $notify[] = ['info', 'Please add at least 3 packages to access your dashboard.'];
            return to_route('influencer.services.add')->withNotify($notify);
        }

        return $next($request);
    }
}