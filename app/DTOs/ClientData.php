<?php
// app/DTOs/ClientData.php

namespace App\DTOs;

readonly class ClientData
{
    public function __construct(
        public int $company_id,
        public string $client_type,
        public string $name,
        public ?string $company_name,
        public ?string $email,
        public ?string $phone,
        public ?string $gstin,
        public ?string $pan,
        public ?string $state_code,
        public ?string $state_name,
        public ?string $address_line_1,
        public ?string $address_line_2,
        public ?string $city,
        public ?string $pincode,
        public string $country,
        public ?string $place_of_supply,
        public float $credit_limit,
        public ?int $payment_terms,
        public ?string $notes,
        public bool $is_active,
    ) {}

    public static function fromRequest(array $data, int $companyId): self
    {
        return new self(
            company_id: $companyId,
            client_type: $data['client_type'],
            name: $data['name'],
            company_name: $data['company_name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            gstin: $data['gstin'] ?? null,
            pan: $data['pan'] ?? null,
            state_code: $data['state_code'] ?? null,
            state_name: $data['state_name'] ?? null,
            address_line_1: $data['address_line_1'] ?? null,
            address_line_2: $data['address_line_2'] ?? null,
            city: $data['city'] ?? null,
            pincode: $data['pincode'] ?? null,
            country: $data['country'] ?? 'India',
            place_of_supply: $data['place_of_supply'] ?? null,
            credit_limit: $data['credit_limit'] ?? 0,
            payment_terms: $data['payment_terms'] ?? null,
            notes: $data['notes'] ?? null,
            is_active: $data['is_active'] ?? true,
        );
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), fn($value) => $value !== null);
    }
}