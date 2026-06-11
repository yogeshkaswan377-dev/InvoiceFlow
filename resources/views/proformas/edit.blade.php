<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Proforma #{{ $invoice->invoice_number }}
            </h2>
            <a href="{{ route('proformas.show', $invoice->id) }}" class="text-gray-500 hover:text-gray-700">
                ← Back to Invoice
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('proformas.update', $invoice->id) }}" method="POST" x-data="invoiceBuilder()">
                @csrf
                @method('PUT')

                <!-- Header Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client *</label>
                                    <select name="client_id" required
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }} {{ $client->gstin ? '(GST: ' . $client->gstin . ')' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('client_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reference Number</label>
                                    <input type="text" name="reference_number" value="{{ old('reference_number', $invoice->reference_number) }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Invoice Date *</label>
                                        <input type="date" name="invoice_date" required
                                            value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Due Date *</label>
                                        <input type="date" name="due_date" required
                                            value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Terms</label>
                                    <select name="payment_terms" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                        @foreach(['Net 7', 'Net 15', 'Net 30', 'Net 45', 'Net 60', 'Immediate'] as $term)
                                        <option value="{{ $term }}" {{ old('payment_terms', $invoice->payment_terms) == $term ? 'selected' : '' }}>
                                            {{ $term }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estimated Delivery Date</label>
                                    <input type="date" name="estimated_delivery_date"
                                        value="{{ old('estimated_delivery_date', $invoice->estimated_delivery_date?->format('Y-m-d')) }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('notes', $invoice->notes) }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Terms & Conditions</label>
                                    <textarea name="terms_and_conditions" rows="3"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('terms_and_conditions', $invoice->terms_and_conditions) }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logistics Details</label>
                                    <textarea name="logistics_details" rows="2"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('logistics_details', $invoice->logistics_details) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Items</h3>
                            <button type="button" @click="addItem()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                                + Add Item
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 w-5">#</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Item Name</th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 w-20">Qty</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 w-28">Unit Price</th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 w-24">GST %</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 w-28">Line Total</th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 w-16">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <td class="px-3 py-2 text-sm text-gray-500" x-text="index + 1"></td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="item.name" :name="'items['+index+'][name]'"
                                                    required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" x-model="item.quantity" :name="'items['+index+'][quantity]'"
                                                    min="1" required @input="calculateItemTotal(index)"
                                                    class="w-full text-center rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" x-model="item.unit_price" :name="'items['+index+'][unit_price]'"
                                                    min="0" step="0.01" required @input="calculateItemTotal(index)"
                                                    class="w-full text-right rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <select x-model="item.gst_rate" :name="'items['+index+'][gst_rate]'"
                                                    @change="calculateItemTotal(index)"
                                                    class="w-full text-center rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                                                    <option value="0">0%</option>
                                                    <option value="5">5%</option>
                                                    <option value="12">12%</option>
                                                    <option value="18">18%</option>
                                                    <option value="28">28%</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2 text-right text-sm font-medium" x-text="formatCurrency(item.line_total)"></td>
                                            <td class="px-3 py-2 text-center">
                                                <button type="button" @click="removeItem(index)"
                                                    class="text-red-600 hover:text-red-900 text-sm">✕</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Totals Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount Type</label>
                                    <select name="discount_type" x-model="discountType" @change="calculateTotals()"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                        <option value="">No Discount</option>
                                        <option value="percentage">Percentage (%)</option>
                                        <option value="fixed">Fixed Amount (₹)</option>
                                    </select>
                                </div>
                                <div class="mb-4" x-show="discountType">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount Value</label>
                                    <input type="number" name="discount_amount" x-model="discountAmount"
                                        min="0" step="0.01" @input="calculateTotals()"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shipping Charges</label>
                                    <input type="number" name="shipping_charges" x-model="shippingCharges"
                                        min="0" step="0.01" @input="calculateTotals()"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Commission</label>
                                    <input type="number" name="commission" x-model="commission"
                                        min="0" step="0.01" @input="calculateTotals()"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal:</span>
                                    <span class="text-sm font-medium" x-text="formatCurrency(subtotal)"></span>
                                </div>
                                <div class="flex justify-between mb-2" x-show="discountAmount > 0">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Discount:</span>
                                    <span class="text-sm font-medium text-red-600">- ₹<span x-text="discountAmount"></span></span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Taxable Amount:</span>
                                    <span class="text-sm font-medium" x-text="formatCurrency(taxableAmount)"></span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">GST (approx):</span>
                                    <span class="text-sm font-medium" x-text="formatCurrency(totalGst)"></span>
                                </div>
                                <div class="flex justify-between mb-2" x-show="shippingCharges > 0">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Shipping:</span>
                                    <span class="text-sm font-medium">₹<span x-text="shippingCharges"></span></span>
                                </div>
                                <div class="flex justify-between mb-2" x-show="commission > 0">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Commission:</span>
                                    <span class="text-sm font-medium">₹<span x-text="commission"></span></span>
                                </div>
                                <hr class="my-2 border-gray-300 dark:border-gray-600">
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-gray-800 dark:text-gray-200">Grand Total:</span>
                                    <span class="text-gray-800 dark:text-gray-200" x-text="formatCurrency(grandTotal)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('proformas.show', $invoice->id) }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        Update Proforma
                    </button>
                </div>
            </form>

        </div>
    </div>

    @php
        $invoiceItems = $invoice->items->map(function ($item) {
            return [
                'name' => $item->name,
                'quantity' => (float) $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'gst_rate' => (float) $item->gst_rate,
                'line_total' => (float) $item->line_total,
            ];
        })->values();
    @endphp

    <!-- Alpine.js Component with existing data -->
    <script>
        function invoiceBuilder() {
            return {
                items: @json($invoiceItems),

                discountType: @json($invoice->discount_type),
                discountAmount: @json($invoice->discount_amount ?? 0),
                shippingCharges: @json($invoice->shipping_charges ?? 0),
                commission: @json($invoice->commission ?? 0),

                subtotal: @json($invoice->subtotal ?? 0),
                taxableAmount: @json($invoice->taxable_amount ?? 0),
                totalGst: @json($invoice->total_gst_amount ?? 0),
                grandTotal: @json($invoice->grand_total ?? 0),

                init() {
                    this.calculateTotals();
                },

                addItem() {
                    this.items.push({
                        name: '',
                        quantity: 1,
                        unit_price: 0,
                        gst_rate: 18,
                        line_total: 0
                    });

                    this.calculateTotals();
                },

                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                        this.calculateTotals();
                    }
                },

                calculateItemTotal(index) {
                    const item = this.items[index];
                    item.line_total = item.quantity * item.unit_price;
                    this.calculateTotals();
                },

                calculateTotals() {
                    this.subtotal = this.items.reduce((sum, item) => {
                        return sum + ((parseFloat(item.quantity) || 0) * (parseFloat(item.unit_price) || 0));
                    }, 0);

                    let discountAmount = parseFloat(this.discountAmount) || 0;

                    if (this.discountType === 'percentage' && discountAmount > 0) {
                        discountAmount = this.subtotal * (discountAmount / 100);
                    }

                    this.taxableAmount = this.subtotal - discountAmount;

                    let avgGstRate = 18;

                    if (this.items.length > 0) {
                        avgGstRate = this.items.reduce((sum, item) => {
                            return sum + (parseFloat(item.gst_rate) || 0);
                        }, 0) / this.items.length;
                    }

                    this.totalGst = this.taxableAmount * (avgGstRate / 100);

                    const shipping = parseFloat(this.shippingCharges) || 0;
                    const comm = parseFloat(this.commission) || 0;

                    this.grandTotal = this.taxableAmount + this.totalGst + shipping + comm;
                },

                formatCurrency(amount) {
                    return '₹' + parseFloat(amount || 0)
                        .toFixed(2)
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }
            };
        }
    </script>
</x-app-layout>
