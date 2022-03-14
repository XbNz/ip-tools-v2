<?php

declare(strict_types=1);

namespace Tests\Unit\IpAddressInfo\Actions;

use App\Web\IpAddressInfo\Factories\GuaranteedIpDataFactory;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Domain\IpAddressInfo\DataTransferObjects\GuaranteedIpData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use XbNz\Resolver\Domain\Ip\Drivers\IpGeolocationDotIoDriver;
use XbNz\Resolver\Domain\Ip\DTOs\QueriedIpData;

class GuaranteedIpDataTest extends TestCase
{
    /**
     * @test
     **/
    public function it_uses_the_driver_classes_defines_through_config_to_fetch_ip_info(): void
    {
        // Arrange
        $expectations = Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
            ->each(function(string $driverFQN) {
                $mock = $this->mock($driverFQN);
                $mock->shouldReceive('query')
                    ->andReturn(new QueriedIpData(
                        driver: '::FakeDriver::class::',
                        ip: '::1.1.1.1::',
                        country: '::TestCountry::',
                        city: '::TestCity::',
                        longitude: '11.11',
                        latitude: '11.11',
                    ));
            });

        $action = app(GuaranteedIpDataAction::class);

        // Act
        $guaranteedDataCollection = $action('1.1.1.1');

        // Assert
        $this->assertContainsOnlyInstancesOf(GuaranteedIpData::class, $guaranteedDataCollection);

        $guaranteedDataCollection
            ->each(function(GuaranteedIpData $guaranteedData) {
                $this->assertEquals('::1.1.1.1::', $guaranteedData->ip);
                $this->assertEquals('::TestCountry::', $guaranteedData->country);
                $this->assertEquals('::TestCity::', $guaranteedData->city);
                $this->assertEquals(11.11, $guaranteedData->latitude);
                $this->assertEquals(11.11, $guaranteedData->longitude);
            });
    }
}
