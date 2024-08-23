<?php

namespace App\Repositories\Contracts\Account;

use App\Models\Account\ApiKey;
use App\Repositories\Contracts\EloquentRepositoryInterface;

interface ApiKeyRepositoryInterface extends EloquentRepositoryInterface
{
    public function getFromApiKey(string $apiKey): ?ApiKey;
}
