<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Support\Actions\FriendlyDriverNameAction;
use Webmozart\Assert\Assert;
use XbNz\Resolver\Domain\Ip\DTOs\NormalizedGeolocationResultsData;
use XbNz\Resolver\Resolver\Resolver;
use XbNz\Resolver\Support\Drivers\Driver;

class PrepareNormalizedIpDataAction
{
    public function __construct(
        private readonly Resolver $resolver,
        private readonly FriendlyDriverNameAction $friendlyDriverName,
    ) {
    }

    /**
     * @return array<string, NormalizedGeolocationResultsData>
     * @param array<string> $ipAddresses
     */
    public function __invoke(array $ipAddresses): array
    {
        Assert::allIp($ipAddresses);

        $drivers = (array) Config::get('services.ip_resolver_drivers_in_use');

        $result = $this
            ->resolver
            ->ip()
            ->withDrivers($drivers)
            ->withIps($ipAddresses)
            ->normalize();

        $normalized =  Collection::make($result)
            ->mapWithKeys(fn (NormalizedGeolocationResultsData $data) => [
                ($this->friendlyDriverName)($data->provider) => $data,
            ])
            ->toArray();

        Assert::allIsInstanceOf($normalized, NormalizedGeolocationResultsData::class);
        return $normalized;
    }
}
