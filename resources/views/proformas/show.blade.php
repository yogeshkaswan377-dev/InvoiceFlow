<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Proforma Invoice #{{ $invoice->invoice_number }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('proformas.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm">
                    ← Back
                </a>
                @if($invoice->isEditable())
                <a href="{{ route('proformas.edit', $invoice->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
                    Edit
                </a>
                @endif
                <button onclick="window.print()"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">

                </button>
                @if($invoice->status === 'draft')
                <form action="{{ route('proformas.destroy', $invoice->id) }}" method="POST"
                    onsubmit="return confirm('Delete this proforma?')">
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
                            @elseif($invoice->status === 'accepted') bg-green-100 text-green-800
                            @elseif($invoice->status === 'paid') bg-emerald-100 text-emerald-800
                            @elseif($invoice->status === 'cancelled') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Created: {{ $invoice->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 print:shadow-none print:border">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">PROFORMA INVOICE</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->invoice_number }}</p>
                            @if($invoice->reference_number)
                            <p class="text-sm text-gray-500 dark:text-gray-400">Ref: {{ $invoice->reference_number }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Date: {{ $invoice->invoice_date->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Due: {{ $invoice->due_date->format('d M Y') }}</div>
                        </div>
                    </div>

                    <!-- Company & Client Info -->
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">From:</h4>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $invoice->company->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->company->address_line_1 }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->company->city }}, {{ $invoice->company->state }} - {{ $invoice->company->pincode }}</p>
                            @if($invoice->company->gstin)
                            <p class="text-sm text-gray-500 dark:text-gray-400">GSTIN: {{ $invoice->company->gstin }}</p>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">To:</h4>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $invoice->client->name }}</p>
                            @if($invoice->client->address_line_1)
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->client->address_line_1 }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->client->city }}, {{ $invoice->client->state }} - {{ $invoice->client->pincode }}</p>
                            @endif
                            @if($invoice->client->gstin)
                            <p class="text-sm text-gray-500 dark:text-gray-400">GSTIN: {{ $invoice->client->gstin }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Item</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300">Rate</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300">GST</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoice->items as $index => $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                        {{ $item->name }}
                                        @if($item->description)
                                        <p class="text-xs text-gray-400">{{ $item->description }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-500 dark:text-gray-400">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-800 dark:text-gray-200">₹{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-center text-gray-500 dark:text-gray-400">{{ $item->gst_rate }}%</td>
                                    <td class="px-4 py-3 text-sm text-right font-medium text-gray-800 dark:text-gray-200">₹{{ number_format($item->line_total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="flex justify-end">
                        <div class="w-80">
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span class="text-sm text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            @if($invoice->discount_amount > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    Discount
                                    @if($invoice->discount_type === 'percentage')
                                    ({{ $invoice->discount_amount }}%)
                                    @endif:
                                </span>
                                <span class="text-sm text-red-600">- ₹{{ number_format($invoice->discount_amount, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Taxable Amount:</span>
                                <span class="text-sm text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->taxable_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-t border-dashed border-gray-300 dark:border-gray-600">
                                <span class="text-sm text-gray-600 dark:text-gray-400">CGST:</span>
                                <span class="text-sm text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->cgst_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">SGST:</span>
                                <span class="text-sm text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->sgst_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Total GST:</span>
                                <span class="text-sm text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->total_gst_amount, 2) }}</span>
                            </div>
                            @if($invoice->shipping_charges > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Shipping:</span>
                                <span class="text-sm text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->shipping_charges, 2) }}</span>
                            </div>
                            @endif
                            @if($invoice->commission > 0)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Commission:</span>
                                <span class="text-sm text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->commission, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between py-3 border-t-2 border-gray-400 dark:border-gray-500">
                                <span class="text-lg font-bold text-gray-800 dark:text-gray-200">Grand Total:</span>
                                <span class="text-lg font-bold text-gray-800 dark:text-gray-200">₹{{ number_format($invoice->grand_total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Terms -->
                    @if($invoice->payment_terms || $invoice->notes || $invoice->terms_and_conditions)
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        @if($invoice->payment_terms)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <strong>Payment Terms:</strong> {{ $invoice->payment_terms }}
                        </p>
                        @endif
                        @if($invoice->notes)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <strong>Notes:</strong> {{ $invoice->notes }}
                        </p>
                        @endif
                        @if($invoice->terms_and_conditions)
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                            <strong>Terms & Conditions:</strong>
                            <p>{{ $invoice->terms_and_conditions }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Signature Area -->
                    <div class="mt-12 flex justify-end">
                        <div class="text-center">
                            <div class="border-b border-gray-300 dark:border-gray-600 w-48 mb-2"></div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Authorized Signature</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Print Styles -->
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
                margin: 0 !important;
            }

            .print\:py-0 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

            .print\:shadow-none {
                box-shadow: none !important;
            }

            .print\:border {
                border: 1px solid #e5e7eb !important;
            }

            button,
            .no-print {
                display: none !important;
            }

            header,
            nav,
            .bg-white>.p-4:first-child {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
