<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'company_id' => 1,
            'client_id' => 1,
            'created_by' => 1,
            'invoice_number' => 'INV-' . fake()->unique()->numberBetween(1000, 9999),
            'invoice_type' => 'proforma',
            'status' => 'draft',
            'invoice_date' => now(),
            'due_date' => now()->addDays(15),
            'gst_mode' => 'exclusive',
            'gst_rate' => 18.00,
            'subtotal' => 1000,
            'taxable_amount' => 1000,
            'total_gst_amount' => 180,
            'grand_total' => 1180,
            'balance_due' => 1180,
        ];
    }
}
