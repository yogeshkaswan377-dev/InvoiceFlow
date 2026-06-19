<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create GST Invoice
            </h2>
            <a href="{{ ('gst-invoices.index') }}" class="text-gray-500 hover:text-gray-700">
                &larr; Back to GST Invoices
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('gst-invoices.store') }}" method="POST" x-data="gstInvoiceBuilder()">
                @csrf

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
                                        <option value="{{ $client->id }}" data-state="{{ $client->state_code }}">
                                            {{ $client->name }} {{ $client->gstin ? '(GST: '.$client->gstin.')' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Invoice Date *</label>
                                        <input type="date" name="invoice_date" required value="{{ old('invoice_date', date('Y-m-d')) }}"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Due Date *</label>
                                        <input type="date" name="due_date" required value="{{ old('due_date', date('Y-m-d', strtotime('+15 days'))) }}"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                    </div>
                                </div>

                                <!-- Product Search -->
                                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Products</label>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="productSearch" x-on:input.debounce.300="searchProducts()"
                                            placeholder="Search by name or HSN..."
                                            class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm">
                                    </div>
                                    <!-- Search Results Dropdown -->
                                    <div x-show="searchResults.length > 0" class="mt-2 bg-white dark:bg-gray-800 border rounded-md shadow-lg max-h-48 overflow-y-auto">
                                        <template x-for="product in searchResults" :key="product.id">
                                            <div x-on:click="selectProduct(product)"
                                                class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-sm border-b last:border-0">
                                                <span x-text="product.name" class="font-medium"></span>
                                                <span class="text-gray-500 ml-2">₹<span x-text="product.unit_price"></span> | <span x-text="product.gst_rate"></span>% GST</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- GST Mode Toggle -->
                                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GST Mode</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="gst_mode" value="exclusive" x-model="gstMode" @change="recalculateAll()" checked>
                                            <span class="ml-2 text-sm">Exclusive (GST extra)</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="gst_mode" value="inclusive" x-model="gstMode" @change="recalculateAll()">
                                            <span class="ml-2 text-sm">Inclusive (GST included)</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Tax Type Display -->
                                <div class="mb-4 p-3 rounded-lg" x-bind:class="taxType === 'igst' ? 'bg-purple-50 dark:bg-purple-900' : 'bg-blue-50 dark:bg-blue-900'">
                                    <span class="text-sm font-medium" x-text="taxType === 'igst' ? 'IGST (Inter-State)' : 'CGST + SGST (Intra-State)'"></span>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="reverse_charge" class="rounded border-gray-300">
                                        <span class="ml-2 text-sm">Reverse Charge (RCM)</span>
                                    </label>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                                    <textarea name="notes" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"></textarea>
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
                            <button type="button" x-on:click="addItem()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
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
                                                <input type="text" x-model="item.hsn_sac_code" :name="'items['+index+'][hsn_sac_code]'" placeholder="HSN/SAC code"
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
                                                <button type="button" x-on:click="cloneItem(index)" class="text-blue-600 hover:text-blue-900 text-sm mr-1" title="Clone">📋</button>
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

                                <!-- CGST/SGST or IGST -->
                                <template x-if="taxType === 'cgst_sgst'">
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm">CGST (9%):</span>
                                            <span class="text-sm" x-text="formatCurrency(cgstAmount)"></span>
                                        </div>
                                        <div class="flex justify-between mb-2">
                                            <span class="text-sm">SGST (9%):</span>
                                            <span class="text-sm" x-text="formatCurrency(sgstAmount)"></span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="taxType === 'igst'">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm">IGST (18%):</span>
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
                    <button type="submit" name="status" value="draft" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">
                        Save as Draft
                    </button>
                    <button type="submit" name="status" value="sent" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        Save & Send
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function gstInvoiceBuilder() {
            return {
                items: [],
                gstMode: 'exclusive',
                discountType: '',
                discountAmount: 0,
                shippingCharges: 0,
                commission: 0,
                productSearch: '',
                searchResults: [],
                subtotal: 0,
                taxableAmount: 0,
                cgstAmount: 0,
                sgstAmount: 0,
                igstAmount: 0,
                totalGst: 0,
                grandTotal: 0,
                taxType: 'cgst_sgst',
                companyState: '24',
                clientState: '24',

                init() {
                    this.addItem();
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
                    const item = this.items[index];
                    item.line_total = item.quantity * item.unit_price;
                    this.calculateTotals();
                },

                recalculateAll() {
                    this.items.forEach((item, index) => this.calculateItemTotal(index));
                },

                calculateTotals() {
                    this.subtotal = this.items.reduce((sum, item) => sum + (item.quantity * item.unit_price), 0);

                    let discountAmount = parseFloat(this.discountAmount) || 0;
                    if (this.discountType === 'percentage' && discountAmount > 0) {
                        discountAmount = this.subtotal * (discountAmount / 100);
                    }
                    if (this.discountType === 'fixed') {
                        this.subtotal -= discountAmount;
                    }

                    this.taxableAmount = this.subtotal - (this.discountType === 'fixed' ? discountAmount : discountAmount);

                    const avgRate = this.items.length > 0 ?
                        this.items.reduce((sum, item) => sum + parseFloat(item.gst_rate), 0) / this.items.length :
                        18;

                    this.totalGst = this.taxableAmount * (avgRate / 100);

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
                },

                searchProducts() {
                    if (this.productSearch.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    fetch('/products/search?q=' + encodeURIComponent(this.productSearch))
                        .then(res => res.json())
                        .then(data => {
                            this.searchResults = data;
                        });
                },

                selectProduct(product) {
                    this.items.push({
                        name: product.name,
                        hsn_sac_code: product.hsn_sac_code || '',
                        quantity: 1,
                        unit_price: parseFloat(product.unit_price),
                        gst_rate: parseFloat(product.gst_rate),
                        line_total: parseFloat(product.unit_price)
                    });
                    this.productSearch = '';
                    this.searchResults = [];
                    this.calculateTotals();
                },

                cloneItem(index) {
                    const original = this.items[index];
                    this.items.push({
                        name: original.name + ' (copy)',
                        hsn_sac_code: original.hsn_sac_code,
                        quantity: original.quantity,
                        unit_price: original.unit_price,
                        gst_rate: original.gst_rate,
                        line_total: original.line_total
                    });
                    this.calculateTotals();
                },
            }
        }
    </script>
</x-app-layout>