<?php

namespace App\Traits\Rule;

trait HasKey
{
    public function replace($attribute, $search, $replace): array|string
    {
        return str_replace($search, $replace, $attribute);
    }
}
