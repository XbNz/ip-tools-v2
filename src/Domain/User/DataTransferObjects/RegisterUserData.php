<?php

declare(strict_types=1);

namespace Domain\User\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class RegisterUserData extends Data
{
    public function __construct(
        public readonly string $name,
        #[Email([Email::RfcValidation, Email::DnsCheckValidation]), Unique('users', 'email')]
        public readonly string $email,
        #[Password(min: 10, uncompromised: true),
        Confirmed]
        public readonly string $password,
    ) {
    }

}
