<?php

declare(strict_types=1);

namespace Domain\User\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }
}
