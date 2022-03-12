<?php

declare(strict_types=1);

namespace Tests\Unit\IpAddressInfo\Actions;

use App\Web\IpAddressInfo\Factories\GuaranteedIpDataFactory;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataByIpForDriverAction;
use Tests\TestCase;
use XbNz\Resolver\Domain\Ip\Drivers\IpGeolocationDotIoDriver;
use XbNz\Resolver\Domain\Ip\DTOs\QueriedIpData;

class GuaranteedIpDataByIpForDriverTest extends TestCase
{
    /**
     * @test
     **/
    public function given_a_valid_driver_it_successfully_calls_the_query_method_of_given_driver(): void
    {
        // Arrange
        $action = app(GuaranteedIpDataByIpForDriverAction::class);

        $ipGeolocationSwap = $this->mock(IpGeolocationDotIoDriver::class);

        $ipGeolocationSwap->shouldReceive('query')
            ->once()
            ->andReturn(new QueriedIpData(
                driver: '::IpGeolocationDotIoDriver::class::',
                ip: '::1.1.1.1::',
                country: '::TestCountry::',
                city: '::TestCity::',
                longitude: '11.11',
                latitude: '11.11',
            ));

        // Act
        $someValidDriver = 'ipGeolocationDotIo';
        $guaranteedData = $action('1.1.1.1', $someValidDriver);

        // Assert
        $this->assertEquals($someValidDriver, $guaranteedData->driver);
        $this->assertEquals('::1.1.1.1::', $guaranteedData->ip);
        $this->assertEquals('::TestCountry::', $guaranteedData->country);
        $this->assertEquals('::TestCity::', $guaranteedData->city);
        $this->assertEquals(11.11, $guaranteedData->latitude);
        $this->assertEquals(11.11, $guaranteedData->longitude);

    }



}
