<?php

namespace Domain\User\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Data;

class LoginUserData extends Data
{
    public function __construct(
        #[Email]
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('email'),
            $request->input('password'),
        );
    }
}
