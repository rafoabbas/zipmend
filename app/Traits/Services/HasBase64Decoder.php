<?php

namespace App\Traits\Services;

trait HasBase64Decoder
{
    public function decode(string $string): ?string
    {
        $decoded = base64_decode($string, true);

        $encoded = base64_encode($decoded);

        if ($decoded === false) {
            return null;
        }

        if ($encoded !== $string) {
            return null;
        }

        $this->setApiKey($decoded);

        return $decoded;
    }
}
