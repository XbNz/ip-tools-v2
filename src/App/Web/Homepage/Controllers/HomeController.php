<?php

declare(strict_types=1);

namespace App\Web\Homepage\Controllers;

use App\Web\Homepage\Requests\IndexHomeRequest;
use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
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
        GuaranteedIpDataAction $guaranteedIpDataAction,
        AdvancedIpDataAction $advancedIpDataAction,
    ): Response {

        $props = [
            'guaranteedClientIpData' => $guaranteedIpDataAction('46.225.90.60'),
            'advancedClientIpData' => $advancedIpDataAction('46.225.90.60'),
        ];


        return Inertia::render('Home', $props);
    }
}
