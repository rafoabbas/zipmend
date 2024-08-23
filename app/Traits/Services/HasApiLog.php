<?php

namespace App\Traits\Services;

use App\Jobs\Common\ApiLogQueue;
use Illuminate\Http\Request;

trait HasApiLog
{
    public function log(Request $request, null|string|array $response = null): void
    {
        if (is_array($response)) {
            $response = json_encode($response);
        }

        ApiLogQueue::dispatch(
            $request->clientIp(),
            $request->headers->all(),
            $request->all(),
            $response,
            $this->rawApiKey
        );
    }
}
