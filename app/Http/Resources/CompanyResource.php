<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'legal_name' => $this->legal_name,
            'gstin' => $this->gstin,
            'state_code' => $this->state_code,
            'state_name' => $this->state_name,

            'address' => [
                'line_1' => $this->address_line_1,
                'line_2' => $this->address_line_2,
                'city' => $this->city,
                'pincode' => $this->pincode,
                'country' => $this->country,
            ],

            'contact' => [
                'phone' => $this->phone,
                'email' => $this->email,
            ],

            // Media URLs
            'logo_url' => $this->logo_path ? Storage::url($this->logo_path) : null,
            'signature_url' => $this->signature_path ? Storage::url($this->signature_path) : null,

            // Bank details
            'bank_details' => $this->bank_details,

            // Invoice preferences
            'preferences' => [
                'invoice_prefix' => $this->invoice_prefix,
                'quote_prefix' => $this->quote_prefix,
                'default_payment_terms' => $this->default_payment_terms,
                'default_gst_mode' => $this->default_gst_mode,
                'default_gst_rate' => $this->default_gst_rate,
                'terms_conditions' => $this->terms_conditions,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
