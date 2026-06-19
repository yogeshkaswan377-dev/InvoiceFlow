<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('company', 'client')->latest()->paginate(20);
        return view('super-admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('company', 'client', 'items');
        return view('super-admin.invoices.show', compact('invoice'));
    }
}
