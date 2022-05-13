<?php

namespace Tests\Feature\Web\Authentication\RegisterController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Support\Middleware\RedirectIfAuthenticated;
use Tests\TestCase;

class CreateRegisterTest extends TestCase
{
    /** @test **/
    public function the_inertia_page_is_rendered(): void
    {
        // Arrange

        // Act
        $response = $this->get(route('auth.register.create'));

        // Assert

        $response->assertInertia(
            fn(AssertableInertia $inertia) => $inertia->component('Auth/Register')
        );
    }


    /** @test */
    public function only_guests_can_access_the_registration_page(): void
    {
        $this->assertRouteUsesMiddleware('auth.register.create', [
            'guest'
        ]);
    }
}
