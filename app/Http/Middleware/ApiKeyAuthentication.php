<?php

namespace App\Http\Middleware;

use App\Services\Account\ApiKeyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuthentication
{
    public function __construct(public ApiKeyService $service) {}

    public function handle(Request $request, Closure $next, string $permission = 'calculate'): Response
    {

        $response = $next($request);

        $this->service
            ->setRequest($request)
            ->setPermission($permission);

        if ($this->service->invalidApiKey()) {
            $data = [
                'message' => $this->service->getErrorMessage(),
            ];

            $this->service->log($request, $data);

            return response()->json($data, Response::HTTP_UNAUTHORIZED);
        }

        $this->service->log($request, $response->getContent());

        return $response;
    }
}
