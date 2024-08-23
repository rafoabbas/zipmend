<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalculateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'vehicle_type' => $this->number,
            'price'        => $this->price,
        ];
    }
}
