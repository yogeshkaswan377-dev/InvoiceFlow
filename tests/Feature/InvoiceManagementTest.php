<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Services\NumberGenerator\InvoiceNumberGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InvoiceManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Company $company;
    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create([
            'name' => 'Test Company',
            'state_code' => '27',
            'gstin' => '27ABCDE1234F1Z5',
        ]);

        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $this->client = Client::factory()->create([
            'company_id' => $this->company->id,
            'state_code' => '27',
            'gstin' => '27AABCU9603R1ZX',
        ]);
    }

    #[Test]
    public function invoice_number_is_generated_correctly()
    {
        $generator = app(InvoiceNumberGenerator::class);
        $number = $generator->generateInvoiceNumber($this->company->id);

        $this->assertStringContainsString('INV-' . date('Y'), $number);
        $this->assertMatchesRegularExpression('/^INV-\d{4}-\d{5}$/', $number);
    }

    #[Test]
    public function invoice_numbers_are_unique()
    {
        $generator = app(InvoiceNumberGenerator::class);
        $number1 = $generator->generateInvoiceNumber($this->company->id);
        $number2 = $generator->generateInvoiceNumber($this->company->id);

        $this->assertNotEquals($number1, $number2);
    }

    #[Test]
    public function invoice_can_be_created_with_items()
    {
        $this->actingAs($this->user);

        $invoiceData = [
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
            'created_by' => $this->user->id,
            'invoice_number' => 'INV-2026-00001',
            'invoice_type' => 'gst_invoice',
            'status' => 'draft',
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'gst_mode' => 'exclusive',
            'gst_rate' => 18.00,
            'subtotal' => 1000,
            'taxable_amount' => 1000,
            'cgst_amount' => 90,
            'sgst_amount' => 90,
            'total_gst_amount' => 180,
            'grand_total' => 1180,
            'balance_due' => 1180,
            'items' => [
                [
                    'name' => 'Test Product',
                    'quantity' => 1,
                    'unit_price' => 1000,
                    'gst_rate' => 18.00,
                    'taxable_amount' => 1000,
                    'cgst_amount' => 90,
                    'sgst_amount' => 90,
                    'line_total' => 1000,
                    'line_total_with_gst' => 1180,
                ]
            ]
        ];

        $invoice = app(InvoiceRepositoryInterface::class)->create($invoiceData);

        $this->assertDatabaseHas('invoices', ['invoice_number' => 'INV-2026-00001']);
        $this->assertDatabaseHas('invoice_items', ['name' => 'Test Product']);
        $this->assertCount(1, $invoice->items);
    }
}
