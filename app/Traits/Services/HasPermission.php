<?php

namespace App\Traits\Services;

trait HasPermission
{

    public string $permission;

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function setPermission(string $permission): self
    {
        $this->permission = $permission;
        return $this;
    }
}
