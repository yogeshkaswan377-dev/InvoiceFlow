<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'client_type' => $this->client_type,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gstin' => $this->gstin,
            'pan' => $this->pan,
            'state_code' => $this->state_code,
            'state_name' => $this->state_name,
            'state' => $this->state,
            'address' => [
                'line_1' => $this->address_line_1,
                'line_2' => $this->address_line_2,
                'city' => $this->city,
                'pincode' => $this->pincode,
                'country' => $this->country,
            ],
            'place_of_supply' => $this->place_of_supply,
            'credit_limit' => $this->credit_limit,
            'payment_terms' => $this->payment_terms,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Conditional relationships
            'invoices_count' => $this->whenCounted('invoices'),
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
        ];
    }
}
