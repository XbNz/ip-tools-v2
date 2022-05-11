<?php

namespace Domain\User\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;

class RegisterUserData extends Data
{
    public function __construct(
        public readonly string $name,
        #[Email([Email::RfcValidation, Email::DnsCheckValidation])]
        public readonly string $email,
        #[Password(min: 2, uncompromised: true), Confirmed]
        public readonly string $password,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
        );
    }
}
