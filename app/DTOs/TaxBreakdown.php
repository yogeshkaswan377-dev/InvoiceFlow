<?php

namespace App\DTOs;

class TaxBreakdown
{
    public function __construct(
        public readonly string $taxType,        // 'cgst_sgst' or 'igst'
        public readonly float $taxableValue,
        public readonly float $cgstAmount,
        public readonly float $sgstAmount,
        public readonly float $igstAmount,
        public readonly float $totalGstAmount,
        public readonly float $cgstRate,
        public readonly float $sgstRate,
        public readonly float $igstRate,
        public readonly float $basePrice,
        public readonly float $finalPrice,
        public readonly string $mode,            // 'exclusive' or 'inclusive'
        public readonly array $itemBreakdown = [] // Per-item breakdown
    ) {}

    public function toArray(): array
    {
        return [
            'tax_type' => $this->taxType,
            'taxable_value' => $this->taxableValue,
            'cgst_amount' => $this->cgstAmount,
            'sgst_amount' => $this->sgstAmount,
            'igst_amount' => $this->igstAmount,
            'total_gst_amount' => $this->totalGstAmount,
            'cgst_rate' => $this->cgstRate,
            'sgst_rate' => $this->sgstRate,
            'igst_rate' => $this->igstRate,
            'base_price' => $this->basePrice,
            'final_price' => $this->finalPrice,
            'mode' => $this->mode,
            'item_breakdown' => $this->itemBreakdown,
        ];
    }
}
