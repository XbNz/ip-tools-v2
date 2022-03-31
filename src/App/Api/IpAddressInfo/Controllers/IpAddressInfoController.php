<?php

declare(strict_types=1);

namespace App\Api\IpAddressInfo\Controllers;

use App\Api\IpAddressInfo\Requests\IpAddressInfoRequest;
use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;


class IpAddressInfoController
{
    public function __invoke(
        IpAddressInfoRequest   $request,
        GuaranteedIpDataAction $guaranteedIpDataAction,
    ): JsonResponse {
        return response()->json(
            [
                'data' => Collection::make(
                    $request->get('ip_addresses'))->map(fn($ip) => $guaranteedIpDataAction($ip)
                )
            ]
        );
    }
}
