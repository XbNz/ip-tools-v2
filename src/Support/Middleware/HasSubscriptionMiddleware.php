<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HasSubscriptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->subscribed() !== true) {
            return Redirect::route('subscription.create');
        }

        return $next($request);
    }
}
