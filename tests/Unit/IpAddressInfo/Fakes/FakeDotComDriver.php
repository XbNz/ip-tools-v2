<?php

declare(strict_types=1);

namespace Tests\Unit\IpAddressInfo\Fakes;

use Illuminate\Support\Collection;
use XbNz\Resolver\Support\Drivers\Driver;

class FakeDotComDriver implements Driver
{
    public function getRequests(array $dataObjects): Collection
    {
    }

    public function supports(string $driver): bool
    {
    }
}
