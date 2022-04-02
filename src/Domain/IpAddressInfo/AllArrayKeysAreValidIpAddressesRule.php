<?php

namespace Domain\IpAddressInfo;

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
                try {
                    $integrityAction = app(VerifyIpIntegrityAction::class);
                    return $integrityAction->execute($ipAddress) instanceof IpData;
                } catch (InvalidIpAddressException $e) {
                    return false;
                }
            })->contains(false);
    }

    public function message(): string
    {
        return 'One or more of the IP addresses provided is not a valid public IP address';
    }
}
