<?php

declare(strict_types=1);

namespace App\Web\Homepage\Controllers;

use Domain\IpAddressInfo\Actions\GuaranteedIpDataByIpForDriverAction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use XbNz\Resolver\Resolver\Resolver;

class HomeController
{
    public function __invoke(
        Request $request,
        GuaranteedIpDataByIpForDriverAction $dataByIpForDriverAction
    ): Response {

        $props = [
            'guaranteedClientIpData' => Collection::make(\Config::get('services.ip_resolver_drivers_in_use'))
                ->map(fn(string $driver) => $dataByIpForDriverAction('1.1.1.1', $driver))
                ->toArray()
        ];

        return Inertia::render('Home', $props);
    }
}
