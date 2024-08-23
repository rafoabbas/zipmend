<?php

namespace App\Repositories\Eloquent\Common;

use App\Models\Common\ApiLog;
use App\Repositories\Contracts\Common\ApiLogRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;

class ApiLogRepository extends EloquentRepository implements ApiLogRepositoryInterface
{
    public function __construct(ApiLog $model)
    {
        parent::__construct($model);
    }
}
