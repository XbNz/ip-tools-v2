<?php

namespace Tests\Unit\Middleware;

use Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Database\Factories\SubscriptionFactory;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;
use Tests\TestCase;

class HasSubscriptionMiddlewareTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        Route::get('/middleware-test', fn () => 'middleware-test')->middleware('subscribed');
    }

    /** @test **/
    public function subscribed_users_can_access_routes(): void
    {
        // Arrange
        $subscribedUser = User::factory()->has(Subscription::factory())->create();

        // Act
        $response = $this->be($subscribedUser)->get('/middleware-test');

        // Assert
        $response->assertOk();
    }

    /** @test **/
    public function unsubscribed_users_are_redirected_to_create_a_subscription(): void
    {
        // Arrange
        $unsubscribedUser = User::factory()->create();

        // Act
        $response = $this->be($unsubscribedUser)->get('/middleware-test');

        // Assert
        $response->assertRedirect(route('subscription.create'));
        $response->assertStatus(302);
    }
}
