<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use Domain\User\DataTransferObjects\RegisterUserData;
use Domain\User\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserFromRegistrationDataAction
{
    public function __invoke(RegisterUserData $data): User
    {
        return User::query()
            ->create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
            ]);
    }
}
