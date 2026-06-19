@extends('layouts.super-admin')
@section('page-title', 'Proforma #' . $invoice->invoice_number)

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Proforma #{{ $invoice->invoice_number }}</h2>
            <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">{{ ucfirst($invoice->status) }}</span>
        </div>
        <dl class="grid grid-cols-2 gap-3 text-sm">
            <div><span class="text-gray-500">Company</span><br>{{ $invoice->company->name ?? '—' }}</div>
            <div><span class="text-gray-500">Client</span><br>{{ $invoice->client->name ?? '—' }}</div>
            <div><span class="text-gray-500">Date</span><br>{{ $invoice->invoice_date->format('d M Y') }}</div>
            <div><span class="text-gray-500">Amount</span><br>₹{{ number_format($invoice->grand_total, 2) }}</div>
        </dl>
    </div>
    <a href="{{ route('super-admin.proformas') }}" class="text-indigo-600 hover:underline text-sm">← Back to Proformas</a>
</div>
@endsection