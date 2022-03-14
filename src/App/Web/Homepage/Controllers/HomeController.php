<?php

declare(strict_types=1);

namespace App\Web\Homepage\Controllers;

use App\Web\Homepage\Requests\IndexHomeRequest;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataByIpForDriverAction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use Inertia\Response;
use XbNz\Resolver\Resolver\Resolver;

class HomeController
{
    public function __invoke(
        IndexHomeRequest $request,
        GuaranteedIpDataByIpForDriverAction $dataByIpForDriverAction,
    ): Response {
        $props = [
            'guaranteedClientIpData' => $dataByIpForDriverAction('9.9.9.9'),
        ];

        return Inertia::render('Home', $props);
    }
}
