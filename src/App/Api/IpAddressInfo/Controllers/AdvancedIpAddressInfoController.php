<?php

declare(strict_types=1);

namespace App\Api\IpAddressInfo\Controllers;

use App\Api\IpAddressInfo\Requests\IpAddressInfoRequest;
use Domain\IpAddressInfo\Actions\PrepareRawIpDataAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;


class AdvancedIpAddressInfoController
{
    public function __invoke(
        IpAddressInfoRequest $request,
        PrepareRawIpDataAction $rawIpData,
    ): JsonResponse {
        return response()->json(
            $rawIpData($request->get('ip_addresses'))
        );
    }
}
