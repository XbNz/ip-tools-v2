<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HasSubscriptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->subscribed('lite') !== true) {
            return Redirect::route('subscription.create');
        }

        // TODO: Test this
        // TODO: Create a subscriptions table matching stripe's with permission configs
        return $next($request);
    }
}
