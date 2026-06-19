@extends('layouts.super-admin')
@section('page-title', 'Invoices — ' . $company->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('super-admin.companies.show', $company) }}" class="text-gray-500 hover:text-gray-700">← Back to Company</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center font-bold">{{ strtoupper(substr($company->name, 0, 2)) }}</div>
            <div>
                <h2 class="text-lg font-bold">{{ $company->name }}</h2>
                <p class="text-sm text-gray-500">All Invoices</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-xs text-gray-500 uppercase">Total Invoices</p>
            <p class="text-2xl font-bold">{{ $invoices->count() ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-xs text-gray-500 uppercase">Total Revenue</p>
            <p class="text-2xl font-bold text-green-600">₹{{ number_format($invoices->sum('grand_total') ?? 0, 0) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-xs text-gray-500 uppercase">Paid</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $invoices->where('status', 'paid')->count() ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-xs text-gray-500 uppercase">Overdue</p>
            <p class="text-2xl font-bold text-red-600">{{ $invoices->where('status', 'overdue')->count() ?? 0 }}</p>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">Invoice #</th>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">GST</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices ?? [] as $invoice)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $invoice->invoice_number }}</td>
                    <td class="px-4 py-3 text-xs">{{ $invoice->client->name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $invoice->invoice_type === 'gst_invoice' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $invoice->invoice_type === 'gst_invoice' ? 'GST' : 'Proforma' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">₹{{ number_format($invoice->grand_total, 2) }}</td>
                    <td class="px-4 py-3 text-xs">₹{{ number_format($invoice->total_gst_amount, 2) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full 
                            {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $invoice->status === 'overdue' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $invoice->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $invoice->status === 'sent' ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $invoice->invoice_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('super-admin.invoices.show', $invoice) }}" class="text-indigo-600 hover:underline text-xs">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">No invoices found for this company.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection