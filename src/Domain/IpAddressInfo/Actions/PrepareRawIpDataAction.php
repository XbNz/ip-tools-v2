<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Support\Actions\FriendlyDriverNameAction;
use Webmozart\Assert\Assert;
use XbNz\Resolver\Resolver\Resolver;
use XbNz\Resolver\Support\DTOs\RawResultsData;

class PrepareRawIpDataAction
{
    public function __construct(
        private readonly Resolver $resolver,
        private readonly FriendlyDriverNameAction $friendlyDriverName,
    ) {
    }

    /**
     * @return array<string, RawResultsData>
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
            ->raw();

        $raw = Collection::make($result)
            ->mapWithKeys(fn (RawResultsData $data) => [
                ($this->friendlyDriverName)($data->provider) => $data,
            ])
            ->toArray();

        Assert::allIsInstanceOf($raw, RawResultsData::class);
        return $raw;
    }
}
