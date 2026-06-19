<?php
// app/Http/Requests/UpdateCompanyRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'gstin' => ['nullable', 'string', 'size:15'],
            'pan' => ['nullable', 'string', 'size:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'cin' => ['nullable', 'string', 'max:21'],
            'gst_mode_default' => ['required', 'in:exclusive,inclusive'],
            'gst_rates' => ['nullable', 'array'],
            'gst_rates.*.rate' => ['required', 'numeric', 'in:5,12,18,28'],
            'gst_rates.*.cgst' => ['required', 'numeric'],
            'gst_rates.*.sgst' => ['required', 'numeric'],
            'gst_rates.*.igst' => ['required', 'numeric'],
            'invoice_prefix' => ['required', 'string', 'max:10'],
            'quote_prefix' => ['required', 'string', 'max:10'],
            'default_payment_terms' => ['required', 'integer', 'min:0', 'max:365'],
            'state_code' => ['nullable', 'string', 'size:2', 'exists:states,code'],
            'state_name' => ['nullable', 'string', 'max:100'],
            'address_line_1' => ['nullable', 'string', 'max:500'],
            'address_line_2' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:10', 'regex:/^[1-9][0-9]{5}$/'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'website' => ['nullable', 'url', 'max:255'],
            'bank_details' => ['nullable', 'array'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'signature' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    public function messages(): array
    {
        return [
            'gstin.size' => 'GSTIN must be exactly 15 characters.',
            'pan.regex' => 'Please enter a valid PAN number (e.g., ABCDE1234F).',
            'pincode.regex' => 'Please enter a valid 6-digit pincode.',
            'phone.regex' => 'Please enter a valid phone number.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (empty($this->gst_rates) || !is_array($this->gst_rates)) {
                return;
            }
            // Validate GST rates sum correctly
            foreach ($this->gst_rates as $index => $rate) {
                $expectedCgst = $rate['rate'] / 2;
                $expectedSgst = $rate['rate'] / 2;
                $expectedIgst = $rate['rate'];

                if ($rate['cgst'] != $expectedCgst || $rate['sgst'] != $expectedSgst || $rate['igst'] != $expectedIgst) {
                    $validator->errors()->add("gst_rates.{$index}.rate", "For rate {$rate['rate']}%, CGST and SGST should be " . ($rate['rate'] / 2) . "% each, and IGST should be {$rate['rate']}%.");
                }
            }

            // Validate GSTIN if provided
            if ($this->filled('gstin')) {
                $gstValidation = app(\App\Services\GST\GSTValidationService::class);

                if (!$gstValidation->validateGSTIN($this->gstin)) {
                    $validator->errors()->add('gstin', 'Invalid GSTIN format. Must be 15 characters with valid structure.');
                }
            }
        });
    }
}
