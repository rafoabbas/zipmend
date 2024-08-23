<?php

namespace App\Rules;

use App\Traits\Rule\HasCities;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CountryRule implements ValidationRule
{
    use HasCities;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->cities($value)->count()) {
            $fail("The country {$value} does not exist.");
        }
    }
}
