<?php

namespace Domain\IpAddressInfo\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;
use XbNz\Resolver\Domain\Ip\Actions\VerifyIpIntegrityAction;
use XbNz\Resolver\Domain\Ip\DTOs\IpData;
use XbNz\Resolver\Domain\Ip\Exceptions\InvalidIpAddressException;

class AllArrayKeysAreValidIpAddressesRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return ! Collection::make($value)
            ->map(function ($ipAddress) {
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
