<?php

namespace Tests\Feature\Web\Authentication\LoginController;

use App\Providers\RouteServiceProvider;
use Domain\User\Models\User;
use Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StoreLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_can_log_in(): void
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'john@gmail.com',
            'password' => Hash::make('::secret-password-123#::'),
        ]);

        $payload = [
            'email' => $user->email,
            'password' => '::secret-password-123#::'
        ];

        // Act
        $response = $this->post(route('auth.login.store'), $payload);

        // Assert
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }


    /** @test */
    public function only_guests_can_login(): void
    {
        $this->assertRouteUsesMiddleware('auth.login.store', [
            'guest'
        ]);
    }

    /**
     * @test
     * @dataProvider validationProvider
     **/
    public function validation_tests(array $payload, string $key): void
    {
        // Arrange

        // Act
        $response = $this->post(route('auth.login.store'), $payload);

        // Assert
        $response->assertSessionHasErrors($key);
    }

    public function validationProvider(): Generator
    {
        $defaultPayload = [
            'email' => 'john@gmail.com',
            'password' => '::secure-password-$$$$#::',
        ];

        yield from [
            'missing_email' => [
                'payload' => Arr::except($defaultPayload, 'email'),
                'keys' => 'email',
            ],
            'missing_password' => [
                'payload' => Arr::except($defaultPayload, 'password'),
                'keys' => 'password',
            ],
            'incorrect_email' => [
                'payload' => array_merge($defaultPayload, [
                    'email' => '::gibberish-email::',
                ]),
                'keys' => 'email',
            ],
            'incorrect_password' => [
                'payload' => array_merge($defaultPayload, [
                    'password' => '::invalid::',
                ]),
                'keys' => 'email',
            ],
        ];
    }
}
