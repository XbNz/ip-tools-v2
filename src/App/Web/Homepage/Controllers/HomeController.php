<?php

declare(strict_types=1);

namespace App\Web\Homepage\Controllers;

use App\Web\Homepage\Requests\IndexHomeRequest;
use Domain\IpAddressInfo\Actions\PrepareNormalizedIpDataAction;
use Domain\IpAddressInfo\Actions\PrepareRawIpDataAction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use Inertia\Response;
use Torchlight\Blade\CodeComponent;
use Torchlight\Block;
use Torchlight\Client;
use Torchlight\Torchlight;
use XbNz\Resolver\Resolver\Resolver;

class HomeController
{
    public function __invoke(
        IndexHomeRequest $request,
        PrepareRawIpDataAction $rawAction,
        PrepareNormalizedIpDataAction $normalizeAction,
    ): Response {
        $props = [
            'guaranteedClientIpData' => $normalizeAction(['1.1.1.1']),
            'advancedClientIpData' => $rawAction(['1.1.1.1']),
        ];

        return Inertia::render('Home', $props);
    }
}
