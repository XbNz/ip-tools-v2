<?php

declare(strict_types=1);

namespace App\Api\IpAddressInfo\Controllers;

use App\Api\IpAddressInfo\Requests\IpAddressInfoRequest;
use Domain\IpAddressInfo\Actions\PrepareNormalizedIpDataAction;
use Domain\IpAddressInfo\DataTransferObjects\IpInfoRequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class IpAddressInfoController
{
    public function __invoke(
        IpInfoRequestData $data,
        PrepareNormalizedIpDataAction $normalizeIpDataAction,
    ): JsonResponse {

        dd($normalizeIpDataAction($data->ip_addresses));

        return Response::json(
            $normalizeIpDataAction($data->ip_addresses)
        );
    }
}
