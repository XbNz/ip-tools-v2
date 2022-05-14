<?php

use XbNz\Resolver\Domain\Ip\Drivers\AbstractApiDotComDriver;
use XbNz\Resolver\Domain\Ip\Drivers\AbuseIpDbDotComDriver;
use XbNz\Resolver\Domain\Ip\Drivers\IpApiDotComDriver;
use XbNz\Resolver\Domain\Ip\Drivers\IpDataDotCoDriver;
use XbNz\Resolver\Domain\Ip\Drivers\IpGeolocationDotIoDriver;
use XbNz\Resolver\Domain\Ip\Drivers\IpInfoDotIoDriver;

return [

    'api-keys' => [
        IpGeolocationDotIoDriver::class => [
            env('IP_GEOLOCATION_DOT_IO_KEY_1')
        ],

        IpInfoDotIoDriver::class => [
            env('IP_INFO_DOT_IO_KEY_1')
        ],

        AbuseIpDbDotComDriver::class => [
            env('ABUSE_IP_DB_DOT_COM_KEY_1')
        ],

        AbstractApiDotComDriver::class => [
            env('ABSTRACT_API_DOT_COM_IP_API_KEY_1')
        ],

        IpDataDotCoDriver::class => [
            env('IP_DATA_DOT_CO_KEY_1')
        ],

        IpApiDotComDriver::class => [
            env('IP_API_DOT_COM_KEY_1')
        ],
    ],

    /**
     * Visit https://mtr.sh/probes.json to retrieve the list of probe IDs
     */
    \XbNz\Resolver\Domain\Ip\Drivers\MtrDotShMtrDriver::class => [
        'search' => ['germany']
    ],

    \XbNz\Resolver\Domain\Ip\Drivers\MtrDotShPingDriver::class => [
        'search' => ['germany']
    ],
];
