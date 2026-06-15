<?php

namespace App\Services\Invoice;

use App\DTOs\InvoiceData;
use App\DTOs\InvoiceTotals;
use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Services\GST\GSTCalculationService;
use App\Services\GST\TaxBreakdownService;
use App\Services\NumberGenerator\InvoiceNumberGenerator;

class GSTInvoiceService
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private TaxBreakdownService $taxBreakdownService,
        private InvoiceNumberGenerator $numberGenerator,
        private GSTCalculationService $gstService
    ) {}

    /**
     * Create a new GST invoice
     */
    public function createGSTInvoice(InvoiceData $data): Invoice
    {
        $totals = $this->calculateGSTTotals($data);
        $invoiceNumber = $this->numberGenerator->generateInvoiceNumber($data->company_id);

        return $this->invoiceRepository->create([
            'company_id' => $data->company_id,
            'client_id' => $data->client_id,
            'created_by' => $data->created_by,
            'invoice_number' => $invoiceNumber,
            'invoice_type' => 'gst_invoice',
            'status' => $data->status ?? 'draft',
            'reference_number' => $data->reference_number,
            'invoice_date' => $data->invoice_date,
            'due_date' => $data->due_date,
            'gst_mode' => $data->gst_mode,
            'gst_rate' => $data->gst_rate ?? 18.00,
            'place_of_supply' => $this->getPlaceOfSupply($data->company_id, $data->client_id),
            'place_of_supply_state_code' => Client::find($data->client_id)->state_code ?? null,
            'reverse_charge' => $data->reverse_charge ?? false,
            'subtotal' => $totals->subtotal,
            'discount_type' => $data->discount_type,
            'discount_amount' => $totals->discountAmount,
            'taxable_amount' => $totals->taxableAmount,
            'cgst_amount' => $totals->taxBreakdown?->cgstAmount ?? 0,
            'sgst_amount' => $totals->taxBreakdown?->sgstAmount ?? 0,
            'igst_amount' => $totals->taxBreakdown?->igstAmount ?? 0,
            'total_gst_amount' => $totals->totalGst,
            'shipping_charges' => $totals->shippingCharges,
            'commission' => $totals->commission,
            'grand_total' => $totals->grandTotal,
            'balance_due' => $totals->grandTotal,
            'notes' => $data->notes,
            'terms_and_conditions' => $data->terms_and_conditions,
            'payment_terms' => $data->payment_terms ?? 'Net 15',
            'show_hsn_sac' => $data->show_hsn_sac ?? true,
            'items' => array_map(fn($item) => $item->toArray(), $data->items),
        ]);
    }

    /**
     * Update GST invoice
     */
    public function updateGSTInvoice(int $id, InvoiceData $data): Invoice
    {
        $totals = $this->calculateGSTTotals($data);

        return $this->invoiceRepository->update($id, [
            'client_id' => $data->client_id,
            'updated_by' => $data->updated_by,
            'reference_number' => $data->reference_number,
            'invoice_date' => $data->invoice_date,
            'due_date' => $data->due_date,
            'gst_mode' => $data->gst_mode,
            'gst_rate' => $data->gst_rate ?? 18.00,
            'place_of_supply' => $this->getPlaceOfSupply($data->company_id, $data->client_id),
            'place_of_supply_state_code' => Client::find($data->client_id)->state_code ?? null,
            'reverse_charge' => $data->reverse_charge ?? false,
            'subtotal' => $totals->subtotal,
            'discount_type' => $data->discount_type,
            'discount_amount' => $totals->discountAmount,
            'taxable_amount' => $totals->taxableAmount,
            'cgst_amount' => $totals->taxBreakdown?->cgstAmount ?? 0,
            'sgst_amount' => $totals->taxBreakdown?->sgstAmount ?? 0,
            'igst_amount' => $totals->taxBreakdown?->igstAmount ?? 0,
            'total_gst_amount' => $totals->totalGst,
            'shipping_charges' => $totals->shippingCharges,
            'commission' => $totals->commission,
            'grand_total' => $totals->grandTotal,
            'balance_due' => $totals->grandTotal,
            'notes' => $data->notes,
            'terms_and_conditions' => $data->terms_and_conditions,
            'payment_terms' => $data->payment_terms ?? 'Net 15',
            'show_hsn_sac' => $data->show_hsn_sac ?? true,
            'items' => array_map(fn($item) => $item->toArray(), $data->items),
        ]);
    }

    /**
     * Calculate GST totals with proper state logic
     */
    public function calculateGSTTotals(InvoiceData $data): InvoiceTotals
    {
        $subtotal = 0;
        foreach ($data->items as $item) {
            $subtotal += $item->unit_price * $item->quantity;
        }

        $sellerState = Company::find($data->company_id)->state_code ?? '24';
        $buyerState = Client::find($data->client_id)->state_code ?? '24';

        if ($data->discount_type === 'fixed') {
            $subtotal -= ($data->discount_amount ?? 0);
            $discountPct = 0;
        } else {
            $discountPct = $data->discount_amount ?? 0;
        }

        return $this->taxBreakdownService->calculateInvoiceTax(
            subtotal: $subtotal,
            discountPercentage: $discountPct,
            mode: $data->gst_mode ?? 'exclusive',
            sellerState: $sellerState,
            buyerState: $buyerState,
            gstRate: $data->gst_rate ?? 18.00,
            shippingCharges: $data->shipping_charges ?? 0,
            commission: $data->commission ?? 0
        );
    }

    /**
     * Determine place of supply type
     */
    private function getPlaceOfSupply(int $companyId, int $clientId): string
    {
        $companyState = Company::find($companyId)->state_code;
        $clientState = Client::find($clientId)->state_code;
        return $companyState === $clientState ? 'intra_state' : 'inter_state';
    }

    /**
     * Recalculate invoice with new GST mode (exclusive/inclusive)
     */
    public function recalculateWithMode(int $invoiceId, string $newMode): Invoice
    {
        $invoice = $this->invoiceRepository->findById($invoiceId, $invoice->company_id);

        // If mode changes, recalculate items
        if ($invoice->gst_mode !== $newMode) {
            // Update mode and recalculate
            $invoice->update(['gst_mode' => $newMode]);
            // TODO: Recalculate all items with new mode
        }

        return $invoice->fresh();
    }

    /**
     * Get tax breakdown for display
     */
    public function getTaxBreakdown(int $invoiceId): array
    {
        $invoice = Invoice::with('items')->find($invoiceId);

        return [
            'tax_type' => $invoice->igst_amount > 0 ? 'igst' : 'cgst_sgst',
            'cgst' => $invoice->cgst_amount,
            'sgst' => $invoice->sgst_amount,
            'igst' => $invoice->igst_amount,
            'total_gst' => $invoice->total_gst_amount,
            'mode' => $invoice->gst_mode,
            'rate' => $invoice->gst_rate,
            'subtotal' => $invoice->subtotal,
            'taxable' => $invoice->taxable_amount,
            'grand_total' => $invoice->grand_total,
        ];
    }

    /**
     * Get invoice with relations
     */
    public function getInvoice(int $id, int $companyId): ?Invoice
    {
        return $this->invoiceRepository->findById($id, $companyId);
    }

    /**
     * List GST invoices
     */
    public function listGSTInvoices(int $companyId, array $filters = [])
    {
        $filters['type'] = 'gst_invoice';
        return $this->invoiceRepository->getByCompany($companyId, $filters);
    }

    /**
     * Delete invoice
     */
    public function deleteGSTInvoice(int $id): bool
    {
        return $this->invoiceRepository->delete($id);
    }
}
