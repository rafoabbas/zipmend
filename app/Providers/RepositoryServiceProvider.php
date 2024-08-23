<?php

namespace App\Providers;

use App\Repositories\Contracts\Account\ApiKeyRepositoryInterface;
use App\Repositories\Contracts\EloquentRepositoryInterface;
use App\Repositories\Eloquent\ApiKeyRepository;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        EloquentRepositoryInterface::class => EloquentRepository::class,
        ApiKeyRepositoryInterface::class   => ApiKeyRepository::class,
    ];
}
