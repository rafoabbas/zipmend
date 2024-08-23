<?php

namespace App\Rules;

use App\Traits\Rule\HasCities;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ZipRule implements ValidationRule
{
    use HasCities;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $countryCode = request(str_replace('zip', 'country', $attribute));

        $cities = $this->cities($countryCode);

        if (! $cities->where('zipCode', $value)->first()) {
            $fail("The zip code {$value} does not exist.");
        }
    }
}
