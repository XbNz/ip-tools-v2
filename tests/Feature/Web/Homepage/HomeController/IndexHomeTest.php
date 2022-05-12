<?php

declare(strict_types=1);

namespace Tests\Feature\Web\Homepage\HomeController;

use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Inertia\Testing\AssertableInertia;
use Support\Actions\FriendlyDriverNameAction;
use Support\Middleware\TrustProxies;
use Tests\TestCase;

class IndexHomeTest extends TestCase
{
    public function testIpDataObjectsAreMadeAvailableToTheVueComponentWithFriendlyDriverNames(): void
    {
        // Arrange
        $middlewareMock = $this->createPartialMock(TrustProxies::class, []);
        invade($middlewareMock)->proxies = '*';
        $this->swap(TrustProxies::class, $middlewareMock);
        $friendlify = app(FriendlyDriverNameAction::class);

        // Act
        $response = $this->get(route('home.index'), [
            'X-Forwarded-For' => '1.1.1.1',
        ]);

        // Assert

        $response->assertOk();

        $response->assertInertia(
            fn (AssertableInertia $inertia) =>
            $inertia->component('Home')
                ->tap(function (AssertableInertia $inertia) use ($friendlify) {
                    $inertiaHas = Collection::make($inertia->toArray()['props']['guaranteedClientIpData'])->pluck('driver');
                    $inertiaShouldHave = Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
                        ->map(fn (string $driver) => $friendlify($driver));

                    $this->assertEquals($inertiaShouldHave, $inertiaHas);
                })
                ->tap(function (AssertableInertia $inertia) use ($friendlify) {
                    $inertiaHas = Collection::make($inertia->toArray()['props']['advancedClientIpData'])->pluck('driver');
                    $inertiaShouldHave = Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
                        ->map(fn (string $driver) => $friendlify($driver));

                    $this->assertEquals($inertiaShouldHave, $inertiaHas);
                })
        );
    }


    public function testTheClientsIpIsDetectedUsingTheXForwardedForHeaderToBypassCdnServices(): void
    {
        // Arrange
        $middlewareMock = $this->createPartialMock(TrustProxies::class, []);
        invade($middlewareMock)->proxies = '*';
        $this->swap(TrustProxies::class, $middlewareMock);

        $guaranteedIpMock = $this->mock(GuaranteedIpDataAction::class);
        $advancedIpMock = $this->mock(AdvancedIpDataAction::class);

        $guaranteedIpMock->shouldReceive('__invoke')
            ->with('1.1.1.1')
            ->once();
        $advancedIpMock->shouldReceive('__invoke')
            ->with('1.1.1.1')
            ->once();

        // Act
        $response = $this->get(route('home.index'), [
            'X-Forwarded-For' => '1.1.1.1',
        ]);
    }
}
