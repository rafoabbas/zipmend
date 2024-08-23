<?php

namespace App\Services\Account;

use App\Repositories\Contracts\Account\ApiKeyRepositoryInterface;
use App\Traits\Services\HasApiLog;
use App\Traits\Services\HasBase64Decoder;
use App\Traits\Services\HasError;
use App\Traits\Services\HasPermission;
use App\Traits\Services\HasRequest;
use Illuminate\Support\Str;

class ApiKeyService
{
    use HasApiLog;
    use HasBase64Decoder;
    use HasError;
    use HasPermission;
    use HasRequest;

    public ?string $apiKey = null;

    public ?string $rawApiKey = null;

    public function __construct(
        public ApiKeyRepositoryInterface $repository
    ) {}

    public function invalidApiKey(): bool
    {
        $this->rawApiKey = $this->getApiKeyFromRequest();

        if (! $this->isValidApiKey($this->rawApiKey)) {
            $this->setErrorMessage('Invalid API key');

            return true;
        }

        $apiKey = $this->repository->getFromApiKey($this->getApiKey());

        if (! $apiKey) {
            $this->setErrorMessage('Api Key not found');

            return true;
        }

        if ($apiKey->checkLastExpired()) {
            $this->setErrorMessage('API key has expired');

            return true;
        }

        if ($apiKey->checkPermission($this->getPermission())) {
            $this->setErrorMessage('Permission denied');

            return true;
        }

        return false;
    }

    private function isValidApiKey(?string $apiKey): bool
    {
        return $apiKey !== null && $this->decode($apiKey) !== null;
    }

    protected function getApiKeyFromRequest(): ?string
    {
        if ($this->request->header('Authentication')) {
            return $this->trimBasicAuth($this->request->header('Authentication'));
        }

        return $this->request->get('api_key');
    }

    protected function trimBasicAuth($string): string
    {
        return Str::replaceFirst('Basic ', '', $string);
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }
}
