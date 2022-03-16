<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\DataTransferObjects;

use Illuminate\Testing\Assert;

class GuaranteedIpData
{
    public function __construct(
        public readonly string $driver,
        public readonly string $ip,
        public readonly string $country,
        public readonly string $city,
        public readonly float $latitude,
        public readonly float $longitude,
    )
    {}
}
