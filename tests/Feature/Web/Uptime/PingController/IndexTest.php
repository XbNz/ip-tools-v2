<?php

namespace Tests\Feature\Web\Uptime\PingController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function an_inertia_component_is_loaded_with_the_users_previously_conducted_ping_tests_in_its_props(): void
    {
        // Arrange

        // Act

        // Assert
    }


    /** @test **/
    public function uses_auth_middleware(): void
    {
        $this->assertRouteUsesMiddleware('uptime.ping.index', ['auth']);
    }
}
