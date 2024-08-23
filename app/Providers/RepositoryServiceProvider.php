<?php

namespace App\Providers;

use App\Repositories\Contracts\Account\ApiKeyRepositoryInterface;
use App\Repositories\Contracts\Common\ApiLogRepositoryInterface;
use App\Repositories\Contracts\EloquentRepositoryInterface;
use App\Repositories\Eloquent\Account\ApiKeyRepository;
use App\Repositories\Eloquent\Common\ApiLogRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        EloquentRepositoryInterface::class => EloquentRepository::class,
        ApiKeyRepositoryInterface::class   => ApiKeyRepository::class,
        ApiLogRepositoryInterface::class   => ApiLogRepository::class,
    ];
}
