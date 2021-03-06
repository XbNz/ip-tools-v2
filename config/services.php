<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ip_resolver_drivers_in_use' => [
        \XbNz\Resolver\Domain\Ip\Drivers\IpGeolocationDotIoDriver::class,
        \XbNz\Resolver\Domain\Ip\Drivers\IpInfoDotIoDriver::class,
        \XbNz\Resolver\Domain\Ip\Drivers\IpDataDotCoDriver::class,
        \XbNz\Resolver\Domain\Ip\Drivers\IpDashApiDotComDriver::class,
        \XbNz\Resolver\Domain\Ip\Drivers\IpApiDotCoDriver::class,
        \XbNz\Resolver\Domain\Ip\Drivers\AbstractApiDotComDriver::class,
        \XbNz\Resolver\Domain\Ip\Drivers\AbuseIpDbDotComDriver::class,
        \XbNz\Resolver\Domain\Ip\Drivers\IpApiDotComDriver::class,

    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
