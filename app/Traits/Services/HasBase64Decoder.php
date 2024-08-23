<?php

namespace App\Traits\Services;

trait HasBase64Decoder
{
    public function decode(string $string): ?string
    {
        $decoded = base64_decode($string, true);

        if (false === $decoded) {
            return null;
        }

        $this->setApiKey($decoded);

        return $decoded;
    }
}
