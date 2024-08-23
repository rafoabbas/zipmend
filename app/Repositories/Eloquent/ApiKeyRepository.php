<?php

namespace App\Repositories\Eloquent;

use App\Models\Account\ApiKey;
use App\Repositories\Contracts\Account\ApiKeyRepositoryInterface;

class ApiKeyRepository extends EloquentRepository implements ApiKeyRepositoryInterface
{
    public function __construct(ApiKey $model)
    {
        parent::__construct($model);
    }

    public function getFromApiKey(string $apiKey): ?ApiKey
{
        return $this->createQuery()
            ->where('api_key', '=', $apiKey)
            ->first();
    }
}
