<?php

namespace Tests\Feature\Web\Subscription\SubscriptionController;

use Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function an_inertia_view_containing_necessary_stripe_information_is_returned(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->be($user)->get(route('subscription.create'));


        // Assert

        $response->assertInertia(function (AssertableInertia $inertia) {
            $inertia->component('Subscription/Manage');
            $inertia->has('stripeKey');
            $inertia->has('checkoutSessionId');
            $this->assertSame(config('cashier.key'), $inertia->toArray()['props']['stripeKey']);
            $this->assertNotEmpty($inertia->toArray()['props']['checkoutSessionId']);
        });
    }
}
