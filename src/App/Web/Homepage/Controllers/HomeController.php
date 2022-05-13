<?php

declare(strict_types=1);

namespace App\Web\Homepage\Controllers;

use App\Web\Homepage\Requests\IndexHomeRequest;
use Domain\IpAddressInfo\Actions\PrepareNormalizedIpDataAction;
use Domain\IpAddressInfo\Actions\PrepareRawIpDataAction;
use Inertia\Inertia;
use Inertia\Response;

class HomeController
{
    public function __invoke(
        IndexHomeRequest $request,
        PrepareRawIpDataAction $rawAction,
        PrepareNormalizedIpDataAction $normalizeAction,
    ): Response {

        $props = [
            'advancedClientIpData' => $rawAction([$request->getClientIp()]),
            'guaranteedClientIpData' => $normalizeAction([$request->getClientIp()]),
        ];

        return Inertia::render('Home', $props);
    }
}
