<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiKeyAuthenticationMiddlewareTest extends TestCase
{
    public function test_api_key_empty_header()
    {
        $response = $this->post('/api/v1/calculate', []);

        $response
            ->assertStatus(401)
            ->assertJsonStructure(['message']);

        $message = $response->json('message');

        $this->assertEquals('Invalid API key', $message);
    }

    public function test_api_key_invalid_base64()
    {
        $response = $this
            ->withHeaders([
                'Authentication' => 'Basic ' . 'api_key=invalid',
            ])
            ->post('/api/v1/calculate', []);

        $response
            ->assertStatus(401)
            ->assertJsonStructure(['message']);

        $message = $response->json('message');

        $this->assertEquals('Invalid API key', $message);
    }

    public function test_api_key_not_found()
    {
        $response = $this
            ->withHeaders([
                'Authentication' => 'Basic ' . base64_encode('api_key=invalid'),
            ])
            ->post('/api/v1/calculate', []);

        $response
            ->assertStatus(401)
            ->assertJsonStructure(['message']);

        $message = $response->json('message');

        $this->assertEquals('Api Key not found', $message);
    }

    public function test_api_key_expired()
    {
        $apiKey = $this->appKey([
            'last_expired_at' => now()->subDays(30),
        ]);

        $response = $this
            ->withHeaders([
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', []);

        $response
            ->assertStatus(401)
            ->assertJsonStructure(['message']);

        $message = $response->json('message');

        $this->assertEquals('API key has expired', $message);
    }

    public function test_api_key_permission_denied()
    {
        $apiKey = $this->appKey([
            'permissions' => []
        ]);

        $response = $this
            ->withHeaders([
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', []);

        $response
            ->assertStatus(401)
            ->assertJsonStructure(['message']);

        $message = $response->json('message');

        $this->assertEquals('Permission denied', $message);
    }

    public function test_api_key_success()
    {
        $apiKey = $this->appKey();

        $response = $this
            ->withHeaders([
                'Accept' => 'application/json',
                'Authentication' => 'Basic ' . base64_encode($apiKey->api_key),
            ])
            ->post('/api/v1/calculate', []);

        $response->assertStatus(422);

        $message = $response->json('message');

        $this->assertEquals('The addresses field is required.', $message);
    }
}
