<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Demo Company with Indian format
        $company = Company::create([
            'name' => 'Demo Business Pvt Ltd',
            'email' => 'contact@demobusiness.com',
            'phone' => '9876543210',
            'gstin' => '27ABCDE1234F1Z5',
            'pan' => 'ABCDE1234F',
            'cin' => 'U12345MH2025PTC123456',
            'address_line_1' => '123, Business Park',
            'address_line_2' => 'Andheri East',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'state_code' => '27',
            'pincode' => '400093',
            'country' => 'India',
            'bank_details' => [
                'bank_name' => 'HDFC Bank',
                'account_number' => '12345678901234',
                'ifsc_code' => 'HDFC0001234',
                'account_name' => 'Demo Business Pvt Ltd'
            ],
            'gst_settings' => [
                'default_rate' => 18,
                'default_mode' => 'exclusive',
                'enable_reverse_charge' => false,
                'auto_apply_gst' => true
            ],
            'invoice_preferences' => [
                'invoice_prefix' => 'INV',
                'quote_prefix' => 'Q',
                'proforma_prefix' => 'PRO',
                'payment_terms' => 'Net 15',
                'due_days' => 15
            ],
            'is_active' => true
        ]);
        

        
        // Create admin user if not exists
        $user = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'phone' => '9876543210',
                'designation' => 'Owner',
                'company_id' => $company->id,
                'current_company_id' => $company->id,
                'timezone' => 'Asia/Kolkata'
            ]
        );
        
        // Assign owner role
        $user->assignRole('owner', $company->id);
    }
}