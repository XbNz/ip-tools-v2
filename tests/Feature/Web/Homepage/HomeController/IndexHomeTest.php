<?php

declare(strict_types=1);

namespace Tests\Feature\Web\Homepage\HomeController;


use App\Web\Homepage\Requests\IndexHomeRequest;
use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Domain\IpAddressInfo\DataTransferObjects\GuaranteedIpData;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;
use Support\Actions\FriendlyDriverNameAction;
use Support\Middleware\TrustProxies;
use Tests\TestCase;

class IndexHomeTest extends TestCase
{
    /** @test **/
    public function ip_data_objects_are_made_available_to_the_vue_component_with_friendly_driver_names(): void
    {
        // Arrange
        $middlewareMock = $this->createPartialMock(TrustProxies::class, []);
        invade($middlewareMock)->proxies = '*';
        $this->swap(TrustProxies::class, $middlewareMock);
        $friendlify = app(FriendlyDriverNameAction::class);

        // Act
        $response = $this->get(route('home.index'), ['X-Forwarded-For' => '1.1.1.1']);


        // Assert

        $response->assertOk();

        $response->assertInertia(fn(AssertableInertia $inertia) =>
            $inertia->component('Home')
                ->tap(function (AssertableInertia $inertia) use ($friendlify) {
                    $inertiaHas = Collection::make($inertia->toArray()['props']['guaranteedClientIpData'])->pluck('driver');
                    $inertiaShouldHave = Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
                        ->map(fn(string $driver) => $friendlify($driver));

                    $this->assertEquals($inertiaShouldHave, $inertiaHas);
                })
                ->tap(function (AssertableInertia $inertia) use ($friendlify) {
                    $inertiaHas = Collection::make($inertia->toArray()['props']['advancedClientIpData'])->pluck('driver');
                    $inertiaShouldHave = Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
                        ->map(fn(string $driver) => $friendlify($driver));

                    $this->assertEquals($inertiaShouldHave, $inertiaHas);
                })
        );
    }

    /** @test **/
    public function the_clients_ip_is_detected_using_the_x_forwarded_for_header_to_bypass_cdn_services(): void
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
        $response = $this->get(route('home.index'), ['X-Forwarded-For' => '1.1.1.1']);
    }

}
