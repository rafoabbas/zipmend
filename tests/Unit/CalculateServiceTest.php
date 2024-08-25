<?php

namespace Tests\Unit;

use App\Services\CalculateService;
use Tests\TestCase;

class CalculateServiceTest extends TestCase
{
    public function test_invalid_set_cities(): void
    {
        $service = $this->app->make(CalculateService::class);

        $service->setCities(['Berlin', 'Düsseldorf', 'Nuremberg']);

        $this->assertNotEquals(['Berlin', 'Düsseldorf'], $service->getCities());
    }

    public function test_valid_set_cities(): void
    {
        $service = $this->app->make(CalculateService::class);

        $service->setCities(['Berlin', 'Düsseldorf', 'Nuremberg']);

        $this->assertEquals(['Berlin', 'Düsseldorf', 'Nuremberg'], $service->getCities());
    }

    public function test_get_total_distance(): void
    {

        $service = $this->app->make(CalculateService::class);

        $service->setCities(['Berlin', 'Düsseldorf', 'Nuremberg']);

        $distance = $service->getTotalDistance();

        $this->assertTrue(is_numeric($distance));

        $this->assertEquals(1012, $distance);
    }
}
