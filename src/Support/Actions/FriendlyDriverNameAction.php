<?php

namespace Support\Actions;

use Illuminate\Support\Str;

class FriendlyDriverNameAction
{
    /**
     * @throws \ReflectionException
     */
    public function __invoke(string $driverFqn): string
    {
        return Str::of((new \ReflectionClass($driverFqn))->getShortName())
            ->lower()
            ->replace('driver', '')
            ->replace('dot', '.')
            ->toString();
    }
}
