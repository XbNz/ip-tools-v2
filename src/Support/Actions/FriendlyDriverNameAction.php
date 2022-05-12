<?php

declare(strict_types=1);

namespace Support\Actions;

use Illuminate\Support\Str;
use ReflectionClass;
use XbNz\Resolver\Support\Drivers\Driver;

class FriendlyDriverNameAction
{
    /**
     * @param class-string<Driver> $driverFqn
     */
    public function __invoke(string $driverFqn): string
    {
        return Str::of((new ReflectionClass($driverFqn))->getShortName())
            ->lower()
            ->replace('driver', '')
            ->replace('dot', '.')
            ->toString();
    }
}
