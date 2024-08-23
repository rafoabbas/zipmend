<?php

namespace App\Rules;

use App\Models\Mongo\City;
use App\Traits\Rule\HasKey;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

//TODO: old rule
class CommonRule implements ValidationRule
{
    use HasKey;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $zip = request($this->replace($attribute, 'country', 'zip'));
        $city = request($this->replace($attribute, 'country', 'city'));

        if (City::query()
            ->where('country', $value)
            ->where('zipCode', $zip)
            ->where('name', $city)
            ->doesntExist()
        ) {
            $fail("The country {$value} does not exist.");
        }
    }
}
