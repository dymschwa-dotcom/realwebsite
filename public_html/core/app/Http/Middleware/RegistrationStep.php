<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegistrationStep
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

        if (!$user->profile_complete) {
            
            // Define routes that are allowed even if the profile is incomplete
            $allowedRoutes = [
                'user.data',
                'user.data.submit',
                'user.subscribe.activate', // Your new paywall page
                'user.subscribe.now',      // Your payment processing route
                'user.logout'
            ];

            // Check if the current route is in the allowed list
            if (in_array($request->route()->getName(), $allowedRoutes)) {
                return $next($request);
            }

            if ($request->is('api/*')) {
                $notify[] = 'Please complete your profile to go next';
                return response()->json([
                    'remark' => 'profile_incomplete',
                    'status' => 'error',
                    'message' => ['error' => $notify],
                ]);
            } else {
                return to_route('user.data');
            }
        }

        return $next($request);
    }
}