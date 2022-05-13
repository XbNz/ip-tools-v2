<?php

namespace Tests\Feature\Web\Authentication\LoginController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateLoginTest extends TestCase
{
    /** @test **/
    public function the_inertia_page_is_rendered(): void
    {
        // Arrange

        // Act
        $response = $this->get(route('auth.login.create'));

        // Assert

        $response->assertInertia(
            fn(AssertableInertia $inertia) => $inertia->component('Auth/Login')
        );
    }


    /** @test */
    public function only_guests_can_access_the_registration_page(): void
    {
        $this->assertRouteUsesMiddleware('auth.login.create', [
            'guest'
        ]);
    }
}
