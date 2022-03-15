<?php

namespace Domain\IpAddressInfo\Actions;

use Domain\IpAddressInfo\DataTransferObjects\AdvancedIpData;
use Domain\IpAddressInfo\DataTransferObjects\GuaranteedIpData;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use XbNz\Resolver\Domain\Ip\Actions\VerifyIpIntegrityAction;
use XbNz\Resolver\Domain\Ip\DTOs\IpData;
use XbNz\Resolver\Support\Drivers\Driver;

class AdvancedIpDataAction
{
    public function __construct(
        private array $drivers,
        private VerifyIpIntegrityAction $verifyIpIntegrityAction,
    )
    {}

    /**
     * @var Collection $collection
     * @var Collection $keyValuePair
     * @return Collection<AdvancedIpData>
     */
    public function __invoke(string $ipAddress): Collection
    {
        $ipDataDto = $this->verifyIpIntegrityAction->execute($ipAddress);
        Assert::isInstanceOf($ipDataDto, IpData::class);

        return Collection::make($this->drivers)
            ->map(function (Driver $driver) use ($ipDataDto) {
                $rawApiReturn = $driver->raw($ipDataDto);

                $friendlyDriverName = Str::of((new \ReflectionObject($driver))->getShortName())
                    ->replace('Driver', '')
                    ->replace('Dot', '.')
                    ->lower()
                    ->toString();

                return new AdvancedIpData(
                    $friendlyDriverName,
                    $rawApiReturn,
                );
            });
    }
}
