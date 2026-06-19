<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'invoice_number' => $this->invoice_number,
            'reference_number' => $this->reference_number,
            'invoice_type' => $this->invoice_type,
            'invoice_date' => $this->invoice_date?->format('Y-m-d'),
            'due_date' => $this->due_date?->format('Y-m-d'),

            // Client (conditionally loaded)
            'client' => new ClientResource($this->whenLoaded('client')),
            'client_id' => $this->client_id,

            // Financial totals
            'subtotal' => $this->subtotal,
            'discount_type' => $this->discount_type,
            'discount_amount' => $this->discount_amount,
            'taxable_value' => $this->subtotal,
            'shipping_charges' => $this->shipping_charges,
            'commission' => $this->commission,
            'grand_total' => $this->grand_total,
            'balance_due' => $this->balance_due,
            'total_paid' => $this->total_paid,

            // GST details
            'gst_mode' => $this->gst_mode,
            'gst_rate' => $this->gst_rate,
            'igst_amount' => $this->igst_amount,
            'cgst_amount' => $this->cgst_amount,
            'sgst_amount' => $this->sgst_amount,
            'total_gst_amount' => $this->total_gst_amount,
            'place_of_supply' => $this->place_of_supply,
            'reverse_charge' => $this->reverse_charge,
            'show_hsn_sac' => $this->show_hsn_sac,

            // Tax breakdown (for detailed view)
            'tax_breakdown' => new TaxBreakdownResource($this),

            // Items
            'items' => InvoiceItemResource::collection($this->whenLoaded('items')),
            'items_count' => $this->whenCounted('items'),

            // Payments
            'payments' => $this->whenLoaded('payments'),

            // Status & metadata
            'status' => $this->status,
            'payment_terms' => $this->payment_terms,
            'notes' => $this->notes,
            'terms_and_conditions' => $this->terms_and_conditions,
            'logistics_details' => $this->logistics_details,
            'estimated_delivery_date' => $this->estimated_delivery_date?->format('Y-m-d'),
            'metadata' => $this->metadata,

            // Created/Updated by
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

            // Timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Computed flags
            'is_editable' => $this->when(method_exists($this->resource, 'isEditable'), $this->resource->isEditable()),
            'is_deletable' => $this->when(method_exists($this->resource, 'isDeletable'), $this->resource->isDeletable()),

            // Links (HATEOAS for Next.js)
            'links' => [
                'self' => url("/api/v1/invoices/{$this->id}"),
                'pdf' => url("/api/v1/invoices/{$this->id}/pdf"),
                'preview' => url("/api/v1/invoices/{$this->id}/preview"),
            ],
        ];
    }
}
