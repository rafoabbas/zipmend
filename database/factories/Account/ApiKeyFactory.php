<?php

namespace Database\Factories\Account;

use App\Enums\Status;
use App\Models\Account\ApiKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    public function definition(): array
    {
        return [
            'api_key'         => Str::random(22),
            'status'          => Status::active,
            'permissions'     => ['calculate'],
            'last_used_at'    => now(),
            'last_expired_at' => now()->addDays(30),
        ];
    }
}
