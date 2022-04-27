<?php

namespace Domain\IpAddressInfo\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Support\Actions\FriendlyDriverNameAction;
use Webmozart\Assert\Assert;
use XbNz\Resolver\Domain\Ip\DTOs\MtrDotSh\MtrDotShPingResultsData;
use XbNz\Resolver\Domain\Ip\DTOs\NormalizedGeolocationResultsData;
use XbNz\Resolver\Resolver\Resolver;
use XbNz\Resolver\Support\DTOs\MappableDTO;

class PrepareNormalizedIpDataAction
{
    public function __construct(
        private readonly Resolver $resolver,
        private readonly FriendlyDriverNameAction $friendlyDriverName,
    ){
    }

    /**
     * @return array<string, NormalizedGeolocationResultsData>
     * @param array<string> $ipAddresses
     */
    public function __invoke(array $ipAddresses): array
    {
        Assert::allIp($ipAddresses);

        $result = $this
            ->resolver
            ->ip()
            ->withDrivers(Config::get('services.ip_resolver_drivers_in_use'))
            ->withIps($ipAddresses)
            ->normalize();

        return Collection::make($result)
            ->mapWithKeys(fn (NormalizedGeolocationResultsData $data) => [
                ($this->friendlyDriverName)($data->provider) => $data
            ])
            ->toArray();
    }
}
