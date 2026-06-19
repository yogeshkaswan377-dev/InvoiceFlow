<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxBreakdownResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'gst_mode' => $this->gst_mode,
            'place_of_supply' => $this->place_of_supply,
            'reverse_charge' => $this->reverse_charge,

            // Tax amounts
            'taxable_value' => $this->subtotal,
            'igst_amount' => $this->igst_amount,
            'cgst_amount' => $this->cgst_amount,
            'sgst_amount' => $this->sgst_amount,
            'total_gst_amount' => $this->total_gst_amount,

            // Invoice totals
            'subtotal' => $this->subtotal,
            'discount_amount' => $this->discount_amount,
            'shipping_charges' => $this->shipping_charges,
            'commission' => $this->commission,
            'grand_total' => $this->grand_total,
            'balance_due' => $this->balance_due,

            // GST Rates summary
            'tax_rates' => [
                'igst_rate' => $this->when($this->igst_amount > 0, $this->igst_rate ?? 18),
                'cgst_rate' => $this->when($this->cgst_amount > 0, $this->cgst_rate ?? 9),
                'sgst_rate' => $this->when($this->sgst_amount > 0, $this->sgst_rate ?? 9),
            ],
        ];
    }
}
