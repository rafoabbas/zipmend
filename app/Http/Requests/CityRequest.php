<?php

namespace App\Http\Requests;

use App\Services\CalculateService;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return CalculateService::rules();
    }
}
