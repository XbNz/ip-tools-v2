<?php

namespace App\Web\IpAddressInfo\Factories;

use Domain\IpAddressInfo\DataTransferObjects\GuaranteedIpData;
use Illuminate\Http\Request;
use XbNz\Resolver\Support\Drivers\Driver;

class GuaranteedIpDataFactory
{
    public static function generateTestData($overrides = []): GuaranteedIpData
    {
        $data = array_merge([
            'ip' => '1.1.1.1',
            'country' => 'United States',
            'city' => 'Los Angeles',
            'latitude' => 34.0522,
            'longitude' => -118.2437,
        ], $overrides);

        return new GuaranteedIpData(
            '::RandomDriver::class::',
            $data['ip'],
            $data['country'],
            $data['city'],
            $data['latitude'],
            $data['longitude']
        );
    }
}
