<?php

namespace App\Console\Command;

use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Domain\IpAddressInfo\DataTransferObjects\GuaranteedIpData;
use Illuminate\Console\Command;
use XbNz\Resolver\Domain\Ip\Builders\DriverBuilder;

class TestCommand extends Command
{
    protected $signature = 'wow';

    protected $description = 'Command description';

    public function handle(DriverBuilder $driverBuilder)
    {
        $driverBuilder->withIp('1.1.1.1')
            ->ipDataDotCo()
            ->ipGeolocationDotIo()
            ->ipInfoDotIo()
            ->ipApiDotCom()
            ->
    {
}
