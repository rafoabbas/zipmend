<?php

namespace App\Jobs\Common;

use App\Repositories\Contracts\Common\ApiLogRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ApiLogQueue implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $connectionIp,
        public array $headers = [],
        public array $request = [],
        public ?string $response = null,
        public ?string $apiKey = null,
    ) {}

    public function handle(): void
    {
        app(ApiLogRepositoryInterface::class)->createQuery()->create([
            'connection_ip' => $this->connectionIp,
            'headers'       => $this->headers,
            'request'       => $this->request,
            'response'      => $this->response,
            'api_key'       => $this->apiKey,
        ]);
    }
}
