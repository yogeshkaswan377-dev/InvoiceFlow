<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'hsn_sac_code' => $this->hsn_sac_code,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'original_unit_price' => $this->original_unit_price,
            'gst_rate' => $this->gst_rate,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'taxable_amount' => $this->taxable_amount,
            'igst_amount' => $this->igst_amount,
            'cgst_amount' => $this->cgst_amount,
            'sgst_amount' => $this->sgst_amount,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
    