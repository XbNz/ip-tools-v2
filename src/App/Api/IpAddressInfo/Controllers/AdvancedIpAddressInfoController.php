<?php

declare(strict_types=1);

namespace App\Api\IpAddressInfo\Controllers;

use App\Api\IpAddressInfo\Requests\IpAddressInfoRequest;
use Domain\IpAddressInfo\Actions\PrepareRawIpDataAction;
use Domain\IpAddressInfo\DataTransferObjects\IpInfoRequestData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvancedIpAddressInfoController
{
    public function __invoke(
        IpInfoRequestData $data,
        PrepareRawIpDataAction $rawIpData,
    ): JsonResponse {
        return response()->json(
            $rawIpData($data->ip_addresses),
        );
    }
}


