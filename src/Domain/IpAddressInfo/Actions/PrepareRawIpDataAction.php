<?php

namespace Domain\IpAddressInfo\Actions;

use Domain\IpAddressInfo\DataTransferObjects\ValidIpInfoRequestData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Support\Actions\FriendlyDriverNameAction;
use Webmozart\Assert\Assert;
use XbNz\Resolver\Resolver\Resolver;
use XbNz\Resolver\Support\Drivers\Driver;
use XbNz\Resolver\Support\DTOs\RawResultsData;

class PrepareRawIpDataAction
{
    public function __construct(
        private readonly Resolver $resolver,
        private readonly FriendlyDriverNameAction $friendlyDriverName,
    ){
    }

    /**
     * @return array<string, RawResultsData>
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
            ->raw();

        return Collection::make($result)
            ->mapWithKeys(fn (RawResultsData $data) => [($this->friendlyDriverName)($data->provider) => $data])
            ->toArray();
    }
}
