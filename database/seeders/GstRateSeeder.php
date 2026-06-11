<?php

namespace Database\Seeders;

use App\Models\GstRate;
use Illuminate\Database\Seeder;

class GstRateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
            [
                'hsn_code' => '998311',
                'description' => 'IT Services - Web Development',
                'cgst_rate' => 9.00,
                'sgst_rate' => 9.00,
                'igst_rate' => 18.00,
                'effective_from' => '2024-01-01',
                'effective_to' => null,
                'is_active' => true,
            ],
            [
                'hsn_code' => '998312',
                'description' => 'IT Services - Hosting',
                'cgst_rate' => 9.00,
                'sgst_rate' => 9.00,
                'igst_rate' => 18.00,
                'effective_from' => '2024-01-01',
                'effective_to' => null,
                'is_active' => true,
            ],
            [
                'hsn_code' => '998313',
                'description' => 'Consulting Services',
                'cgst_rate' => 9.00,
                'sgst_rate' => 9.00,
                'igst_rate' => 18.00,
                'effective_from' => '2024-01-01',
                'effective_to' => null,
                'is_active' => true,
            ],
            [
                'hsn_code' => '998314',
                'description' => 'Software License',
                'cgst_rate' => 2.50,
                'sgst_rate' => 2.50,
                'igst_rate' => 5.00,
                'effective_from' => '2024-01-01',
                'effective_to' => null,
                'is_active' => true,
            ],
            [
                'hsn_code' => '998315',
                'description' => 'Digital Products',
                'cgst_rate' => 6.00,
                'sgst_rate' => 6.00,
                'igst_rate' => 12.00,
                'effective_from' => '2024-01-01',
                'effective_to' => null,
                'is_active' => true,
            ],
            [
                'hsn_code' => '998316',
                'description' => 'Premium Services',
                'cgst_rate' => 14.00,
                'sgst_rate' => 14.00,
                'igst_rate' => 28.00,
                'effective_from' => '2024-01-01',
                'effective_to' => null,
                'is_active' => true,
            ],
        ];

        foreach ($rates as $rate) {
            GstRate::create($rate);
        }
    }
}
    