<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class ProformaController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('invoice_type', 'proforma')->with('company', 'client')->latest()->paginate(20);
        return view('super-admin.proformas.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('company', 'client', 'items');
        return view('super-admin.proformas.show', compact('invoice'));
    }
}
