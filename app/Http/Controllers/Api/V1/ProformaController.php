<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\DTOs\InvoiceData;
use App\DTOs\InvoiceItemData;
use App\Http\Requests\StoreProformaRequest;
use App\Http\Requests\UpdateProformaRequest;
use App\Http\Resources\InvoiceResource;
use App\Services\Invoice\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class ProformaController extends Controller
{
    public function __construct(
        private InvoiceService $invoiceService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $companyId = session('current_company_id');
        $filters = $request->only(['status', 'date_from', 'date_to', 'search', 'client_id']);
        $invoices = $this->invoiceService->listProformas($companyId, $filters);

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
            'links' => [
                'first' => $invoices->url(1),
                'last' => $invoices->url($invoices->lastPage()),
                'prev' => $invoices->previousPageUrl(),
                'next' => $invoices->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store new proforma.
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
                gst_rate: (float) ($item['gst_rate'] ?? 18.00),
                discount_type: $item['discount_type'] ?? null,
                discount_value: (float) ($item['discount_value'] ?? 0),
                taxable_amount: (float) ($item['unit_price'] * $item['quantity']),
            );
        })->toArray();

        $invoiceData = new InvoiceData(
            company_id: $companyId,
            client_id: (int) $request->client_id,
            created_by: Auth::id(),
            invoice_type: 'proforma',
            gst_mode: 'exclusive',
            gst_rate: 18.00,
            invoice_date: $request->invoice_date,
            due_date: $request->due_date,
            reference_number: $request->reference_number,
            discount_type: $request->discount_type,
            discount_amount: (float) ($request->discount_amount ?? 0),
            shipping_charges: (float) ($request->shipping_charges ?? 0),
            commission: (float) ($request->commission ?? 0),
            notes: $request->notes,
            terms_and_conditions: $request->terms_and_conditions,
            payment_terms: $request->payment_terms ?? 'Net 15',
            logistics_details: $request->logistics_details,
            estimated_delivery_date: $request->estimated_delivery_date,
            items: $items,
            status: $request->status ?? 'draft',
        );

        $invoice = $this->invoiceService->createProforma($invoiceData);

        return response()->json([
            'success' => true,
            'message' => 'Proforma invoice #' . $invoice->invoice_number . ' created successfully!',
            'data' => new InvoiceResource($invoice->load('items', 'client')),
        ], 201);
    }

    /**
     * Show proforma invoice.
     */
    public function show(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->invoiceService->getInvoice($id, $companyId);

        if (!$invoice || $invoice->invoice_type !== 'proforma') {
            return response()->json([
                'success' => false,
                'message' => 'Proforma invoice not found.',
            ], 404);
        }

        Gate::authorize('view', $invoice);

        return response()->json([
            'success' => true,
            'data' => new InvoiceResource($invoice->load('items', 'client', 'company')),
        ]);
    }

    /**
     * Update proforma.
     */
    public function update(UpdateProformaRequest $request, int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->invoiceService->getInvoice($id, $companyId);

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
                gst_rate: (float) ($item['gst_rate'] ?? 18.00),
                discount_type: $item['discount_type'] ?? null,
                discount_value: (float) ($item['discount_value'] ?? 0),
                taxable_amount: (float) ($item['unit_price'] * $item['quantity']),
            );
        })->toArray();

        $invoiceData = new InvoiceData(
            company_id: $companyId,
            client_id: (int) $request->client_id,
            created_by: Auth::id(),
            invoice_type: 'proforma',
            gst_mode: 'exclusive',
            gst_rate: 18.00,
            invoice_date: $request->invoice_date,
            due_date: $request->due_date,
            reference_number: $request->reference_number,
            discount_type: $request->discount_type,
            discount_amount: (float) ($request->discount_amount ?? 0),
            shipping_charges: (float) ($request->shipping_charges ?? 0),
            commission: (float) ($request->commission ?? 0),
            notes: $request->notes,
            terms_and_conditions: $request->terms_and_conditions,
            payment_terms: $request->payment_terms ?? 'Net 15',
            logistics_details: $request->logistics_details,
            estimated_delivery_date: $request->estimated_delivery_date,
            items: $items,
            updated_by: Auth::id(),
        );

        $this->invoiceService->updateProforma($id, $invoiceData);

        return response()->json([
            'success' => true,
            'message' => 'Proforma invoice updated successfully!',
            'data' => new InvoiceResource($invoice->fresh()->load('items', 'client')),
        ]);
    }

    /**
     * Delete proforma.
     */
    public function destroy(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->invoiceService->getInvoice($id, $companyId);

        if (!$invoice || !$invoice->isDeletable()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this invoice.',
            ], 422);
        }

        Gate::authorize('delete', $invoice);

        Log::warning('Invoice deleted via API', [
            'user_id' => Auth::id(),
            'invoice_number' => $invoice->invoice_number,
            'invoice_type' => $invoice->invoice_type,
            'company_id' => $companyId,
        ]);

        $this->invoiceService->deleteProforma($id);

        return response()->json([
            'success' => true,
            'message' => 'Proforma invoice deleted.',
        ]);
    }

    /**
     * Convert proforma to GST invoice (stub).
     */
    public function convertToGst(int $id): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Conversion to GST invoice is handled via GST Invoice module.',
        ], 400);
    }

    /**
     * Download PDF.
     */
    public function pdf(int $id)
    {
        $companyId = session('current_company_id');
        $invoice = $this->invoiceService->getInvoice($id, $companyId);
        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }
        $pdf = Pdf::loadView('proformas.pdf', compact('invoice'));
        return $pdf->download('Proforma-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Stream PDF preview.
     */
    public function stream(int $id)
    {
        $companyId = session('current_company_id');
        $invoice = $this->invoiceService->getInvoice($id, $companyId);
        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }
        $pdf = Pdf::loadView('proformas.pdf', compact('invoice'));
        return $pdf->stream('Proforma-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Send invoice via email.
     */
    public function sendEmail(int $id): JsonResponse
    {
        $companyId = session('current_company_id');
        $invoice = $this->invoiceService->getInvoice($id, $companyId);

        if (!$invoice || !$invoice->client->email) {
            return response()->json([
                'success' => false,
                'message' => 'Client email not found.',
            ], 422);
        }

        Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));

        Log::info('Invoice emailed via API', [
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
