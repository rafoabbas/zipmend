<?php

namespace App\Services;

use App\Rules\CityRule;
use App\Rules\CountryRule;
use App\Rules\ZipRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class CalculateService
{
    public array $cities;

    public static function rules(): array
    {
        return [
            'addresses'           => ['required', 'array', 'min:2'],
            'addresses.*.country' => ['required', 'string', 'min:2', 'max:2', new CountryRule],
            'addresses.*.zip'     => ['required', 'string', new ZipRule],
            'addresses.*.city'    => ['required', 'string', new CityRule],
        ];
    }

    public function getTotalDistance(): float|int
    {
        $apiKey = config('services.google.maps.key');

        $cities = $this->getCities();

        $totalDistance = 0;

        for ($i = 0; $i < count($cities) - 1; $i++) {
            $origin = $cities[$i];
            $destination = $cities[$i + 1];

            $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                'origins' => $origin,
                'destinations' => $destination,
                'key' => $apiKey,
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['rows'][0]['elements'][0]['distance']['value'])) {
                $distance = $data['rows'][0]['elements'][0]['distance']['value'];
                $totalDistance += $distance; // Mesafeyi metre cinsinden ekler
            } else {
                throw ValidationException::withMessages([
                    'username' => trans('Api error'),
                ]);
            }
        }

        // Convert the total distance to kilometers and return it.
        return floor($totalDistance / 1000);
    }

    //TODO: bu ilk fonksiyadı bundan tam əmin ola bilmədim
    public function getTotalDistanceDeprecate(): float|int
    {
        $apiKey = config('services.google.maps.key');

        // Convert the cities into a comma-separated string.
        $origins = implode('|', $this->getCities());

        $destinations = implode('|', $this->getCities());


        // Send the Google Distance Matrix API request.
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins'      => $origins,
            'destinations' => $destinations,
            'key'          => $apiKey,
        ]);

        // Parse the JSON response.
        $data = $response->json();

        $totalDistance = 0;

        if ($data['status'] == 'OK') {
            foreach ($data['rows'] as $i => $row) {
                foreach ($row['elements'] as $j => $element) {
                    if ($element['status'] == 'OK' && $i !== $j) {
                        // Add the distance in meters
                        $totalDistance += $element['distance']['value'];
                    }
                }
            }
        } else {
            throw ValidationException::withMessages([
                'username' => trans('Api error'),
            ]);
        }

        // Convert the total distance to kilometers and return it.
        return $totalDistance / 1000;
    }

    public function setCities(array $cities): static
    {
        $this->cities = $cities;

        return $this;
    }

    public function getCities(): array
    {
        return $this->cities;
    }
}
