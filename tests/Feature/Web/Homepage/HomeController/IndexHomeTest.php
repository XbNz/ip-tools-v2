<?php

namespace Tests\Feature\Web\Homepage\HomeController;

use Inertia\Testing\Assert;
use Tests\TestCase;

class IndexHomeTest extends TestCase
{
    /** @test **/
    public function the_clients_ip_is_detected_using_the_x_forwarded_for_header_to_bypass_cdn_services(): void
    {
        // Arrange
        $this->get(route('home.index'))
            ->header('X-Forwarded-For', '1.1.1.1')
            ->assertInertia(fn(Assert $assert) =>
                $assert->component('Home')
                    ->has()

            );

        // Act

        // Assert
    }
}
