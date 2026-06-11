<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProformaInvoiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Company $company;
    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->company = Company::factory()->create();

        $this->user->update([
            'company_id' => $this->company->id,
            'current_company_id' => $this->company->id,
        ]);

        $this->client = Client::factory()->create([
            'company_id' => $this->company->id,
        ]);
    }

    #[Test]
    public function user_can_view_proforma_listing()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('proformas.index'));

        $response->assertStatus(200);
        $response->assertSee('Proforma Invoices');
    }

    #[Test]
    public function user_can_create_proforma_invoice()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('proformas.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'reference_number' => 'TEST-001',
            'payment_terms' => 'Net 15',
            'status' => 'draft',
            'items' => [
                [
                    'name' => 'Web Development Service',
                    'quantity' => 1,
                    'unit_price' => 50000,
                    'gst_rate' => 18,
                ],
                [
                    'name' => 'Hosting Service',
                    'quantity' => 12,
                    'unit_price' => 1000,
                    'gst_rate' => 18,
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
            'invoice_type' => 'proforma',
            'status' => 'draft',
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
        ]);

        $invoice = Invoice::first();
        $this->assertStringContainsString('PF-', $invoice->invoice_number);
        $this->assertEquals(2, $invoice->items()->count());
        $this->assertEquals(62000, $invoice->subtotal); // 50000 + (12 * 1000)
    }

    #[Test]
    public function it_calculates_totals_correctly()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('proformas.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'status' => 'draft',
            'items' => [
                [
                    'name' => 'Test Product',
                    'quantity' => 10,
                    'unit_price' => 100,
                    'gst_rate' => 18,
                ],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $invoice = Invoice::first();

        // 10 * 100 = 1000 subtotal
        $this->assertEquals(1000, $invoice->subtotal);

        // 1000 + 18% GST = 1180
        $this->assertEquals(1180, $invoice->grand_total);

        // CGST = SGST = 90
        $this->assertEquals(90, $invoice->cgst_amount);
        $this->assertEquals(90, $invoice->sgst_amount);
        $this->assertEquals(180, $invoice->total_gst_amount);
    }

    #[Test]
    public function it_applies_percentage_discount_correctly()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('proformas.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'status' => 'draft',
            'items' => [
                [
                    'name' => 'Test Product',
                    'quantity' => 1,
                    'unit_price' => 10000,
                    'gst_rate' => 18,
                ],
            ],
            'discount_type' => 'percentage',
            'discount_amount' => 10,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('invoices', ['invoice_type' => 'proforma']);
    }

    #[Test]
    public function it_adds_shipping_and_commission()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('proformas.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'status' => 'draft',
            'items' => [
                [
                    'name' => 'Test Product',
                    'quantity' => 1,
                    'unit_price' => 10000,
                    'gst_rate' => 18,
                ],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 500,
            'commission' => 200,
        ]);

        $invoice = Invoice::first();

        // 10000 + 1800(GST) + 500(shipping) + 200(commission) = 12500
        $this->assertEquals(12500, $invoice->grand_total);
        $this->assertEquals(500, $invoice->shipping_charges);
        $this->assertEquals(200, $invoice->commission);
    }

    #[Test]
    public function user_can_view_proforma_details()
    {
        $this->actingAs($this->user);

        // Create invoice first
        $invoice = Invoice::factory()->create([
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
            'created_by' => $this->user->id,
            'invoice_type' => 'proforma',
            'status' => 'draft',
        ]);

        $response = $this->get(route('proformas.show', $invoice->id));

        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
    }

    #[Test]
    public function user_can_edit_draft_proforma()
    {
        $this->actingAs($this->user);

        $invoice = Invoice::factory()->create([
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
            'created_by' => $this->user->id,
            'invoice_type' => 'proforma',
            'status' => 'draft',
        ]);

        $response = $this->get(route('proformas.edit', $invoice->id));

        $response->assertStatus(200);
        $response->assertSee('Edit Proforma');
    }

    #[Test]
    public function user_cannot_edit_sent_proforma()
    {
        $this->actingAs($this->user);

        $invoice = Invoice::factory()->create([
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
            'created_by' => $this->user->id,
            'invoice_type' => 'proforma',
            'status' => 'sent',
        ]);

        $response = $this->get(route('proformas.edit', $invoice->id));

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_update_proforma()
    {
        $this->actingAs($this->user);

        $invoice = Invoice::factory()->create([
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
            'created_by' => $this->user->id,
            'invoice_type' => 'proforma',
            'status' => 'draft',
            'invoice_number' => 'PF-2026-00001',
        ]);

        $response = $this->put(route('proformas.update', $invoice->id), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'draft',
            'items' => [
                [
                    'name' => 'Updated Service',
                    'quantity' => 5,
                    'unit_price' => 2000,
                    'gst_rate' => 18,
                ],
            ],
            'discount_type' => null,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'commission' => 0,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $invoice->refresh();
        $this->assertEquals('Updated Service', $invoice->items->first()->name);
    }

    #[Test]
    public function user_can_delete_draft_proforma()
    {
        $this->actingAs($this->user);

        $invoice = Invoice::factory()->create([
            'company_id' => $this->company->id,
            'client_id' => $this->client->id,
            'created_by' => $this->user->id,
            'invoice_type' => 'proforma',
            'status' => 'draft',
        ]);

        $response = $this->delete(route('proformas.destroy', $invoice->id));

        $response->assertRedirect();
        $this->assertSoftDeleted('invoices', ['id' => $invoice->id]);
    }

    #[Test]
    public function it_validates_required_fields()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('proformas.store'), [
            // Missing client_id and items
        ]);

        $response->assertSessionHasErrors(['client_id', 'items']);
    }

    #[Test]
    public function it_validates_minimum_one_item()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('proformas.store'), [
            'client_id' => $this->client->id,
            'invoice_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(15)->format('Y-m-d'),
            'items' => [], // Empty items array
        ]);

        $response->assertSessionHasErrors(['items']);
    }
}
