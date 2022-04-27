<?php

declare(strict_types=1);

namespace App\Api\IpAddressInfo\Controllers;

use App\Api\IpAddressInfo\Requests\IpAddressInfoRequest;
use Domain\IpAddressInfo\Actions\PrepareNormalizedIpDataAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class IpAddressInfoController
{
    public function __invoke(
        IpAddressInfoRequest   $request,
        PrepareNormalizedIpDataAction $normalizeIpDataAction,
    ): JsonResponse {
        return response()->json(
            $normalizeIpDataAction($request->get('ip_addresses'))
        );
    }
}
