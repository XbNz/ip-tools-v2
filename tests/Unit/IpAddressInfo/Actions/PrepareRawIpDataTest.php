<?php

namespace Tests\Unit\IpAddressInfo\Actions;

use Domain\IpAddressInfo\Actions\PrepareRawIpDataAction;
use Domain\IpAddressInfo\DataTransferObjects\ValidIpInfoRequestData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Tests\Unit\IpAddressInfo\Fakes\FakeDotComDriver;
use XbNz\Resolver\Domain\Ip\Builders\IpBuilder;
use XbNz\Resolver\Resolver\Resolver;
use XbNz\Resolver\Support\Drivers\Driver;
use XbNz\Resolver\Support\DTOs\RawResultsData;

class PrepareRawIpDataTest extends TestCase
{
    /** @test **/
    public function it_takes_ip_addresses_and_returns_raw_information_with_a_friendly_driver_name_as_the_key(): void
    {
        // Arrange
        $mock = $this->mock(IpBuilder::class);
        $mock->shouldReceive('withDrivers')->once();
        $mock->shouldReceive('withIps')->once();
        $mock->shouldReceive('raw')->once()->andReturn([
            new RawResultsData(
                FakeDotComDriver::class,
                ['::doesnt::' => '::matter::']
            )
        ]);


        $action = app(PrepareRawIpDataAction::class);


        // Act
        Config::set(['services.ip_resolver_drivers_in_use' => ['::doesnt-matter::']]);
        $result = $action(['1.1.1.1', '8.8.8.8']);

        // Assert
        $this->assertArrayHasKey('fake.com', $result);
    }
}
