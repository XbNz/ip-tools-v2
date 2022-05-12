<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;

class AllArrayKeysAreValidIpAddressesRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return ! Collection::make($value)
            ->map(function (string $ipAddress) {
                return (bool) filter_var(
                    $ipAddress,
                    FILTER_VALIDATE_IP,
                    FILTER_FLAG_NO_PRIV_RANGE |
                    FILTER_FLAG_NO_RES_RANGE
                );
            })->contains(false);
    }

    public function message(): string
    {
        return 'One or more of the IP addresses provided is not a valid public IP address';
    }
}
