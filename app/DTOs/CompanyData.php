<?php

namespace App\DTOs;

use App\Http\Requests\StoreCompanyRequest;

class CompanyData
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $gstin,
        public readonly ?string $pan,
        public readonly ?string $cin,
        public readonly ?string $address_line1,
        public readonly ?string $address_line2,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $state_code,
        public readonly ?string $pincode,
        public readonly ?string $country,
        public readonly ?array $bank_details,
        public readonly ?array $gst_settings,
        public readonly ?array $invoice_preferences,
        public readonly ?bool $is_active = true
    ) {}


    public static function fromRequest(StoreCompanyRequest $request): self
    {
        return self::fromArray($request->validated());
    }
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            gstin: strtoupper($data['gstin'] ?? null),
            pan: strtoupper($data['pan'] ?? null),
            cin: strtoupper($data['cin'] ?? null),
            address_line1: $data['address_line1'] ?? null,
            address_line2: $data['address_line2'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            state_code: $data['state_code'] ?? null,
            pincode: $data['pincode'] ?? null,
            country: $data['country'] ?? 'India',
            bank_details: $data['bank_details'] ?? null,
            gst_settings: $data['gst_settings'] ?? null,
            invoice_preferences: $data['invoice_preferences'] ?? null,
            is_active: $data['is_active'] ?? true
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gstin' => $this->gstin,
            'pan' => $this->pan,
            'cin' => $this->cin,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state' => $this->state,
            'state_code' => $this->state_code,
            'pincode' => $this->pincode,
            'country' => $this->country,
            'bank_details' => $this->bank_details,
            'gst_settings' => $this->gst_settings,
            'invoice_preferences' => $this->invoice_preferences,
            'is_active' => $this->is_active,
        ], fn($value) => $value !== null);
    }
}
