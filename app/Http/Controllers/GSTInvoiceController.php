<?php

namespace App\Http\Controllers;

use App\DTOs\InvoiceData;
use App\DTOs\InvoiceItemData;
use App\Http\Requests\StoreProformaRequest;
use App\Http\Requests\UpdateProformaRequest;
use App\Models\Client;
use App\Models\Company;
use App\Services\Invoice\GSTInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GSTInvoiceController extends Controller
{
    public function __construct(
        private GSTInvoiceService $gstInvoiceService
    ) {}

    public function index(Request $request)
    {
        $companyId = Auth::user()->current_company_id;
        $filters = $request->only(['status', 'date_from', 'date_to', 'search', 'client_id']);
        $invoices = $this->gstInvoiceService->listGSTInvoices($companyId, $filters);
        return view('gst-invoices.index', compact('invoices', 'filters'));
    }

    public function create()
    {
        $company = Company::find(Auth::user()->current_company_id);
        $clients = Client::where('company_id', $company->id)->where('status', 'active')->get();
        return view('gst-invoices.create', compact('company', 'clients'));
    }

    public function store(StoreProformaRequest $request)
    {
        $companyId = Auth::user()->current_company_id;

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

        return redirect()->route('gst-invoices.show', $invoice->id)
            ->with('success', 'GST Invoice created!');
    }

    public function show(int $id)
    {
        $companyId = Auth::user()->current_company_id;
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice || $invoice->invoice_type !== 'gst_invoice') {
            abort(404);
        }

        return view('gst-invoices.show', compact('invoice'));
    }

    public function edit(int $id)
    {
        $companyId = Auth::user()->current_company_id;
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice || !$invoice->isEditable()) {
            abort(404);
        }

        $company = Company::find($companyId);
        $clients = Client::where('company_id', $companyId)->where('status', 'active')->get();

        return view('gst-invoices.edit', compact('invoice', 'company', 'clients'));
    }

    public function update(UpdateProformaRequest $request, int $id)
    {
        $companyId = Auth::user()->current_company_id;

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

        return redirect()->route('gst-invoices.show', $id)
            ->with('success', 'GST Invoice updated!');
    }

    public function destroy(int $id)
    {
        $companyId = Auth::user()->current_company_id;
        $invoice = $this->gstInvoiceService->getInvoice($id, $companyId);

        if (!$invoice || !$invoice->isDeletable()) {
            return back()->with('error', 'Cannot delete this invoice.');
        }

        $this->gstInvoiceService->deleteGSTInvoice($id);

        return redirect()->route('gst-invoices.index')
            ->with('success', 'GST Invoice deleted.');
    }
}
