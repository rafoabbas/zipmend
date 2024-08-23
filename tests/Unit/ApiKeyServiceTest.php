<?php

namespace Tests\Unit;

use App\Services\Account\ApiKeyService;
use Tests\TestCase;

class ApiKeyServiceTest extends TestCase
{
    public function test_decode()
    {
        $service = $this->app->make(ApiKeyService::class);

        $string = base64_encode('secret');

        $decode = $service->decode($string);

        $this->assertEquals('secret', $decode);

        $decode = $service->decode('salam nece');

        $this->assertEquals(null, $decode);
    }

    public function test_invalid_set_api_key()
    {
        $key = 'secret';

        $service = $this->app->make(ApiKeyService::class);

        $service->setApiKey($key);

        $this->assertNotEquals('alma', $service->getApiKey());
    }

    public function test_valid_set_api_key()
    {
        $key = 'secret';

        $service = $this->app->make(ApiKeyService::class);

        $service->setApiKey($key);

        $this->assertEquals('secret', $service->getApiKey());
    }

    public function test_invalid_api_key()
    {
        $service = $this->app->make(ApiKeyService::class);

        $request = $this->app['request'];

        $service
            ->setRequest($request)
            ->setPermission('calculate');

        $this->assertEquals(true, $service->invalidApiKey());

        $this->assertEquals('Invalid API key', $service->getErrorMessage());
    }

    public function test_invalid_api_key_not_found()
    {
        $service = $this->app->make(ApiKeyService::class);

        $request = $this->app['request'];

        $request->headers->set('Authentication', 'Basic ' . base64_encode('secret key'));

        $service
            ->setRequest($request)
            ->setPermission('calculate');

        $this->assertEquals(true, $service->invalidApiKey());

        $this->assertEquals('Api Key not found', $service->getErrorMessage());
    }

    public function test_invalid_api_key_expired()
    {
        $service = $this->app->make(ApiKeyService::class);

        $apiKey = $this->appKey([
            'last_expired_at' => now()->subDays(12),
        ]);

        $request = $this->app['request'];

        $request->headers->set('Authentication', 'Basic ' . base64_encode($apiKey->api_key));

        $service
            ->setRequest($request)
            ->setPermission('calculate');

        $this->assertEquals(true, $service->invalidApiKey());

        $this->assertEquals('API key has expired', $service->getErrorMessage());
    }

    public function test_invalid_api_key_permission_denied()
    {
        $service = $this->app->make(ApiKeyService::class);

        $apiKey = $this->appKey([
            'permissions' => [],
        ]);

        $request = $this->app['request'];

        $request->headers->set('Authentication', 'Basic ' . base64_encode($apiKey->api_key));

        $service
            ->setRequest($request)
            ->setPermission('calculate');

        $this->assertEquals(true, $service->invalidApiKey());

        $this->assertEquals('Permission denied', $service->getErrorMessage());
    }

    public function test_api_key_success()
    {
        $service = $this->app->make(ApiKeyService::class);

        $apiKey = $this->appKey();

        $request = $this->app['request'];

        $request->headers->set('Authentication', 'Basic ' . base64_encode($apiKey->api_key));

        $service
            ->setRequest($request)
            ->setPermission('calculate');

        $this->assertEquals(false, $service->invalidApiKey());

        $this->assertEquals(null, $service->getErrorMessage());
    }
}
