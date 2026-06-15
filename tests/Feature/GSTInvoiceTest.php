<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GSTInvoiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Company $company;
    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->company = Company::factory()->create([
            'state_code' => '24',
        ]);

        $this->user->update([
            'company_id' => $this->company->id,
            'current_company_id' => $this->company->id,
        ]);

        $this->client = Client::factory()->create([
            'company_id' => $this->company->id,
            'state_code' => '24',
        ]);
    }

    /** @test */
    public function user_can_view_gst_invoice_listing()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('gst-invoices.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_gst_invoice_exclusive_mode()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('gst-invoices.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'gst_mode' => 'exclusive',
            'status' => 'draft',
            'items' => [
                [
                    'name' => 'Consulting Service',
                    'quantity' => 1,
                    'unit_price' => 50000,
                    'gst_rate' => 18,
                    'hsn_sac_code' => '998313',
                ],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('invoices', [
            'invoice_type' => 'gst_invoice',
            'gst_mode' => 'exclusive',
            'company_id' => $this->company->id,
        ]);

        $invoice = Invoice::first();
        $this->assertStringContainsString('INV-', $invoice->invoice_number);
        $this->assertEquals(50000, (int)$invoice->subtotal);
        $this->assertEquals(9000, (int)$invoice->total_gst_amount);
        $this->assertEquals(59000, (int)$invoice->grand_total);
    }

    /** @test */
    public function user_can_create_gst_invoice_inclusive_mode()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('gst-invoices.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'gst_mode' => 'inclusive',
            'status' => 'draft',
            'items' => [
                [
                    'name' => 'Product Sale',
                    'quantity' => 2,
                    'unit_price' => 5900,
                    'gst_rate' => 18,
                    'hsn_sac_code' => '998311',
                ],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $response->assertRedirect();

        $invoice = Invoice::first();
        $this->assertEquals('inclusive', $invoice->gst_mode);
        $this->assertStringContainsString('INV-', $invoice->invoice_number);
    }

    /** @test */
    public function it_calculates_cgst_sgst_for_intra_state()
    {
        $this->actingAs($this->user);

        $this->post(route('gst-invoices.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'gst_mode' => 'exclusive',
            'status' => 'draft',
            'items' => [
                ['name' => 'Service', 'quantity' => 1, 'unit_price' => 10000, 'gst_rate' => 18],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $invoice = Invoice::first();
        $this->assertEquals(900, (int)$invoice->cgst_amount);
        $this->assertEquals(900, (int)$invoice->sgst_amount);
        $this->assertEquals(0, (int)$invoice->igst_amount);
        $this->assertEquals(1800, (int)$invoice->total_gst_amount);
        $this->assertEquals('intra_state', $invoice->place_of_supply);
    }

    /** @test */
    public function it_calculates_igst_for_inter_state()
    {
        // Change client state to different state
        $this->client->update(['state_code' => '27']);

        $this->actingAs($this->user);

        $this->post(route('gst-invoices.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'gst_mode' => 'exclusive',
            'status' => 'draft',
            'items' => [
                ['name' => 'Service', 'quantity' => 1, 'unit_price' => 10000, 'gst_rate' => 18],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $invoice = Invoice::first();
        $this->assertEquals(0, (int)$invoice->cgst_amount);
        $this->assertEquals(0, (int)$invoice->sgst_amount);
        $this->assertEquals(1800, (int)$invoice->igst_amount);
        $this->assertEquals('inter_state', $invoice->place_of_supply);
    }

    /** @test */
    public function it_stores_hsn_sac_codes()
    {
        $this->actingAs($this->user);

        $this->post(route('gst-invoices.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'gst_mode' => 'exclusive',
            'status' => 'draft',
            'items' => [
                ['name' => 'Web Dev', 'quantity' => 1, 'unit_price' => 10000, 'gst_rate' => 18, 'hsn_sac_code' => '998311'],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $invoice = Invoice::first();
        $this->assertEquals('998311', $invoice->items->first()->hsn_sac_code);
    }

    /** @test */
    public function it_handles_reverse_charge()
    {
        $this->actingAs($this->user);

        $this->post(route('gst-invoices.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'gst_mode' => 'exclusive',
            'status' => 'draft',
            'reverse_charge' => '1',
            'items' => [
                ['name' => 'Service', 'quantity' => 1, 'unit_price' => 10000, 'gst_rate' => 18],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $invoice = Invoice::first();
        $this->assertEquals(1, $invoice->reverse_charge);
    }

    /** @test */
    public function user_can_view_gst_invoice_details()
    {
        $this->actingAs($this->user);

        $invoice = Invoice::factory()->create([
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
            'created_by' => $this->user->id,
            'invoice_type' => 'gst_invoice',
            'invoice_number' => 'INV-2026-00001',
            'status' => 'draft',
            'gst_mode' => 'exclusive',
        ]);

        $response = $this->get(route('gst-invoices.show', $invoice->id));
        $response->assertStatus(200);
        $response->assertSee('INV-2026-00001');
    }
}
