<?php

declare(strict_types=1);

namespace Tests\Feature\Web\Homepage\HomeController;

use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Domain\IpAddressInfo\Actions\PrepareNormalizedIpDataAction;
use Domain\IpAddressInfo\Actions\PrepareRawIpDataAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Inertia\Testing\AssertableInertia;
use Mockery;
use Support\Actions\FriendlyDriverNameAction;
use Support\Middleware\TrustProxies;
use Tests\TestCase;
use Tests\Unit\IpAddressInfo\Fakes\FakeDotComDriver;
use XbNz\Resolver\Domain\Ip\Builders\IpBuilder;
use XbNz\Resolver\Domain\Ip\DTOs\NormalizedGeolocationResultsData;
use XbNz\Resolver\Support\DTOs\RawResultsData;

class IndexHomeTest extends TestCase
{
    /** @test */
    public function ip_data_objects_are_made_available_to_the_vue_component_with_friendly_driver_names(): void
    {
        // Arrange
        $mockRawAction = $this->mock(PrepareRawIpDataAction::class);
        $mockNormalizedAction = $this->mock(PrepareNormalizedIpDataAction::class);

        $mockRawAction->shouldReceive('__invoke')->once()->with(['1.1.1.1'])->andReturn([
            '::fake.com::' => [
                new RawResultsData(FakeDotComDriver::class, ['::no-one-cares::' => '::can-be-anything::']),
            ]
        ]);

        $mockNormalizedAction->shouldReceive('__invoke')->once()->with(['1.1.1.1'])->andReturn([
            '::fake.com::' => [
                new NormalizedGeolocationResultsData(
                    FakeDotComDriver::class,
                    '1.1.1.1',
                    '::Fakemenistan::',
                    '::Fakesville::',
                    11.11,
                    22.22,
                    '::FakeLLC::',
                ),
            ]
        ]);


        $middlewareMock = $this->createPartialMock(TrustProxies::class, []);
        invade($middlewareMock)->proxies = '*';
        $this->swap(TrustProxies::class, $middlewareMock);

        // Act
        $response = $this->get(route('home.index'), [
            'X-Forwarded-For' => '1.1.1.1',
        ]);

        // Assert
        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $inertia) {
            $inertia->component('Home');
            $inertia->has('guaranteedClientIpData');
            $inertia->has('advancedClientIpData');
            $this->assertCount(1, $inertia->toArray()['props']['guaranteedClientIpData']['::fake.com::']);
            $this->assertCount(1, $inertia->toArray()['props']['advancedClientIpData']['::fake.com::']);
        });
    }


    /** @test */
    public function the_clients_ip_is_detected_using_the_x_forwarded_for_header_to_bypass_cdn_services(): void
    {
        // Arrange
        $mockRawAction = $this->mock(PrepareRawIpDataAction::class);
        $mockNormalizedAction = $this->mock(PrepareNormalizedIpDataAction::class);

        $mockRawAction->shouldReceive('__invoke')->once()->with(['1.1.1.1']);
        $mockNormalizedAction->shouldReceive('__invoke')->once(['1.1.1.1']);

        $middlewareMock = $this->createPartialMock(TrustProxies::class, []);
        invade($middlewareMock)->proxies = '*';
        $this->swap(TrustProxies::class, $middlewareMock);

        // Act
        $response = $this->get(route('home.index'), [
            'X-Forwarded-For' => '1.1.1.1',
        ]);
    }


    /** @test */
    public function if_no_trusted_proxies_are_set_the_call_fails(): void
    {
        // Arrange
        $mockRawAction = $this->mock(PrepareRawIpDataAction::class);
        $mockNormalizedAction = $this->mock(PrepareNormalizedIpDataAction::class);

        $mockRawAction->shouldReceive('__invoke')->once()->with(
            Mockery::on(
                function (array $ipAddresses) {
                    self::assertNotSame('1.1.1.1', $ipAddresses[0]);
                    return true;
                }
            )
        );
        $mockNormalizedAction->shouldReceive('__invoke')->once()->with(
            Mockery::on(
                function (array $ipAddresses) {
                    self::assertNotSame('1.1.1.1', $ipAddresses[0]);
                    return true;
                }
            )
        );

        $middlewareMock = $this->createPartialMock(TrustProxies::class, []);
        invade($middlewareMock)->proxies = '';
        $this->swap(TrustProxies::class, $middlewareMock);

        // Act
        $response = $this->get(route('home.index'), [
            'X-Forwarded-For' => '1.1.1.1',
        ]);
    }

}
