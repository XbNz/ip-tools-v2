<?php

declare(strict_types=1);

namespace Tests\Feature\Api\IpAddressInfo\IpAddressInfoController;

use Domain\IpAddressInfo\Actions\GuaranteedIpDataAction;
use Tests\Feature\Api\IpAddressInfo\Mocks\FakeDriver;
use Tests\TestCase;

class InvokeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); 
        $this->app->when(GuaranteedIpDataAction::class)
            ->needs('$drivers')
            ->give(function ($app) {
                return [new FakeDriver()];
            });
    }


    public function testGivenAValidIpv4OrIpv6AddressItReturnsGibberishDataFromFakeDriver(): void
    {
        // Act
        $response = $this->json('post', route('ip.show'), [
            'ip_addresses' => ['1.1.1.1', '2606:4700:4700::1111'],
        ]);

        // Assert
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    '*' => [
                        'driver',
                        'ip',
                        'country',
                        'city',
                        'latitude',
                        'longitude',
                    ],
                ],
            ],
        ]);
    }

    /**
     * @dataProvider validationProvider
     */
    public function testValidationTests(array $payload, string $key): void
    {
        // Act
        $response = $this->json('post', route('ip.show'), $payload);

        // Assert
        $response->assertJsonValidationErrors(['ip_addresses']);
    }

    public function validationProvider(): \Generator
    {
        $defaultPayload = [
            'ip_addresses' => [
                '1.1.1.1', '9.9.9.9', '2606:4700:4700::1111',
            ],
        ];

        yield from [
            'addresses provided not public v4' => [
                'payload' => array_merge($defaultPayload, [
                    'ip_addresses' => ['127.0.0.1'],
                ]),
                'key' =>
'ip_addresses',
            ],

            'addresses provided not public v6' => [
                'payload' => array_merge($defaultPayload, [
                    'ip_addresses' => ['fd00::/8'],
                ]),
                'key' =>
'ip_addresses',
                
            ],
        ];
    }
}
