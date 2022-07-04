<?php

namespace Tests\Feature\Web\Uptime\UptimeController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class InvokeTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function an_inertia_view_is_rendered(): void
    {
        // Arrange

        // Act
        $response = $this->get(route('uptime.index'));

        // Assert
        $response->assertOk();
        $response->assertInertia(fn(AssertableInertia $inertia) => $inertia->component('Uptime/Index'));
    }
}
