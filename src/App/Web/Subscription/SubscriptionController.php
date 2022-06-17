<?php

namespace App\Web\Subscription;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionController
{
    public function create(
        Request $request,
    ): Response {
        $checkout = $request->user()
            ->newSubscription('lite', 'price_1LBSFxJiu6IURPnYHZXsl5aX')
            ->checkout([
                'success_url' => route('home.index'),
                'cancel_url' => route('home.index'),
            ]);

        return Inertia::render('Subscription/Manage', [
            'stripeKey' => config('cashier.key'),
            'checkoutSessionId' => $checkout->id,
        ]);
    }
}
