<?php

declare(strict_types=1);

namespace Tests\Unit\IpAddressInfo\Actions;

use Domain\IpAddressInfo\Actions\PrepareRawIpDataAction;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Tests\Unit\IpAddressInfo\Fakes\FakeDotComDriver;
use XbNz\Resolver\Domain\Ip\Builders\IpBuilder;
use XbNz\Resolver\Support\DTOs\RawResultsData;

class PrepareRawIpDataTest extends TestCase
{
    public function testItTakesIpAddressesAndReturnsRawInformationWithAFriendlyDriverNameAsTheKey(): void
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

        $action = app(PrepareRawIpDataAction::class);

        // Act
        $result = $action(['1.1.1.1', '8.8.8.8']);

        // Assert
        $this->assertArrayHasKey('fake.com', $result);
        $this->assertCount(2, $result['fake.com']);
        $this->assertContainsOnlyInstancesOf(RawResultsData::class, $result['fake.com']);
    }
}
