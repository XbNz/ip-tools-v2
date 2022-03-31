<?php

declare(strict_types=1);

namespace App\Api\IpAddressInfo\Controllers;

use App\Api\IpAddressInfo\Requests\IpAddressInfoRequest;
use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Illuminate\Http\JsonResponse;


class IpAddressInfoController
{
    public function __invoke(
        IpAddressInfoRequest   $request,
        GuaranteedIpDataAction $guaranteedIpDataAction,
        AdvancedIpDataAction   $advancedIpDataAction,
    ): JsonResponse {
        // TODO: Only allow application to make request to this endpoint
        // TODO: Resource for this json data

//        return response()->json($guaranteedIpDataAction($request->get('ip')));
    }
}
