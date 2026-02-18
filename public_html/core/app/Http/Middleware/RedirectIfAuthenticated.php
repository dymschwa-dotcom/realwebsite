<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            if ($guard == 'admin') {
                return to_route('admin.dashboard');
            } elseif ($guard == 'influencer') {
                return to_route('influencer.home');
            }
            return to_route('user.home');
        }

        return $next($request);
    }
}

