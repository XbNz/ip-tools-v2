<?php

namespace Support\Actions;

use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
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
