<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddressInfo\IpAddressInfoController;

use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Tests\Feature\Api\IpAddressInfo\Mocks\FakeDriver;
use Tests\TestCase;
use Tests\Unit\IpAddressInfo\Fakes\FakeDotComDriver;
use XbNz\Resolver\Domain\Ip\Builders\IpBuilder;
use XbNz\Resolver\Domain\Ip\DTOs\NormalizedGeolocationResultsData;
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
        $mock->shouldReceive('normalize')->once()->andReturn([
            new NormalizedGeolocationResultsData(
                FakeDotComDriver::class,
                '1.1.1.1',
                '::Fakemenistan::',
                '::Fakesville::',
                11.11,
                22.22,
                '::FakeLLC::',
            ),
            new NormalizedGeolocationResultsData(
                FakeDotComDriver::class,
                '8.8.8.8',
                '::Fakemenistan::',
                '::Fakesville::',
                11.11,
                22.22,
                '::FakeLLC::',
            ),
        ]);

        $payload = [
            'ip_addresses' => [
                '1.1.1.1',
                '2606:4700:4700::1111',
            ]
        ];

        // Act
        $response = $this->post(route('ip.show'), $payload);

        // Assert
        $response->assertOk();
        $response->assertJsonStructure([
            'fake.com' => [
                '*' => [
                    'provider',
                    'ip',
                    'country',
                    'city',
                    'latitude',
                    'longitude',
                    'organization'
                ]
            ]
        ]);

        $this->assertCount(2, $response->json()['fake.com']);
    }

    /** @test **/
    public function the_endpoint_is_throttled(): void
    {
        $this->assertRouteUsesMiddleware('ip.show', ['throttle:20,1']);
    }
}
