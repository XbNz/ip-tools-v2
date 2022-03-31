<?php

declare(strict_types=1);

namespace App\Api\IpAddressInfo\Requests;

use Domain\IpAddressInfo\AllArrayKeysAreValidIpAddressesRule;
use Illuminate\Foundation\Http\FormRequest;

class IpAddressInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ip_addresses' => ['array', 'required', new AllArrayKeysAreValidIpAddressesRule()],
        ];
    }
}
