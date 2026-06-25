@extends('layouts.super-admin')

@section('title', 'All Invoices')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Platform Invoices</h1>
        <p class="text-xs text-gray-500 mt-1">All GST invoices across all tenants.</p>
    </div>
    <div class="flex items-center gap-2">
        <select class="px-3 py-1.5 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
            <option>All Status</option>
            <option>Paid</option>
            <option>Pending</option>
            <option>Overdue</option>
        </select>
        <input type="text" placeholder="Search invoice..." class="px-3 py-1.5 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500 w-40 transition">
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4">Invoice #</th>
                    <th class="px-6 py-4">Company</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 text-gray-600">
                @forelse($invoices ?? [] as $invoice)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $invoice->invoice_number }}</td>
                    <td class="px-6 py-4">{{ $invoice->company->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $invoice->client->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 font-semibold">₹{{ number_format($invoice->grand_total ?? 0) }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-xs font-medium {{ $invoice->status === 'paid' ? 'text-emerald-700 bg-emerald-50' : 'text-amber-700 bg-amber-50' }} px-2.5 py-0.5 rounded-full ring-1 {{ $invoice->status === 'paid' ? 'ring-emerald-600/10' : 'ring-amber-600/10' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $invoice->created_at?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="/super-admin/invoices/{{ $invoice->id }}" class="p-2 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-50 transition">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">No invoices found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection