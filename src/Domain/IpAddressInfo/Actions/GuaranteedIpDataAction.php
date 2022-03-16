<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\Actions;

use Domain\IpAddressInfo\DataTransferObjects\GuaranteedIpData;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Support\Actions\FriendlyDriverNameAction;
use Webmozart\Assert\Assert;
use XbNz\Resolver\Domain\Ip\Actions\VerifyIpIntegrityAction;
use XbNz\Resolver\Domain\Ip\Builders\DriverBuilder;
use XbNz\Resolver\Domain\Ip\Collections\IpCollection;
use XbNz\Resolver\Domain\Ip\DTOs\IpData;
use XbNz\Resolver\Resolver\Resolver;
use XbNz\Resolver\Support\Drivers\Driver;
use function Pipeline\map;


class GuaranteedIpDataAction
{
    public function __construct(
        private array $drivers,
        private FriendlyDriverNameAction $friendlyDriverNameAction,
        private VerifyIpIntegrityAction $verifyIpIntegrityAction,
    )
    {}

    /**
     * @var Collection $collection
     * @var Collection $keyValuePair
     * @return Collection<GuaranteedIpData>
     */
    public function __invoke(string $ipAddress): Collection
    {
        $ipDataDto = $this->verifyIpIntegrityAction->execute($ipAddress);
        Assert::isInstanceOf($ipDataDto, IpData::class);

        return Collection::make($this->drivers)
            ->map(function (Driver $driver) use ($ipDataDto) {
                $queriedDataDto = $driver->query($ipDataDto);

                $friendlyDriverName = ($this->friendlyDriverNameAction)($driver::class);

                return new GuaranteedIpData(
                    $friendlyDriverName,
                    $queriedDataDto->ip,
                    $queriedDataDto->country,
                    $queriedDataDto->city,
                    (float) $queriedDataDto->latitude,
                    (float) $queriedDataDto->longitude,
                );
            });
    }
}
