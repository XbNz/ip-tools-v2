<?php

declare(strict_types=1);

namespace Domain\IpAddressInfo\Actions;

use Domain\IpAddressInfo\DataTransferObjects\GuaranteedIpData;
use Ramsey\Collection\Collection;
use Webmozart\Assert\Assert;
use XbNz\Resolver\Domain\Ip\Builders\DriverBuilder;
use XbNz\Resolver\Domain\Ip\Collections\IpCollection;
use XbNz\Resolver\Resolver\Resolver;


class GuaranteedIpDataByIpForDriverAction
{
    public function __construct(private Resolver $resolver)
    {}

    /**
     * @var Collection $collection
     * @var Collection $keyValuePair
     */
    public function __invoke(string $ipAddress, string $driver): GuaranteedIpData
    {
        $driverBuilder = $this->resolver->ip()->withIp($ipAddress);
        Assert::isInstanceOf($driverBuilder, DriverBuilder::class);

        $collection = $driverBuilder->$driver()->normalize();

        $keyValuePair = $collection
            ->slice(1)
            ->mapWithKeys(fn($ipData, $key) => [$key => $ipData[0]['data']]);

        return new GuaranteedIpData(
            $driver,
            $collection['query'],
            $keyValuePair['country'],
            $keyValuePair['city'],
            (float) $keyValuePair['latitude'],
            (float) $keyValuePair['longitude'],
        );
    }
}
