<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddressInfo\Mocks;

use XbNz\Resolver\Domain\Ip\DTOs\IpData;
use XbNz\Resolver\Domain\Ip\DTOs\QueriedIpData;
use XbNz\Resolver\Support\Drivers\Driver;

class FakeDriver implements Driver
{
    public function query(IpData $ipData): QueriedIpData
    {
        $response = $this->raw($ipData);

        return new QueriedIpData(
            driver: self::class,
            ip: $ipData->ip,
            country: $response['country_name'],
            city: $response['city'],
            longitude: $response['longitude'],
            latitude: $response['latitude']
        );
    }

    public function raw(IpData $ipData): array
    {
        return [
            'country_name' => '::United States::',
            'city' => '::New York::',
            'longitude' => '-74.0059',
            'latitude' => '40.7128',
        ];
    }

    public function supports(): string
    {
        return 'testing';
    }

    public function requiresApiKey(): bool
    {
        
    }

    public function requiresFile(): bool
    {
        
    }
}
