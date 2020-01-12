<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Cache;
use Illuminate\Http\Request;

class IsOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if (!is_null(auth('api')->user())) {
    		$user = auth('api')->user();
    		$expiresAt = Carbon::now()->addMinutes(5);
    		Cache::put('user-is-online-' . $user->id, true, $expiresAt);

    	}
        return $next($request);
    }
}
