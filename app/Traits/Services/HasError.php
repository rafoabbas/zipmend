<?php

namespace App\Traits\Services;

trait HasError
{
    protected string $errorMessage;

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }
}
