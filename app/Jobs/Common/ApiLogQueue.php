<?php

namespace App\Jobs\Common;

use App\Models\Common\ApiLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApiLogQueue implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $connectionIp,
        public array $headers = [],
        public array $request = [],
        public ?string $response = null,
        public ?string $apiKey = null,
    ) {

    }

    public function handle(): void
    {
        ApiLog::query()->create([
            'connection_ip' => $this->connectionIp,
            'headers' => $this->headers,
            'request' => $this->request,
            'response' => $this->response,
            'api_key' => $this->apiKey,
        ]);
    }
}
