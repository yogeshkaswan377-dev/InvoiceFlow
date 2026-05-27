<?php
// database/factories/CompanyFactory.php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'gstin' => $this->faker->regexify('[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}[Z]{1}[0-9A-Z]{1}'),
            'pan' => $this->faker->regexify('[A-Z]{5}[0-9]{4}[A-Z]{1}'),
            'gst_mode_default' => 'exclusive',
            'gst_rates' => json_encode([
                ['rate' => 5, 'cgst' => 2.5, 'sgst' => 2.5, 'igst' => 5, 'active' => true],
                ['rate' => 12, 'cgst' => 6, 'sgst' => 6, 'igst' => 12, 'active' => true],
                ['rate' => 18, 'cgst' => 9, 'sgst' => 9, 'igst' => 18, 'active' => true],
                ['rate' => 28, 'cgst' => 14, 'sgst' => 14, 'igst' => 28, 'active' => true],
            ]),
            'invoice_prefix' => 'INV-',
            'quote_prefix' => 'QUO-',
            'default_payment_terms' => 15,
            'state_code' => '29',
            'state_name' => 'Karnataka',
            'address_line_1' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'pincode' => $this->faker->regexify('[1-9][0-9]{5}'),
            'phone' => $this->faker->phoneNumber(),
            'bank_details' => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}