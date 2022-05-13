<?php

namespace Tests\Feature\Web\Authentication\RegisterController;

use App\Providers\RouteServiceProvider;
use Domain\User\Models\User;
use Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreRegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_created(): void
    {
        // Arrange
        $payload = [
            'name' => '::John Doe::',
            'email' => 'john@gmail.com',
            'password' => '::secure-password-$$$$#::',
            'password_confirmation' => '::secure-password-$$$$#::',
        ];

        // Act
        $response = $this->post(route('auth.register.store'), $payload);

        // Assert
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('users', [
            'name' => '::John Doe::',
            'email' => 'john@gmail.com',
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);
        $this->assertAuthenticatedAs(User::where('email', 'john@gmail.com')->sole());
    }

    /** @test */
    public function a_users_password_is_hashed(): void
    {
        // Arrange
        $payload = [
            'name' => '::John Doe::',
            'email' => 'john@gmail.com',
            'password' => '::secure-password-$$$$#::',
            'password_confirmation' => '::secure-password-$$$$#::',
        ];

        // Act
        $response = $this->post(route('auth.register.store'), $payload);

        // Assert
        $password = User::first()->password;
        $this->assertStringNotContainsString('::secure-password-$$$$#::', $password);
        $this->assertTrue(Hash::check('::secure-password-$$$$#::', User::first()->password));
    }

    /** @test */
    public function only_guests_can_register(): void
    {
        $this->assertRouteUsesMiddleware('auth.register.store', [
            'guest'
        ]);
    }

    /** @test */
    public function unique_email_validation(): void
    {
        // Arrange
        User::factory()->create([
            'email' => 'john@gmail.com',
        ]);

        $payload = [
            'name' => '::John Doe::',
            'email' => 'john@gmail.com',
            'password' => '::secure-password-$$$$#::',
            'password_confirmation' => '::secure-password-$$$$#::',
        ];

        // Act
        $response = $this->post(route('auth.register.store'), $payload);

        // Assert
        $response->assertSessionHasErrors('email');
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function field_validations(array $payload, string $key): void
    {
        // Arrange

        // Act
        $response = $this->post(route('auth.register.store'), $payload);

        // Assert
        $response->assertSessionHasErrors($key);
    }

    public function validationProvider(): Generator
    {
        $defaultPayload = [
            'name' => '::John Doe::',
            'email' => 'john@gmail.com',
            'password' => '::secure-password-$$$$#::',
            'password_confirmation' => '::secure-password-$$$$#::',
        ];

        yield from [
            'missing_name' => [
                'payload' => Arr::except($defaultPayload, 'name'),
                'keys' => 'name',
            ],
            'missing_email' => [
                'payload' => Arr::except($defaultPayload, 'email'),
                'keys' => 'email',
            ],
            'missing_password' => [
                'payload' => Arr::except($defaultPayload, 'password'),
                'keys' => 'password',
            ],
            'invalid_password_confirmation' => [
                'payload' => array_merge($defaultPayload, [
                    'password_confirmation' => '::invalid-confirmation::',
                ]),
                'keys' => 'password',
            ],
            'nonexistent_email_domain' => [
                'payload' => array_merge($defaultPayload, [
                    'email' => 'wow@totallydoesntexist.org.au',
                ]),
                'keys' => 'email',
            ]
        ];
    }
}
