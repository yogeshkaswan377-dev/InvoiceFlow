<?php

namespace Tests\Unit;

use Tests\TestCase;

class GSTCalculationServiceTest extends TestCase
{
    public function test_service_class_exists(): void
    {
        $this->assertTrue(class_exists(\App\Services\GST\GSTCalculationService::class));
    }
    
    // Full GST tests will be added in Phase 3
}