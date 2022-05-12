<?php

declare(strict_types=1);

namespace Domain\User\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

class LoginUserData extends Data
{
    public function __construct(
        #[Email]
        public readonly string $email,
        public readonly string $password
    ) {
    }

}
