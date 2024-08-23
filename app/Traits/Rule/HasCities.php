<?php

namespace App\Traits\Rule;

use App\Models\Mongo\City;
use Illuminate\Support\Facades\Cache;

trait HasCities
{
    public function cities(string $country)
    {
        return Cache::remember("counties.{$country}", 60, function () use ($country) {
            return City::query()->where('country', $country)->get();
        });
    }
}
