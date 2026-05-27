<?php
// tests/Unit/PlaceOfSupplyServiceTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GST\PlaceOfSupplyService;

class PlaceOfSupplyServiceTest extends TestCase
{
    protected PlaceOfSupplyService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PlaceOfSupplyService();
    }

    public function test_intra_state_supply()
    {
        $result = $this->service->determine('29', '29');
        
        $this->assertEquals('intra', $result['type']);
        $this->assertEquals('CGST+SGST', $result['tax_type']);
    }

    public function test_inter_state_supply()
    {
        $result = $this->service->determine('29', '27');
        
        $this->assertEquals('inter', $result['type']);
        $this->assertEquals('IGST', $result['tax_type']);
    }

    public function test_export_supply()
    {
        $result = $this->service->determine('29', null, 'USA');
        
        $this->assertEquals('export', $result['type']);
        $this->assertEquals('IGST', $result['tax_type']);
    }

    public function test_tax_component_calculation_intra()
    {
        $components = $this->service->calculateTaxComponents('intra', 18, 1000);
        
        $this->assertEquals(1000, $components['taxable_value']);
        $this->assertEquals(9, $components['cgst_rate']);
        $this->assertEquals(9, $components['sgst_rate']);
        $this->assertEquals(0, $components['igst_rate']);
        $this->assertEquals(90, $components['cgst_amount']);
        $this->assertEquals(90, $components['sgst_amount']);
        $this->assertEquals(0, $components['igst_amount']);
        $this->assertEquals(180, $components['total_tax']);
    }

    public function test_tax_component_calculation_inter()
    {
        $components = $this->service->calculateTaxComponents('inter', 18, 1000);
        
        $this->assertEquals(1000, $components['taxable_value']);
        $this->assertEquals(0, $components['cgst_rate']);
        $this->assertEquals(0, $components['sgst_rate']);
        $this->assertEquals(18, $components['igst_rate']);
        $this->assertEquals(0, $components['cgst_amount']);
        $this->assertEquals(0, $components['sgst_amount']);
        $this->assertEquals(180, $components['igst_amount']);
        $this->assertEquals(180, $components['total_tax']);
    }
}