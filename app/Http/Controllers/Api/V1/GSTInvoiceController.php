<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\DTOs\InvoiceData;
use App\DTOs\InvoiceItemData;
use App\Http\Requests\StoreProformaRequest;
use App\Http\Requests\UpdateProformaRequest;
use App\Http\Resources\InvoiceResource;
use App\Services\Invoice\GSTInvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class GSTInvoiceController extends Controller
{
    public function __construct(
        private GSTInvoiceService $gstInvoiceService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $companyId = session('current_company_id');
        $filters = $request->only(['status', 'date_from', 'date_to', 'search', 'client_id']);
        $invoices = $this->gstInvoiceService->listGSTInvoices($companyId, $filters);

        return response()->json([
            'success' => true,
            'data' => InvoiceResource::collection($invoices->items()),
            'meta' => [
                'current_page' => $invoices->currentPage(),
                'last_page' => $invoices->lastPage(),
                'per_page' => $invoices->perPage(),
                'total' => $invoices->total(),
                'from' => $invoices->firstItem(),
                'to' => $invoices->lastItem(),
            ],
        ]);
    }

    /**
     * List all invoices (combined proforma + gst).
     */
    

    /**
     * Store GST invoice.
     */
    public function store(StoreProformaRequest $request): JsonResponse
    {
        $companyId = session('current_company_id');

        $items = collect($request->items)->map(function ($item) {
            return new InvoiceItemData(
                name: $item['name'],
                quantity: (int) $item['quantity'],
                unit_price: (float) $item['unit_price'],
                description: $item['description'] ?? null,
                hsn_sac_code: $item['hsn_sac_code'] ?? null,
                gst_rate: (float) ($item['gst_rate'] ?? 18.00),
                taxable_amount: (float) ($item['unit_price'] * $item['quantity']),
            );
        })->toArray();

        $invoiceData = new InvoiceData(
            company_id: $companyId,
            client_id: (int) $request->client_id,
            created_by: Auth::id(),
            invoice_type: 'gst_invoice',
            gst_mode: $request->gst_mode ?? 'exclusive',
            gst_rate: (float) ($request->gst_rate ?? 18.00),
            invoice_date: $request->invoice_date,
            due_date: $request->due_date,
            reference_number: $request->reference_number,
            discount_type: $request->discount_type,
            discount_amount: (float) ($request->discount_amount ?? 0),
            shipping_charges: (float) ($request->shipping_charges ?? 0),
            commission: (float) ($request->commission ?? 0),
            reverse_charge: $request->has('reverse_charge'),
            notes: $request->notes,
            terms_and_conditions: $request->terms_and_conditions,
            payment_terms: $request->payment_terms ?? 'Net 15',
            show_hsn_sac: $request->has('show_hsn_sac'),
            items: $items,
            status: $request->status ?? 'draft',
        );

        $invoice = $this->gstInvoiceService->createGSTInvoice($invoiceData);

        return response()->json([
            'success' => true,
            'message' => 'GST Invoice created!',
            'data' => new InvoiceResource($invoice->load('items', 'client')),
        ], 201);
    }
    /**
     * Show GST invoice.
     */
    public function show(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice || $invoice->invoice_type !== 'gst_invoice') {
            return response()->json([
                'success' => false,
                'message' => 'GST Invoice not found.',
            ], 404);
        }

        Gate::authorize('view', $invoice);

        return response()->json([
            'success' => true,
            'data' => new InvoiceResource($invoice->load('items', 'client', 'company')),
        ]);
    }

    /**
     * Update GST invoice.
     */
    public function update(UpdateProformaRequest $request, int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice || !$invoice->isEditable()) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found or not editable.',
            ], 404);
        }

        Gate::authorize('update', $invoice);

        $items = collect($request->items)->map(function ($item) {
            return new InvoiceItemData(
                name: $item['name'],
                quantity: (int) $item['quantity'],
                unit_price: (float) $item['unit_price'],
                description: $item['description'] ?? null,
                hsn_sac_code: $item['hsn_sac_code'] ?? null,
                gst_rate: (float) ($item['gst_rate'] ?? 18.00),
                taxable_amount: (float) ($item['unit_price'] * $item['quantity']),
            );
        })->toArray();

        $invoiceData = new InvoiceData(
            company_id: $companyId,
            client_id: (int) $request->client_id,
            created_by: Auth::id(),
            invoice_type: 'gst_invoice',
            gst_mode: $request->gst_mode ?? 'exclusive',
            gst_rate: (float) ($request->gst_rate ?? 18.00),
            invoice_date: $request->invoice_date,
            due_date: $request->due_date,
            reference_number: $request->reference_number,
            discount_type: $request->discount_type,
            discount_amount: (float) ($request->discount_amount ?? 0),
            shipping_charges: (float) ($request->shipping_charges ?? 0),
            commission: (float) ($request->commission ?? 0),
            reverse_charge: $request->has('reverse_charge'),
            notes: $request->notes,
            terms_and_conditions: $request->terms_and_conditions,
            payment_terms: $request->payment_terms ?? 'Net 15',
            show_hsn_sac: $request->has('show_hsn_sac'),
            items: $items,
            updated_by: Auth::id(),
        );

        $this->gstInvoiceService->updateGSTInvoice($id, $invoiceData);

        return response()->json([
            'success' => true,
            'message' => 'GST Invoice updated!',
            'data' => new InvoiceResource($invoice->fresh()->load('items', 'client')),
        ]);
    }

    /**
     * Delete GST invoice.
     */
    public function destroy(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice || !$invoice->isDeletable()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this invoice.',
            ], 422);
        }

        Gate::authorize('delete', $invoice);

        Log::warning('GST Invoice deleted via API', [
            'user_id' => Auth::id(),
            'invoice_number' => $invoice->invoice_number,
            'company_id' => $companyId,
        ]);

        $this->gstInvoiceService->deleteGSTInvoice($id);

        return response()->json([
            'success' => true,
            'message' => 'GST Invoice deleted.',
        ]);
    }

    /**
     * Recalculate GST (stub for future).
     */
    public function recalculate(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Recalculation endpoint ready.',
            'data' => $invoice->load('items'),
        ]);
    }

    /**
     * Get tax breakdown.
     */
    public function taxBreakdown(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new \App\Http\Resources\TaxBreakdownResource($invoice),
        ]);
    }

    /**
     * Download PDF.
     */
    public function pdf(int $id)
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);
        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }
        $pdf = Pdf::loadView('gst-invoices.pdf', compact('invoice'));
        return $pdf->download('GST-Invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Stream PDF preview.
     */
    public function stream(int $id)
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);
        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }
        $pdf = Pdf::loadView('gst-invoices.pdf', compact('invoice'));
        return $pdf->stream('GST-Invoice-' . $invoice->invoice_number . '.pdf');
    }


    /**
     * Bulk PDF download.
     */
    public function bulkPdf(Request $request)
    {
        $request->validate(['ids' => 'required|string']);
        $ids = explode(',', $request->ids);
        $companyId = session('current_company_id');

        $zip = new ZipArchive();
        $zipName = 'invoices-' . now()->format('Ymd') . '.zip';
        $zipPath = storage_path('app/' . $zipName);

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($ids as $id) {
                $invoice = $this->gstInvoiceService->getInvoice(trim($id), $companyId);
                if ($invoice) {
                    $pdf = Pdf::loadView('gst-invoices.pdf', compact('invoice'));
                    $zip->addFromString($invoice->invoice_number . '.pdf', $pdf->output());
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend();
    }
    /**
     * Send invoice via email.
     */
    public function sendEmail(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice || !$invoice->client->email) {
            return response()->json([
                'success' => false,
                'message' => 'Client email not found.',
            ], 422);
        }

        Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));

        Log::info('GST Invoice emailed via API', [
            'invoice_number' => $invoice->invoice_number,
            'sent_to' => $invoice->client->email,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice emailed to ' . $invoice->client->email,
        ]);
    }
}
