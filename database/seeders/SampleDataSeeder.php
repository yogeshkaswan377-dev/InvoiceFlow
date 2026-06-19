<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\Client;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. COMPANIES
        // ============================================
        $company1 = Company::where('email', 'contact@demobusiness.com')->first();
        if (!$company1) {
            $company1 = Company::create([
                'name' => 'Demo Business Pvt Ltd',
                'email' => 'contact@demobusiness.com',
                'phone' => '9876543210',
                'gstin' => '27ABCDE1234F1Z5',
                'state_code' => '27',
                'state' => 'Maharashtra',
                'address_line_1' => '123, Business Park, Andheri East',
                'city' => 'Mumbai',
                'pincode' => '400093',
                'country' => 'India',
                'subscription_plan' => 'trial',
                'is_active' => 1,
            ]);
        }

        $company2 = Company::create([
            'name' => 'Tech Solutions India',
            'email' => 'info@techsolutions.com',
            'phone' => '9988776655',
            'gstin' => '29AABCT1234E1Z6',
            'state_code' => '29',
            'state' => 'Karnataka',
            'address_line_1' => '456, Tech Park, Whitefield',
            'city' => 'Bangalore',
            'pincode' => '560066',
            'country' => 'India',
            'subscription_plan' => 'basic',
            'is_active' => 1,
        ]);

        $company3 = Company::create([
            'name' => 'Gujarat Textiles',
            'email' => 'info@gujarattextiles.com',
            'phone' => '9876541230',
            'gstin' => '24ABCDE5678F1Z9',
            'state_code' => '24',
            'state' => 'Gujarat',
            'address_line_1' => '789, Textile Market',
            'city' => 'Ahmedabad',
            'pincode' => '380001',
            'country' => 'India',
            'subscription_plan' => 'premium',
            'is_active' => 1,
        ]);

        // ============================================
        // 2. USERS
        // ============================================
        $admin1 = User::where('email', 'admin@example.com')->first();
        if (!$admin1) {
            $admin1 = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'company_id' => $company1->id,
                'current_company_id' => $company1->id,
                'phone' => '9876543210',
            ]);
            $admin1->assignRole('owner', $company1->id);
        }

        $owner2 = User::create([
            'name' => 'Rahul Sharma',
            'email' => 'rahul@techsolutions.com',
            'password' => Hash::make('password'),
            'company_id' => $company2->id,
            'current_company_id' => $company2->id,
            'phone' => '9988776655',
        ]);
        $owner2->assignRole('owner', $company2->id);

        $owner3 = User::create([
            'name' => 'Amit Patel',
            'email' => 'amit@gujarattextiles.com',
            'password' => Hash::make('password'),
            'company_id' => $company3->id,
            'current_company_id' => $company3->id,
            'phone' => '9876541230',
        ]);
        $owner3->assignRole('owner', $company3->id);

        // Staff for Demo Business
        $staff1 = User::create([
            'name' => 'Priya Singh',
            'email' => 'priya@demobusiness.com',
            'password' => Hash::make('password'),
            'company_id' => $company1->id,
            'current_company_id' => $company1->id,
            'phone' => '9876512345',
        ]);
        $staff1->assignRole('staff', $company1->id);

        $staff2 = User::create([
            'name' => 'Vikram Desai',
            'email' => 'vikram@demobusiness.com',
            'password' => Hash::make('password'),
            'company_id' => $company1->id,
            'current_company_id' => $company1->id,
            'phone' => '9876512346',
        ]);
        $staff2->assignRole('admin', $company1->id);

        // ============================================
        // 3. CLIENTS (Demo Business)
        // ============================================
        $clients = [
            [
                'company_id' => $company1->id,
                'client_type' => 'business',
                'name' => 'Reliance Digital',
                'company_name' => 'Reliance Digital Ltd',
                'email' => 'accounts@reliancedigital.com',
                'phone' => '022-45678901',
                'gstin' => '27AAACR1234E1Z5',
                'state_code' => '27',
                'state_name' => 'Maharashtra',
                'state' => 'Maharashtra',
                'address_line_1' => 'Reliance Corporate Park',
                'city' => 'Navi Mumbai',
                'pincode' => '400701',
                'country' => 'India',
                'place_of_supply' => 'intra_state',
                'status' => 'active',
                'is_active' => 1,
            ],
            [
                'company_id' => $company1->id,
                'client_type' => 'business',
                'name' => 'Infosys Technologies',
                'company_name' => 'Infosys Ltd',
                'email' => 'billing@infosys.com',
                'phone' => '080-39876000',
                'gstin' => '29AAACI1234E1Z7',
                'state_code' => '29',
                'state_name' => 'Karnataka',
                'state' => 'Karnataka',
                'address_line_1' => 'Electronics City',
                'city' => 'Bangalore',
                'pincode' => '560100',
                'country' => 'India',
                'place_of_supply' => 'inter_state',
                'status' => 'active',
                'is_active' => 1,
            ],
            [
                'company_id' => $company1->id,
                'client_type' => 'individual',
                'name' => 'Suresh Kumar',
                'email' => 'suresh.kumar@gmail.com',
                'phone' => '9812345678',
                'state_code' => '27',
                'state_name' => 'Maharashtra',
                'state' => 'Maharashtra',
                'address_line_1' => '42, Palm Street, Bandra West',
                'city' => 'Mumbai',
                'pincode' => '400050',
                'country' => 'India',
                'place_of_supply' => 'intra_state',
                'status' => 'active',
                'is_active' => 1,
            ],
            [
                'company_id' => $company1->id,
                'client_type' => 'business',
                'name' => 'Delhi Distributors',
                'company_name' => 'Delhi Distributors Pvt Ltd',
                'email' => 'orders@delhidist.com',
                'phone' => '011-23456789',
                'gstin' => '07AAACD1234E1Z8',
                'state_code' => '07',
                'state_name' => 'Delhi',
                'state' => 'Delhi',
                'address_line_1' => '15, Okhla Industrial Area',
                'city' => 'New Delhi',
                'pincode' => '110020',
                'country' => 'India',
                'place_of_supply' => 'inter_state',
                'status' => 'active',
                'is_active' => 1,
            ],
            [
                'company_id' => $company1->id,
                'client_type' => 'export',
                'name' => 'Global Trade LLC',
                'company_name' => 'Global Trade LLC',
                'email' => 'orders@globaltrade.com',
                'phone' => '+1-555-0123',
                'state_code' => '99',
                'state_name' => 'Outside India',
                'state' => 'Outside India',
                'address_line_1' => '123, Main Street',
                'city' => 'New York',
                'pincode' => '10001',
                'country' => 'USA',
                'place_of_supply' => 'export',
                'status' => 'active',
                'is_active' => 1,
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }

        // ============================================
        // 4. PRODUCTS (Demo Business)
        // ============================================
        $products = [
            ['company_id' => $company1->id, 'name' => 'Web Development Service', 'hsn_sac_code' => '998313', 'unit_price' => 50000, 'gst_rate' => 18, 'unit' => 'project'],
            ['company_id' => $company1->id, 'name' => 'IT Consulting', 'hsn_sac_code' => '998314', 'unit_price' => 25000, 'gst_rate' => 18, 'unit' => 'hour'],
            ['company_id' => $company1->id, 'name' => 'Cloud Hosting - Monthly', 'hsn_sac_code' => '998315', 'unit_price' => 5000, 'gst_rate' => 18, 'unit' => 'month'],
            ['company_id' => $company1->id, 'name' => 'Software License', 'hsn_sac_code' => '85238020', 'unit_price' => 150000, 'gst_rate' => 18, 'unit' => 'license'],
            ['company_id' => $company1->id, 'name' => 'Hardware Setup', 'hsn_sac_code' => '84713010', 'unit_price' => 35000, 'gst_rate' => 28, 'unit' => 'setup'],
            ['company_id' => $company1->id, 'name' => 'Annual Maintenance', 'hsn_sac_code' => '9987', 'unit_price' => 12000, 'gst_rate' => 18, 'unit' => 'year'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // ============================================
        // 5. INVOICES (Demo Business)
        // ============================================
        $clientsList = Client::where('company_id', $company1->id)->get();
        $productsList = Product::where('company_id', $company1->id)->get();

        // Proforma Invoice 1 - Draft
        $proforma1 = Invoice::create([
            'company_id' => $company1->id,
            'client_id' => $clientsList[0]->id,
            'invoice_number' => 'PRO-2026-00001',
            'invoice_type' => 'proforma',
            'invoice_date' => '2026-06-10',
            'due_date' => '2026-07-10',
            'subtotal' => 50000,
            'discount_amount' => 0,
            'taxable_value' => 50000,
            'total_gst_amount' => 9000,
            'cgst_amount' => 4500,
            'sgst_amount' => 4500,
            'igst_amount' => 0,
            'grand_total' => 59000,
            'balance_due' => 59000,
            'status' => 'draft',
            'place_of_supply' => 'intra_state',
            'gst_mode' => 'exclusive',
            'created_by' => $admin1->id,
        ]);

        InvoiceItem::create([
            'invoice_id' => $proforma1->id,
            'name' => $productsList[0]->name,
            'hsn_sac_code' => $productsList[0]->hsn_sac_code,
            'quantity' => 1,
            'unit_price' => 50000,
            'gst_rate' => 18,
            'taxable_amount' => 50000,
            'cgst_amount' => 4500,
            'sgst_amount' => 4500,
            'total_amount' => 59000,
        ]);

        // Proforma Invoice 2 - Sent
        $proforma2 = Invoice::create([
            'company_id' => $company1->id,
            'client_id' => $clientsList[1]->id,
            'invoice_number' => 'PRO-2026-00002',
            'invoice_type' => 'proforma',
            'invoice_date' => '2026-06-12',
            'due_date' => '2026-07-12',
            'subtotal' => 25000,
            'discount_amount' => 0,
            'taxable_value' => 25000,
            'total_gst_amount' => 4500,
            'igst_amount' => 4500,
            'cgst_amount' => 0,
            'sgst_amount' => 0,
            'grand_total' => 29500,
            'balance_due' => 29500,
            'status' => 'sent',
            'place_of_supply' => 'inter_state',
            'gst_mode' => 'exclusive',
            'created_by' => $admin1->id,
        ]);

        InvoiceItem::create([
            'invoice_id' => $proforma2->id,
            'name' => $productsList[1]->name,
            'hsn_sac_code' => $productsList[1]->hsn_sac_code,
            'quantity' => 1,
            'unit_price' => 25000,
            'gst_rate' => 18,
            'taxable_amount' => 25000,
            'igst_amount' => 4500,
            'total_amount' => 29500,
        ]);

        // GST Invoice 1 - Paid
        $gst1 = Invoice::create([
            'company_id' => $company1->id,
            'client_id' => $clientsList[0]->id,
            'invoice_number' => 'INV-2026-00001',
            'invoice_type' => 'gst_invoice',
            'invoice_date' => '2026-06-01',
            'due_date' => '2026-06-15',
            'subtotal' => 150000,
            'discount_amount' => 0,
            'taxable_value' => 150000,
            'total_gst_amount' => 27000,
            'cgst_amount' => 13500,
            'sgst_amount' => 13500,
            'igst_amount' => 0,
            'grand_total' => 177000,
            'balance_due' => 0,
            'total_paid' => 177000,
            'status' => 'paid',
            'place_of_supply' => 'intra_state',
            'gst_mode' => 'exclusive',
            'created_by' => $admin1->id,
        ]);

        InvoiceItem::create([
            'invoice_id' => $gst1->id,
            'name' => $productsList[3]->name,
            'hsn_sac_code' => $productsList[3]->hsn_sac_code,
            'quantity' => 1,
            'unit_price' => 150000,
            'gst_rate' => 18,
            'taxable_amount' => 150000,
            'cgst_amount' => 13500,
            'sgst_amount' => 13500,
            'total_amount' => 177000,
        ]);

        // GST Invoice 2 - Sent (Inter-state)
        $gst2 = Invoice::create([
            'company_id' => $company1->id,
            'client_id' => $clientsList[3]->id,
            'invoice_number' => 'INV-2026-00002',
            'invoice_type' => 'gst_invoice',
            'invoice_date' => '2026-06-05',
            'due_date' => '2026-06-20',
            'subtotal' => 35000,
            'discount_amount' => 0,
            'taxable_value' => 35000,
            'total_gst_amount' => 9800,
            'igst_amount' => 9800,
            'cgst_amount' => 0,
            'sgst_amount' => 0,
            'grand_total' => 44800,
            'balance_due' => 44800,
            'status' => 'sent',
            'place_of_supply' => 'inter_state',
            'gst_mode' => 'exclusive',
            'created_by' => $admin1->id,
        ]);

        InvoiceItem::create([
            'invoice_id' => $gst2->id,
            'name' => $productsList[4]->name,
            'hsn_sac_code' => $productsList[4]->hsn_sac_code,
            'quantity' => 1,
            'unit_price' => 35000,
            'gst_rate' => 28,
            'taxable_amount' => 35000,
            'igst_amount' => 9800,
            'total_amount' => 44800,
        ]);

        // GST Invoice 3 - Overdue
        $gst3 = Invoice::create([
            'company_id' => $company1->id,
            'client_id' => $clientsList[2]->id,
            'invoice_number' => 'INV-2026-00003',
            'invoice_type' => 'gst_invoice',
            'invoice_date' => '2026-05-01',
            'due_date' => '2026-05-15',
            'subtotal' => 12000,
            'discount_amount' => 0,
            'taxable_value' => 12000,
            'total_gst_amount' => 2160,
            'cgst_amount' => 1080,
            'sgst_amount' => 1080,
            'igst_amount' => 0,
            'grand_total' => 14160,
            'balance_due' => 14160,
            'status' => 'overdue',
            'place_of_supply' => 'intra_state',
            'gst_mode' => 'exclusive',
            'created_by' => $admin1->id,
        ]);

        InvoiceItem::create([
            'invoice_id' => $gst3->id,
            'name' => $productsList[5]->name,
            'hsn_sac_code' => $productsList[5]->hsn_sac_code,
            'quantity' => 1,
            'unit_price' => 12000,
            'gst_rate' => 18,
            'taxable_amount' => 12000,
            'cgst_amount' => 1080,
            'sgst_amount' => 1080,
            'total_amount' => 14160,
        ]);

        // GST Invoice 4 - Export (no GST)
        $gst4 = Invoice::create([
            'company_id' => $company1->id,
            'client_id' => $clientsList[4]->id,
            'invoice_number' => 'INV-2026-00004',
            'invoice_type' => 'gst_invoice',
            'invoice_date' => '2026-06-15',
            'due_date' => '2026-07-15',
            'subtotal' => 50000,
            'discount_amount' => 0,
            'taxable_value' => 50000,
            'total_gst_amount' => 0,
            'igst_amount' => 0,
            'cgst_amount' => 0,
            'sgst_amount' => 0,
            'grand_total' => 50000,
            'balance_due' => 50000,
            'status' => 'sent',
            'place_of_supply' => 'export',
            'gst_mode' => 'exclusive',
            'created_by' => $admin1->id,
        ]);

        InvoiceItem::create([
            'invoice_id' => $gst4->id,
            'name' => $productsList[0]->name,
            'hsn_sac_code' => $productsList[0]->hsn_sac_code,
            'quantity' => 1,
            'unit_price' => 50000,
            'gst_rate' => 0,
            'taxable_amount' => 50000,
            'igst_amount' => 0,
            'total_amount' => 50000,
        ]);

        echo "\n✅ Sample data seeded!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Companies: 3\n";
        echo "Users: 6\n";
        echo "Clients: 5 (Demo Business)\n";
        echo "Products: 6 (Demo Business)\n";
        echo "Invoices: 6 (2 Proforma + 4 GST)\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Login:\n";
        echo "  Owner: admin@example.com / password\n";
        echo "  Staff: priya@demobusiness.com / password\n";
        echo "  Super: super@example.com / password\n";
    }
}
