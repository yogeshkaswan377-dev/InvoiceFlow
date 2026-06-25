@extends('layouts.super-admin')

@section('title', 'Invoice Details')

@section('content')
<div class="mb-6">
    <a href="/super-admin/invoices" class="text-sm text-indigo-600 hover:text-indigo-700">
        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Invoices
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Invoice #{{ $invoice->invoice_number ?? 'INV-001' }}</h3>
            <p class="text-xs text-gray-500 mt-0.5">Created {{ $invoice->created_at?->format('d M Y') ?? 'N/A' }}</p>
        </div>
        <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full ring-1 ring-emerald-600/10">
            {{ ucfirst($invoice->status ?? 'Paid') }}
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-gray-50 rounded-xl">
            <span class="text-xs font-bold uppercase text-gray-400">Amount</span>
            <h4 class="text-xl font-bold text-gray-900">₹{{ number_format($invoice->grand_total ?? 0) }}</h4>
        </div>
        <div class="p-4 bg-gray-50 rounded-xl">
            <span class="text-xs font-bold uppercase text-gray-400">Company</span>
            <h4 class="text-sm font-semibold text-gray-900">{{ $invoice->company->name ?? 'N/A' }}</h4>
        </div>
        <div class="p-4 bg-gray-50 rounded-xl">
            <span class="text-xs font-bold uppercase text-gray-400">Client</span>
            <h4 class="text-sm font-semibold text-gray-900">{{ $invoice->client->name ?? 'N/A' }}</h4>
        </div>
        <div class="p-4 bg-gray-50 rounded-xl">
            <span class="text-xs font-bold uppercase text-gray-400">GSTIN</span>
            <h4 class="text-sm font-semibold text-gray-900 font-mono">{{ $invoice->company->gstin ?? 'N/A' }}</h4>
        </div>
    </div>
</div>
@endsection