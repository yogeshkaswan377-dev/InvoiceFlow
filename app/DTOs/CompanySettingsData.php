<?php
// app/DTOs/CompanySettingsData.php

namespace App\DTOs;

readonly class CompanySettingsData
{
    public function __construct(
        public string $name,
        public ?string $gstin,
        public ?string $pan,
        public ?string $cin,
        public string $gst_mode_default,
        public array $gst_rates,
        public string $invoice_prefix,
        public string $quote_prefix,
        public int $default_payment_terms,
        public ?string $state_code,
        public ?string $state_name,
        public ?string $address_line_1,
        public ?string $address_line_2,
        public ?string $city,
        public ?string $pincode,
        public ?string $phone,
        public ?string $website,
        public array $bank_details,
    ) {}

    public static function fromRequest(array $data, array $currentBankDetails = []): self
    {
        return new self(
            name: $data['name'],
            gstin: $data['gstin'] ?? null,
            pan: $data['pan'] ?? null,
            cin: $data['cin'] ?? null,
            gst_mode_default: $data['gst_mode_default'] ?? 'exclusive',
            gst_rates: $data['gst_rates'] ?? config('gst_rates.default_rates'),
            invoice_prefix: $data['invoice_prefix'] ?? 'INV-',
            quote_prefix: $data['quote_prefix'] ?? 'QUO-',
            default_payment_terms: $data['default_payment_terms'] ?? 15,
            state_code: $data['state_code'] ?? null,
            state_name: $data['state_name'] ?? null,
            address_line_1: $data['address_line_1'] ?? null,
            address_line_2: $data['address_line_2'] ?? null,
            city: $data['city'] ?? null,
            pincode: $data['pincode'] ?? null,
            phone: $data['phone'] ?? null,
            website: $data['website'] ?? null,
            bank_details: $data['bank_details'] ?? $currentBankDetails,
        );
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), fn($value) => $value !== null);
    }
}