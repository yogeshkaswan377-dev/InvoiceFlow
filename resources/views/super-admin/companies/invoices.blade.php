@extends('layouts.super-admin')

@section('title', 'Company Invoices')

@section('content')
<div class="mb-6">
    <a href="/super-admin/companies/{{ $company->id ?? 1 }}" class="text-sm text-indigo-600 hover:text-indigo-700">
        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Company
    </a>
</div>

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">{{ $company->name ?? 'Company' }} — Invoices</h1>
        <p class="text-xs text-gray-500 mt-1">All invoices issued by this tenant.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4">Invoice #</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Date</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 text-gray-600">
                @forelse($invoices ?? [] as $invoice)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $invoice->invoice_number }}</td>
                    <td class="px-6 py-4">{{ $invoice->client->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 font-semibold">₹{{ number_format($invoice->grand_total ?? 0) }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-xs font-medium {{ $invoice->status === 'paid' ? 'text-emerald-700 bg-emerald-50' : 'text-amber-700 bg-amber-50' }} px-2.5 py-0.5 rounded-full ring-1 {{ $invoice->status === 'paid' ? 'ring-emerald-600/10' : 'ring-amber-600/10' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $invoice->created_at?->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">No invoices found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection