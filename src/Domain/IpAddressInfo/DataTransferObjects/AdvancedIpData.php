<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\DataTransferObjects;

use Domain\IpAddressInfo\Exceptions\RawIpUnobtainableException;
use JsonException;
use Webmozart\Assert\Assert;

class AdvancedIpData
{
    public function __construct(
        public readonly string $driver,
        public readonly array $data,
    ) {}
}
