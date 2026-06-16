<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                GST Invoice #{{ $invoice->invoice_number }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('gst-invoices.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm">
                    &larr; Back
                </a>
                @if($invoice->isEditable())
                <a href="{{ route('gst-invoices.edit', $invoice->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
                    Edit
                </a>
                @endif
                <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
                    Print
                </button>

                <a href="{{ route('gst-invoices.pdf', $invoice->id) }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                    📥 Download PDF
                </a>

                @if($invoice->status === 'draft')
                <form action="{{ route('gst-invoices.destroy', $invoice->id) }}" method="POST"
                    onsubmit="return confirm('Delete this invoice?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                        Delete
                    </button>
                </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 print:py-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Status Bar -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="px-3 py-1 text-sm rounded-full 
                            @if($invoice->status === 'draft') bg-gray-100 text-gray-800
                            @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800
                            @elseif($invoice->status === 'paid') bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($invoice->status) }}
                        </span>
                        <span class="px-3 py-1 text-xs rounded-full 
                            {{ $invoice->igst_amount > 0 ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $invoice->igst_amount > 0 ? 'IGST' : 'CGST + SGST' }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-600">
                        Mode: <strong>{{ ucfirst($invoice->gst_mode) }}</strong>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 print:shadow-none print:border">
                <div class="p-6">

                    <!-- Header -->
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">GST INVOICE</h3>
                            <p class="text-sm text-gray-500">{{ $invoice->invoice_number }}</p>
                            @if($invoice->reference_number)
                            <p class="text-sm text-gray-500">Ref: {{ $invoice->reference_number }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500 mb-1">Date: {{ $invoice->invoice_date->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">Due: {{ $invoice->due_date->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500 mt-2">
                                Place of Supply: {{ $invoice->place_of_supply_state_code ?? 'N/A' }}
                                ({{ $invoice->place_of_supply === 'intra_state' ? 'Intra-State' : 'Inter-State' }})
                            </div>
                        </div>
                    </div>

                    <!-- Company & Client Info -->
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">From:</h4>
                            <p class="text-sm font-medium">{{ $invoice->company->name }}</p>
                            <p class="text-sm text-gray-500">{{ $invoice->company->address_line_1 }}</p>
                            <p class="text-sm text-gray-500">{{ $invoice->company->city }}, {{ $invoice->company->state }} - {{ $invoice->company->pincode }}</p>
                            <p class="text-sm text-gray-500">GSTIN: {{ $invoice->company->gstin }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">To:</h4>
                            <p class="text-sm font-medium">{{ $invoice->client->name }}</p>
                            @if($invoice->client->address_line_1)
                            <p class="text-sm text-gray-500">{{ $invoice->client->address_line_1 }}</p>
                            <p class="text-sm text-gray-500">{{ $invoice->client->city }}, {{ $invoice->client->state }} - {{ $invoice->client->pincode }}</p>
                            @endif
                            <p class="text-sm text-gray-500">GSTIN: {{ $invoice->client->gstin }}</p>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Item</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">HSN/SAC</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Rate</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">GST</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoice->items as $index => $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $item->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $item->hsn_sac_code ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-center">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm text-right">₹{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-center">{{ $item->gst_rate }}%</td>
                                    <td class="px-4 py-3 text-sm text-right font-medium">₹{{ number_format($item->line_total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tax Breakdown & Totals -->
                    <div class="flex justify-end">
                        <div class="w-96">
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600">Subtotal:</span>
                                <span class="text-sm">₹{{ number_format($invoice->subtotal, 2) }}</span>
                            </div>

                            @if($invoice->discount_amount > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600">Discount @if($invoice->discount_type === 'percentage') ({{ $invoice->discount_amount }}%) @endif:</span>
                                <span class="text-sm text-red-600">- ₹{{ number_format($invoice->discount_amount, 2) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between py-2 border-t border-dashed border-gray-300">
                                <span class="text-sm text-gray-600">Taxable Amount:</span>
                                <span class="text-sm">₹{{ number_format($invoice->taxable_amount, 2) }}</span>
                            </div>

                            @if($invoice->igst_amount > 0)
                            <div class="flex justify-between py-2 bg-purple-50 dark:bg-purple-900 px-2 rounded">
                                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">IGST ({{ $invoice->gst_rate }}%):</span>
                                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">₹{{ number_format($invoice->igst_amount, 2) }}</span>
                            </div>
                            @else
                            <div class="flex justify-between py-2 bg-blue-50 dark:bg-blue-900 px-2 rounded">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">CGST ({{ $invoice->gst_rate/2 }}%):</span>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">₹{{ number_format($invoice->cgst_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2 bg-blue-50 dark:bg-blue-900 px-2 rounded">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">SGST ({{ $invoice->gst_rate/2 }}%):</span>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">₹{{ number_format($invoice->sgst_amount, 2) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600">Total GST:</span>
                                <span class="text-sm font-medium">₹{{ number_format($invoice->total_gst_amount, 2) }}</span>
                            </div>

                            @if($invoice->shipping_charges > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600">Shipping:</span>
                                <span class="text-sm">₹{{ number_format($invoice->shipping_charges, 2) }}</span>
                            </div>
                            @endif
                            @if($invoice->commission > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600">Commission:</span>
                                <span class="text-sm">₹{{ number_format($invoice->commission, 2) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between py-3 border-t-2 border-gray-400">
                                <span class="text-lg font-bold">Grand Total:</span>
                                <span class="text-lg font-bold">₹{{ number_format($invoice->grand_total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reverse Charge Notice -->
                    @if($invoice->reverse_charge)
                    <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                        <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            ⚠️ Reverse Charge Mechanism (RCM) Applied - Tax payable by recipient
                        </p>
                    </div>
                    @endif

                    <!-- Signature -->
                    <div class="mt-12 flex justify-end">
                        <div class="text-center">
                            <div class="border-b border-gray-300 w-48 mb-2"></div>
                            <p class="text-sm text-gray-500">Authorized Signature</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .py-12,
            .py-12 * {
                visibility: visible;
            }

            .py-12 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 0 !important;
            }

            .print\\:py-0 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

            .print\\:shadow-none {
                box-shadow: none !important;
            }

            .print\\:border {
                border: 1px solid #e5e7eb !important;
            }

            button,
            .no-print {
                display: none !important;
            }

            header,
            nav {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
