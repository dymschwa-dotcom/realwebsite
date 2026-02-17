<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;

class InfluencerAllowRegistration {

    public function handle($request, Closure $next) {
        if (gs('influencer_registration') == Status::DISABLE) {
            $notify[] = ['error', 'Influencer registration is currently disabled'];
            return back()->withNotify($notify);
        }
        return $next($request);
    }
}
