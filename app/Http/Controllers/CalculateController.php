<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Resources\CalculateResource;
use App\Models\Mongo\VehicleType;
use App\Services\CalculateService;

class CalculateController extends Controller
{
    public function __construct(
        public CalculateService $calculateService
    ) {}

    public function __invoke(CityRequest $request)
    {

        $cities = collect($request->validated('addresses'))
            ->pluck('city')
            ->unique()
            ->toArray();

        $distance = $this->calculateService
            ->setCities($cities)
            ->getTotalDistance();

        $vehicleTypes = VehicleType::query()
            ->get()
            ->map(function (VehicleType $vehicleType) use ($distance) {
                $price = (float) number_format($distance * $vehicleType->getAttribute('cost_km'), 2);

                $vehicleType->setAttribute('price', $price);

                return $vehicleType;
            })
            ->filter(function (VehicleType $vehicleType) {
                return $vehicleType->getAttribute('price') > $vehicleType->getAttribute('minimum');
            });

        return CalculateResource::collection($vehicleTypes)->jsonSerialize();
    }
}
