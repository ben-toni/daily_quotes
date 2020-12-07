<?php

namespace App\Http\Middleware;

use Closure;

class UnpaidMiddleware
{
    /**
     * Handle an incoming request.
     * If subscriber is paid.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Find subscriber
        $subscriber = $request->route('subscriber');
        // If subscriber is set
        if (isset($subscriber)) {
            // If subscriber is unpaid return 401
            if ($subscriber->status == 'UNPAID') {
                abort(401);
            }
            // Go on
            return $next($request);
        }
    }
}
