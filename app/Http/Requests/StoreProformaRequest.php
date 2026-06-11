<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProformaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'reference_number' => 'nullable|string|max:50',

            // Items validation
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:500',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.gst_rate' => 'required|numeric|in:0,5,12,18,28',
            'items.*.discount_type' => 'nullable|in:percentage,fixed',
            'items.*.discount_value' => 'nullable|numeric|min:0',

            // Invoice-level discount
            'discount_type' => 'nullable|in:percentage,fixed',
            'discount_amount' => 'nullable|numeric|min:0',

            // Additional charges
            'shipping_charges' => 'nullable|numeric|min:0',
            'commission' => 'nullable|numeric|min:0',

            // Other fields
            'payment_terms' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:2000',
            'terms_and_conditions' => 'nullable|string|max:5000',
            'logistics_details' => 'nullable|array',
            'estimated_delivery_date' => 'nullable|date|after_or_equal:invoice_date',

            // Status
            'status' => 'nullable|in:draft,sent',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Please add at least one item to the invoice.',
            'items.min' => 'Please add at least one item to the invoice.',
            'items.*.name.required' => 'Item name is required.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.unit_price.min' => 'Unit price cannot be negative.',
            'items.*.gst_rate.in' => 'Invalid GST rate selected.',
        ];
    }
}
