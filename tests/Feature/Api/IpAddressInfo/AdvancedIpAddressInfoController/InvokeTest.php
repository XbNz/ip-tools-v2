<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddressInfo\AdvancedIpAddressInfoController;

use Tests\TestCase;
use Tests\Unit\IpAddressInfo\Fakes\FakeDotComDriver;
use XbNz\Resolver\Domain\Ip\Builders\IpBuilder;
use XbNz\Resolver\Support\DTOs\RawResultsData;

class InvokeTest extends TestCase
{

    /** @test **/
    public function given_a_list_of_valid_ip_addresses_it_returns_correctly_formatted_json(): void
    {
        // Arrange
        $mock = $this->mock(IpBuilder::class);
        $mock->shouldReceive('withDrivers')->once();
        $mock->shouldReceive('withIps')->once();
        $mock->shouldReceive('raw')->once()->andReturn([
            new RawResultsData(
                FakeDotComDriver::class,
                [
                    '::doesnt::' => '::matter::',
                ]
            ),
            new RawResultsData(
                FakeDotComDriver::class,
                [
                    '::doesnt::' => '::matter::',
                ]
            ),
        ]);

        $payload = [
            'ip_addresses' => [
                '1.1.1.1',
                '2606:4700:4700::1111',
            ]
        ];

        // Act
        $response = $this->post(route('ip.advanced.show'), $payload);

        // Assert
        $response->assertOk();
        $response->assertJsonStructure([
            'fake.com' => [
                '*' => [
                    'provider',
                    'data' => [],
                ]
            ]
        ]);

        $this->assertCount(2, $response->json()['fake.com']);
    }

    /** @test **/
    public function the_endpoint_is_throttled(): void
    {
        $this->assertRouteUsesMiddleware('ip.advanced.show', ['throttle:20,1']);
    }
}
