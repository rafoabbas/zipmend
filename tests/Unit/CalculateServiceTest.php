<?php

namespace Tests\Unit;

use App\Services\CalculateService;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
class CalculateServiceTest extends TestCase
{
    public function test_invalid_set_cities(): void
    {
        $service = new CalculateService();

        $service->setCities(['Berlin', 'Düsseldorf', 'Nuremberg']);

        $this->assertNotEquals(['Berlin', 'Düsseldorf'], $service->getCities());
    }

    public function test_valid_set_cities(): void
    {
        $service = new CalculateService();

        $service->setCities(['Berlin', 'Düsseldorf', 'Nuremberg']);

        $this->assertEquals(['Berlin', 'Düsseldorf', 'Nuremberg'], $service->getCities());
    }

    public function test_get_total_distance(): void {

        $service = new CalculateService();

        $service->setCities(['Berlin', 'Düsseldorf', 'Nuremberg']);

        $distance = $service->getTotalDistance();

        $this->assertTrue(is_numeric($distance));

        $this->assertEquals(2872.773, $distance);
    }
}
