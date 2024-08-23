<?php

namespace Database\Seeders;

use App\Models\Account\ApiKey;
use Illuminate\Database\Seeder;

class ApiKeySeeder extends Seeder
{
    public string $key = 'm5tLMBL5I4Vv4Bl3N7e3o5';
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ApiKey::query()->exists()) {
            return;
        }

        ApiKey::factory()->create([
            'api_key' => $this->key,
        ]);
    }
}
