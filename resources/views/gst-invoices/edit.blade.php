@"
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit GST Invoice #{{ $invoice->invoice_number }}
            </h2>
            <a href="{{ route('gst-invoices.show', $invoice->id) }}" class="text-gray-500 hover:text-gray-700">
                &larr; Back to Invoice
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('gst-invoices.update', $invoice->id) }}" method="POST" x-data="gstInvoiceBuilder()">
                @csrf
                @method('PUT')

                <!-- Header Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client *</label>
                                    <select name="client_id" required x-on:change="fetchClientState()"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                        <option value="{{ $client->id }}" data-state="{{ $client->state_code }}"
                                            {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }} {{ $client->gstin ? '(GST: '.$client->gstin.')' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
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

                                <!-- GST Mode Toggle -->
                                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GST Mode</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="gst_mode" value="exclusive" x-model="gstMode"
                                                {{ $invoice->gst_mode === 'exclusive' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm">Exclusive (GST extra)</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="gst_mode" value="inclusive" x-model="gstMode"
                                                {{ $invoice->gst_mode === 'inclusive' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm">Inclusive (GST included)</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Tax Type Display -->
                                <div class="mb-4 p-3 rounded-lg"
                                    x-bind:class="taxType === 'igst' ? 'bg-purple-50 dark:bg-purple-900' : 'bg-blue-50 dark:bg-blue-900'">
                                    <span class="text-sm font-medium" x-text="taxType === 'igst' ? 'IGST (Inter-State)' : 'CGST + SGST (Intra-State)'"></span>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="reverse_charge" value="1"
                                            {{ $invoice->reverse_charge ? 'checked' : '' }} class="rounded border-gray-300">
                                        <span class="ml-2 text-sm">Reverse Charge (RCM)</span>
                                    </label>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ old('notes', $invoice->notes) }}</textarea>
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
                            <button type="button" x-on:click="addItem()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                                + Add Item
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 py-2 text-xs font-medium text-gray-500 w-5">#</th>
                                        <th class="px-3 py-2 text-xs font-medium text-gray-500">Item / HSN</th>
                                        <th class="px-3 py-2 text-xs font-medium text-gray-500 w-20 text-center">Qty</th>
                                        <th class="px-3 py-2 text-xs font-medium text-gray-500 w-28 text-right">Price</th>
                                        <th class="px-3 py-2 text-xs font-medium text-gray-500 w-24 text-center">GST%</th>
                                        <th class="px-3 py-2 text-xs font-medium text-gray-500 w-28 text-right">Total</th>
                                        <th class="px-3 py-2 text-xs font-medium text-gray-500 w-16"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <td class="px-3 py-2 text-sm text-gray-500" x-text="index + 1"></td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="item.name" :name="'items['+index+'][name]'" required placeholder="Item name"
                                                    class="w-full rounded-md border-gray-300 text-sm mb-1">
                                                <input type="text" x-model="item.hsn_sac_code" :name="'items['+index+'][hsn_sac_code]'" placeholder="HSN/SAC"
                                                    class="w-full rounded-md border-gray-300 text-xs">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" x-model="item.quantity" :name="'items['+index+'][quantity]'" min="1" required
                                                    x-on:input="calculateItemTotal(index)" class="w-full text-center rounded-md border-gray-300 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" x-model="item.unit_price" :name="'items['+index+'][unit_price]'" min="0" step="0.01" required
                                                    x-on:input="calculateItemTotal(index)" class="w-full text-right rounded-md border-gray-300 text-sm">
                                            </td>
                                            <td class="px-3 py-2">
                                                <select x-model="item.gst_rate" :name="'items['+index+'][gst_rate]'" x-on:change="calculateItemTotal(index)"
                                                    class="w-full text-center rounded-md border-gray-300 text-sm">
                                                    <option value="0">0%</option>
                                                    <option value="5">5%</option>
                                                    <option value="12">12%</option>
                                                    <option value="18">18%</option>
                                                    <option value="28">28%</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2 text-right text-sm font-medium" x-text="formatCurrency(item.line_total)"></td>
                                            <td class="px-3 py-2 text-center">
                                                <button type="button" x-on:click="removeItem(index)" class="text-red-600 hover:text-red-900 text-sm">&times;</button>
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
                                    <select name="discount_type" x-model="discountType" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                        <option value="">No Discount</option>
                                        <option value="percentage">Percentage (%)</option>
                                        <option value="fixed">Fixed Amount (₹)</option>
                                    </select>
                                </div>
                                <div class="mb-4" x-show="discountType">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount Value</label>
                                    <input type="number" name="discount_amount" x-model="discountAmount" min="0" step="0.01"
                                        x-on:input="calculateTotals()" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shipping Charges</label>
                                    <input type="number" name="shipping_charges" x-model="shippingCharges" min="0" step="0.01"
                                        x-on:input="calculateTotals()" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                </div>
                            </div>

                            <!-- Tax Breakdown -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm">Subtotal:</span>
                                    <span class="text-sm font-medium" x-text="formatCurrency(subtotal)"></span>
                                </div>
                                <div class="flex justify-between mb-2" x-show="discountAmount > 0">
                                    <span class="text-sm text-red-600">Discount:</span>
                                    <span class="text-sm font-medium text-red-600">-₹<span x-text="discountAmount"></span></span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm">Taxable:</span>
                                    <span class="text-sm font-medium" x-text="formatCurrency(taxableAmount)"></span>
                                </div>

                                <template x-if="taxType === 'cgst_sgst'">
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm">CGST:</span>
                                            <span class="text-sm" x-text="formatCurrency(cgstAmount)"></span>
                                        </div>
                                        <div class="flex justify-between mb-2">
                                            <span class="text-sm">SGST:</span>
                                            <span class="text-sm" x-text="formatCurrency(sgstAmount)"></span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="taxType === 'igst'">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm">IGST:</span>
                                        <span class="text-sm" x-text="formatCurrency(igstAmount)"></span>
                                    </div>
                                </template>

                                <hr class="my-2 border-gray-300 dark:border-gray-600">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Grand Total:</span>
                                    <span x-text="formatCurrency(grandTotal)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('gst-invoices.show', $invoice->id) }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        Update GST Invoice
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function gstInvoiceBuilder() {
            return {
                items: {
                    !!json_encode($invoice - > items - > map(fn($i) => [
                        'name' => $i - > name,
                        'hsn_sac_code' => $i - > hsn_sac_code ?? '',
                        'quantity' => (int)\ $i - > quantity,
                        'unit_price' => (float)\ $i - > unit_price,
                        'gst_rate' => (float)\ $i - > gst_rate,
                        'line_total' => (float)\ $i - > line_total,
                    ]) - > toArray()) !!
                },
                gstMode: '{!! $invoice->gst_mode !!}',
                discountType: '{!! $invoice->discount_type !!}',
                discountAmount: {
                    !!$invoice - > discount_amount ?? 0!!
                },
                shippingCharges: {
                    !!$invoice - > shipping_charges ?? 0!!
                },
                commission: {
                    !!$invoice - > commission ?? 0!!
                },
                subtotal: {
                    !!$invoice - > subtotal!!
                },
                taxableAmount: {
                    !!$invoice - > taxable_amount!!
                },
                cgstAmount: {
                    !!$invoice - > cgst_amount!!
                },
                sgstAmount: {
                    !!$invoice - > sgst_amount!!
                },
                igstAmount: {
                    !!$invoice - > igst_amount!!
                },
                totalGst: {
                    !!$invoice - > total_gst_amount!!
                },
                grandTotal: {
                    !!$invoice - > grand_total!!
                },
                taxType: '{!! $invoice->igst_amount > 0 ? '
                igst ' : '
                cgst_sgst ' !!}',
                companyState: '{!! $invoice->company->state_code !!}',
                clientState: '{!! $invoice->client->state_code !!}',

                init() {
                    this.calculateTotals();
                },

                fetchClientState() {
                    const select = document.querySelector('select[name=client_id]');
                    const option = select.options[select.selectedIndex];
                    this.clientState = option.dataset.state || '24';
                    this.determineTaxType();
                    this.calculateTotals();
                },

                determineTaxType() {
                    this.taxType = this.companyState === this.clientState ? 'cgst_sgst' : 'igst';
                },

                addItem() {
                    this.items.push({
                        name: '',
                        hsn_sac_code: '',
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
                    this.items[index].line_total = this.items[index].quantity * this.items[index].unit_price;
                    this.calculateTotals();
                },

                calculateTotals() {
                    this.subtotal = this.items.reduce((sum, item) => sum + (item.quantity * item.unit_price), 0);

                    var d = parseFloat(this.discountAmount) || 0;
                    if (this.discountType === 'percentage' && d > 0) d = this.subtotal * (d / 100);
                    this.taxableAmount = this.subtotal - (this.discountType === 'fixed' ? d : 0);

                    var rate = this.items.length > 0 ?
                        this.items.reduce((sum, item) => sum + parseFloat(item.gst_rate), 0) / this.items.length :
                        18;
                    this.totalGst = this.taxableAmount * (rate / 100);

                    if (this.taxType === 'cgst_sgst') {
                        this.cgstAmount = this.totalGst / 2;
                        this.sgstAmount = this.totalGst / 2;
                        this.igstAmount = 0;
                    } else {
                        this.igstAmount = this.totalGst;
                        this.cgstAmount = 0;
                        this.sgstAmount = 0;
                    }

                    this.grandTotal = this.taxableAmount + this.totalGst +
                        (parseFloat(this.shippingCharges) || 0) + (parseFloat(this.commission) || 0);
                },

                formatCurrency(amount) {
                    return '₹' + parseFloat(amount || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }
            }
        }
    </script>
</x-app-layout>
"@ | Set-Content resources\views\gst-invoices\edit.blade.php