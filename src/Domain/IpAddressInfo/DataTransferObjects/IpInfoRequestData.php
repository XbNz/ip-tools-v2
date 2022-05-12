<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\DataTransferObjects;

use Domain\IpAddressInfo\Rules\AllArrayKeysAreValidIpAddressesRule;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\IP;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class IpInfoRequestData extends Data
{
    /**
     * @param array<string> $ip_addresses
     */
    public function __construct(
        #[Rule(['array', new AllArrayKeysAreValidIpAddressesRule])]
        public readonly array $ip_addresses,
    ) {
    }
}
