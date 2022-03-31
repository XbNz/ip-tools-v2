<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddressInfo\AdvancedIpAddressInfoController;

use Domain\IpAddressInfo\Actions\AdvancedIpDataAction;
use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Tests\Feature\Api\IpAddressInfo\Mocks\FakeDriver;
use Tests\TestCase;
use function route;

class InvokeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->app->when([GuaranteedIpDataAction::class, AdvancedIpDataAction::class])
            ->needs('$drivers')
            ->give(function ($app) {
                return [new FakeDriver()];
            });
    }

    /** @test **/
    public function given_a_valid_ipv4_or_ipv6_address_it_returns_gibberish_data_from_fake_driver(): void
    {
        // Act
        $response = $this->json('post', route('ip.advanced.show'), [
            'ip_addresses' => ['1.1.1.1', '2606:4700:4700::1111']
        ]);

        // Assert
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    '*' => [
                        'driver',
                        'data'
                    ]
                ]
            ]
        ]);
    }



    /**
     * @test
     * @dataProvider validationProvider
     */
    public function validation_tests(array $payload, string $key): void
    {
        // Act
        $response = $this->json('post', route('ip.advanced.show'), $payload);

        // Assert
        $response->assertJsonValidationErrors(['ip_addresses']);
    }

    public function validationProvider(): \Generator
    {
        $defaultPayload = [
            'ip_addresses' => [
                '1.1.1.1', '9.9.9.9', '2606:4700:4700::1111'
            ]
        ];

        yield from [
            'addresses provided not public v4' => [
                'payload' => array_merge($defaultPayload, ['ip_addresses' => ['127.0.0.1']]),
                'key' => 'ip_addresses'
            ],

            'addresses provided not public v6' => [
                'payload' => array_merge($defaultPayload, ['ip_addresses' => ['fd00::/8']]),
                'key' => 'ip_addresses'
            ],
        ];
    }
}
