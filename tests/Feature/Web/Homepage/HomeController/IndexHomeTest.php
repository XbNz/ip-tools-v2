<?php

declare(strict_types=1);

namespace Tests\Feature\Web\Homepage\HomeController;


use App\Web\Homepage\Requests\IndexHomeRequest;
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
    public function the_clients_ip_is_detected_using_the_x_forwarded_for_header_to_bypass_cdn_services(): void
    {
        // Arrange
        $middlewareMock = $this->createPartialMock(TrustProxies::class, []);
        invade($middlewareMock)->proxies = '*';
        $this->swap(TrustProxies::class, $middlewareMock);

        // Act
        $response = $this->get(route('home.index'), ['X-Forwarded-For' => '1.1.1.1']);

        // Assert
        $friendlify = app(FriendlyDriverNameAction::class);

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
}
