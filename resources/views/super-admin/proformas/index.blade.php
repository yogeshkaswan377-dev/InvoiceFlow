@extends('layouts.super-admin')
@section('page-title', 'All Proformas')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <h2 class="font-semibold text-lg">All Proforma Invoices</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">Invoice #</th>
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $invoice->invoice_number }}</td>
                    <td class="px-4 py-3 text-xs">{{ $invoice->company->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-xs">{{ $invoice->client->name ?? '—' }}</td>
                    <td class="px-4 py-3">₹{{ number_format($invoice->grand_total, 2) }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800">{{ ucfirst($invoice->status) }}</span></td>
                    <td class="px-4 py-3 text-xs">{{ $invoice->invoice_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <a href="/super-admin/proformas/{{ $invoice->id }}" class="text-indigo-600 hover:underline text-xs">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">No proformas found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $invoices->links() }}</div>
</div>
@endsection