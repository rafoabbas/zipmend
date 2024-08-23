<?php

namespace Tests\Feature;

use Tests\TestCase;

class CalculateControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_required_addresses_validation(): void
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept'         => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('addresses')
            ->assertJsonStructure([
                'message',
                'errors' => [],
            ]);

        $message = $response->json('message');

        $this->assertEquals('The addresses field is required.', $message);
    }

    public function test_array_addresses_validation(): void
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept'         => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', [
                'addresses' => 'string',
            ]);

        $response->assertStatus(422);

        $message = $response->json('message');

        $this->assertEquals('The addresses field must be an array.', $message);
    }

    public function test_min_addresses_validation(): void
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept'         => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', [
                'addresses' => [
                    [
                        'country' => 'DE',
                        'zip'     => '10115',
                        'city'    => 'Berlin',
                    ],
                ],
            ]);

        $response->assertStatus(422);

        $message = $response->json('message');

        $this->assertEquals('The addresses field must have at least 2 items.', $message);
    }

    public function test_invalid_country(): void
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept'         => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', [
                'addresses' => [
                    [
                        'country' => 'AZ',
                        'zip'     => '1000',
                        'city'    => 'Baku',
                    ],
                    [
                        'country' => 'AZ',
                        'zip'     => '4400',
                        'city'    => 'Masalli',
                    ],
                ],
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [],
            ]);

        $message = $response->json('message');

        $this->assertStringContainsString('The country AZ does not exist', $message);
    }

    public function test_invalid_zip_code(): void
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept'         => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', [
                'addresses' => [
                    [
                        'country' => 'DE',
                        'zip'     => '1000',
                        'city'    => 'Baku',
                    ],
                    [
                        'country' => 'DE',
                        'zip'     => '4400',
                        'city'    => 'Masalli',
                    ],
                ],
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [],
            ]);

        $message = $response->json('message');

        $this->assertStringContainsString('The zip code 1000 does not exist.', $message);
    }

    public function test_invalid_city(): void
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept'         => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', [
                'addresses' => [
                    [
                        'country' => 'DE',
                        'zip'     => '20095',
                        'city'    => 'Baku',
                    ],
                    [
                        'country' => 'DE',
                        'zip'     => '10115',
                        'city'    => 'Masalli',
                    ],
                ],
            ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [],
            ]);

        $message = $response->json('message');

        $this->assertStringContainsString('The city Baku does not exist.', $message);
    }

    public function test_calculate()
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept'         => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', [
                'addresses' => [
                    [
                        'country' => 'DE',
                        'zip'     => '10115',
                        'city'    => 'Berlin',
                    ],
                    [
                        'country' => 'DE',
                        'zip'     => '20095',
                        'city'    => 'Hamburg',
                    ],
                ],
            ]);

        $response->assertStatus(200);
    }
}
