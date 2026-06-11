<?php

namespace Tests\Unit;

use App\Services\GST\GSTCalculationService;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GSTCalculationServiceTest extends TestCase
{
    private GSTCalculationService $gstService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gstService = new GSTCalculationService();
    }

    #[Test]
    public function it_calculates_exclusive_gst_correctly()
    {
        $result = $this->gstService->calculateExclusiveGST(1000, '27', '27', 18);

        $this->assertEquals(1000, $result->basePrice);
        $this->assertEquals(1180, $result->finalPrice);
        $this->assertEquals(180, $result->totalGstAmount);
        $this->assertEquals('cgst_sgst', $result->taxType);
    }

    #[Test]
    public function it_calculates_inclusive_gst_correctly()
    {
        $result = $this->gstService->calculateInclusiveGST(1180, '27', '27', 18);

        $this->assertEquals(1000, $result->basePrice);
        $this->assertEquals(1180, $result->finalPrice);
        $this->assertEquals(180, $result->totalGstAmount);
        $this->assertEquals('inclusive', $result->mode);
    }

    #[Test]
    public function it_splits_cgst_sgst_for_intra_state()
    {
        $result = $this->gstService->calculateExclusiveGST(1000, '27', '27', 18);

        $this->assertEquals(90, $result->cgstAmount);
        $this->assertEquals(90, $result->sgstAmount);
        $this->assertEquals(0, $result->igstAmount);
        $this->assertEquals(9, $result->cgstRate);
        $this->assertEquals(9, $result->sgstRate);
    }

    #[Test]
    public function it_applies_igst_for_inter_state()
    {
        $result = $this->gstService->calculateExclusiveGST(1000, '27', '29', 18);

        $this->assertEquals(180, $result->igstAmount);
        $this->assertEquals(0, $result->cgstAmount);
        $this->assertEquals(0, $result->sgstAmount);
        $this->assertEquals(18, $result->igstRate);
        $this->assertEquals('igst', $result->taxType);
    }

    #[Test]
    public function it_handles_zero_gst_rate()
    {
        $result = $this->gstService->calculateExclusiveGST(1000, '27', '27', 0);

        $this->assertEquals(0, $result->totalGstAmount);
        $this->assertEquals(1000, $result->basePrice);
        $this->assertEquals(1000, $result->finalPrice);
    }

    #[Test]
    public function it_handles_precision_with_two_decimals()
    {
        $result = $this->gstService->calculateExclusiveGST(999.99, '27', '27', 18);

        // Raw calculation: 999.99 * 0.18 = 179.9982 → rounded to 180.00
        $this->assertEquals(180.00, $result->totalGstAmount);
        $this->assertEquals(1179.99, $result->finalPrice);

        // Verify 2 decimal precision
        $this->assertIsFloat($result->totalGstAmount);
    }

    #[Test]
    public function it_determines_correct_tax_type()
    {
        $this->assertEquals('cgst_sgst', $this->gstService->determineTaxType('27', '27'));
        $this->assertEquals('igst', $this->gstService->determineTaxType('27', '29'));
        $this->assertEquals('igst', $this->gstService->determineTaxType('27', '15'));
    }

    #[Test]
    public function it_splits_gst_equally_for_cgst_sgst()
    {
        $result = $this->gstService->splitGSTIntoCGSTSGST(180);

        $this->assertEquals(90, $result['cgst']);
        $this->assertEquals(90, $result['sgst']);
    }

    #[Test]
    public function it_calculates_item_gst_with_discount()
    {
        $result = $this->gstService->calculateItemGST(
            itemPrice: 100,
            quantity: 10,
            discount: 10, // 10%
            mode: 'exclusive',
            sellerState: '27',
            buyerState: '27',
            gstRate: 18
        );

        // Price: 100 * 10 = 1000, Discount 10% = 900 taxable
        $this->assertEquals(900, $result->taxableValue);
        $this->assertEquals(162, $result->totalGstAmount); // 18% of 900
        $this->assertEquals(1062, $result->finalPrice);
    }

    #[Test]
    public function it_validates_reverse_charge_calculation()
    {
        $result = $this->gstService->calculateReverseChargeGST(1000, '27', '27', 18);

        $this->assertEquals(1000, $result->basePrice);
        $this->assertEquals(180, $result->totalGstAmount);
    }
}
