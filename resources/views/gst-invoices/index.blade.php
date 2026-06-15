<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                GST Invoices
            </h2>
            <a href="{{ route('gst-invoices.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                + New GST Invoice
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(isset($invoices) && method_exists($invoices, 'count') && $invoices->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice #</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">GST</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoices as $invoice)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3 text-sm font-medium text-blue-600">
                                        <a href="{{ route('gst-invoices.show', $invoice->id) }}" class="hover:underline">
                                            {{ $invoice->invoice_number }}
                                        </a>
                                    </td>
                                    {{ optional($invoice->client)->name ?? 'N/A' }}
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $invoice->invoice_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-right font-medium">₹{{ number_format($invoice->grand_total, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span class="text-xs px-2 py-1 rounded {{ $invoice->igst_amount > 0 ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $invoice->igst_amount > 0 ? 'IGST' : 'CGST+SGST' }} ₹{{ number_format($invoice->total_gst_amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($invoice->status === 'draft') bg-gray-100 text-gray-800
                                                    @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800
                                                    @elseif($invoice->status === 'paid') bg-green-100 text-green-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right space-x-2">
                                        <a href="{{ route('gst-invoices.show', $invoice->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        @if($invoice->isEditable())
                                        <a href="{{ route('gst-invoices.edit', $invoice->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center py-12">
                    <p class="text-gray-500 text-lg mb-4">No GST invoices found</p>
                    <a href="{{ route('gst-invoices.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg">
                        Create Your First GST Invoice
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>