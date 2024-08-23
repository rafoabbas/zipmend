<?php

namespace App\Traits\Services;

use Illuminate\Http\Request;

trait HasRequest
{
    protected Request $request;

    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
