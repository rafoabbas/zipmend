<?php

namespace App\Rules;

use App\Traits\Rule\HasCities;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CityRule implements ValidationRule
{
    use HasCities;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $countryCode = request(str_replace('city', 'country', $attribute));

        $zipCode = request(str_replace('city', 'zip', $attribute));

        $cities = $this->cities($countryCode);

        if (! $cities->where('zipCode', $zipCode)->where('name', $value)->first()) {
            $fail("The city {$value} does not exist.");
        }
    }
}
