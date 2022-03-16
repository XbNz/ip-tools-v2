<?php

declare(strict_types=1);

namespace Tests\Unit\IpAddressInfo\Actions;

use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\DataTransferObjects\AdvancedIpData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class AdvancedIpDataTest extends \Tests\TestCase
{
    /**
     * @test
     */
    public function it_uses_the_driver_classes_defines_through_config_to_fetch_ip_info(): void
    {
        // Arrange
        $expectations = Collection::make(Config::get('services.ip_resolver_drivers_in_use'))
            ->each(function(string $driverFQN) {
                $mock = $this->mock($driverFQN);
                $mock->shouldReceive('raw')
                    ->andReturn([
                        '::these::' => '::can be::',
                        '::entirely::' => '::arbitrary::',
                        '::it::' => '::literally doesnt matter::',
                    ]);
            });

        $action = app(AdvancedIpDataAction::class);

        // Act
        $advancedIpDataCollection = $action('1.1.1.1');


        // Assert
        $this->assertContainsOnlyInstancesOf(AdvancedIpData::class, $advancedIpDataCollection);

        $advancedIpDataCollection
            ->each(function(AdvancedIpData $advancedIpData) {
                $this->assertEquals([
                    '::these::' => '::can be::',
                    '::entirely::' => '::arbitrary::',
                    '::it::' => '::literally doesnt matter::',
                ], $advancedIpData->data);
            });
    }
}
