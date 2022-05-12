<?php

declare(strict_types=1);

namespace Tests\Unit\IpAddressInfo\Actions;

use Domain\IpAddressInfo\Actions\PrepareNormalizedIpDataAction;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Tests\Unit\IpAddressInfo\Fakes\FakeDotComDriver;
use XbNz\Resolver\Domain\Ip\Builders\IpBuilder;
use XbNz\Resolver\Domain\Ip\DTOs\NormalizedGeolocationResultsData;

class PrepareNormalizedIpDataTest extends TestCase
{
    public function testItTakesIpAddressesAndReturnsNormalizedInformationWithAFriendlyDriverNameAsTheKey(): void
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
        ]);

        $action = app(PrepareNormalizedIpDataAction::class);

        // Act
        Config::set([
            'services.ip_resolver_drivers_in_use' => ['::doesnt-matter::'],
        ]);
        $result = $action(['1.1.1.1', '8.8.8.8']);

        // Assert
        $this->assertArrayHasKey('fake.com', $result);
    }
}
