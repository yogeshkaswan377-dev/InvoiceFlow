<?php
// app/Http/Requests/StoreClientRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $rules = [
            'client_type' => ['required', 'in:business,individual'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'address_line_1' => ['nullable', 'string', 'max:500'],
            'address_line_2' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state_code' => ['nullable', 'string', 'size:2', 'exists:states,code'],
            'pincode' => ['nullable', 'string', 'max:10', 'regex:/^[1-9][0-9]{5}$/'],
            'country' => ['required', 'string', 'default:India'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'payment_terms' => ['nullable', 'integer', 'min:0', 'max:365'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
        ];
        
        if ($this->client_type === 'business') {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['gstin'] = ['required', 'string', 'size:15', 'unique:clients,gstin,NULL,id,company_id,' . auth()->user()->company_id];
            $rules['pan'] = ['nullable', 'string', 'size:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'];
        } else {
            $rules['company_name'] = ['nullable', 'string', 'max:255'];
            $rules['gstin'] = ['nullable', 'string', 'size:15'];
            $rules['pan'] = ['nullable', 'string', 'size:10'];
        }
        
        return $rules;
    }
    
    public function messages(): array
    {
        return [
            'gstin.unique' => 'A client with this GSTIN already exists for your company.',
            'phone.regex' => 'Please enter a valid phone number.',
            'pincode.regex' => 'Please enter a valid 6-digit pincode.',
            'pan.regex' => 'Please enter a valid PAN number (e.g., ABCDE1234F).',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('gstin')) {
                $gstValidation = app(\App\Services\GST\GSTValidationService::class);
                
                if (!$gstValidation->validateGSTIN($this->gstin)) {
                    $validator->errors()->add('gstin', 'Invalid GSTIN format. Must be 15 characters with valid structure.');
                }
            }
        });
    }
}