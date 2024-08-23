<?php

namespace Tests;

use App\Models\Account\ApiKey;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //TODO: Since I have a connection to MongoDB, I didn’t use this.
//    use LazilyRefreshDatabase;

    public function appKey(array $overrides = []): ApiKey
    {
        return ApiKey::factory()->create($overrides);
    }
}
