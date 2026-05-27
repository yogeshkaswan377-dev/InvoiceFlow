{{-- resources/views/settings/partials/gst-settings.blade.php --}}
<div class="space-y-6" x-data="gstRatesManager()" x-init="initRates({{ json_encode($company->gst_rates ?? config('gst_rates.default_rates')) }})">
    <h3 class="text-lg font-semibold mb-4">GST Settings</h3>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Default GST Mode</label>
        <select name="gst_mode_default" class="w-64 rounded-md border-gray-300 shadow-sm">
            <option value="exclusive" {{ $company->gst_mode_default == 'exclusive' ? 'selected' : '' }}>Exclusive (GST extra)</option>
            <option value="inclusive" {{ $company->gst_mode_default == 'inclusive' ? 'selected' : '' }}>Inclusive (GST included)</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">GST Rates</label>
        <div class="space-y-3">
            <template x-for="(rate, index) in rates" :key="index">
                <div class="flex items-center space-x-4 p-3 border rounded-lg">
                    <div class="flex-1">
                        <label class="text-sm text-gray-600">Rate (%)</label>
                        <input type="number" step="0.01" x-model="rate.rate" @change="calculateTaxes(index)" class="w-full rounded-md border-gray-300">
                    </div>
                    <div class="flex-1">
                        <label class="text-sm text-gray-600">CGST (%)</label>
                        <input type="number" step="0.01" x-model="rate.cgst" class="w-full rounded-md border-gray-300 bg-gray-100" readonly>
                    </div>
                    <div class="flex-1">
                        <label class="text-sm text-gray-600">SGST (%)</label>
                        <input type="number" step="0.01" x-model="rate.sgst" class="w-full rounded-md border-gray-300 bg-gray-100" readonly>
                    </div>
                    <div class="flex-1">
                        <label class="text-sm text-gray-600">IGST (%)</label>
                        <input type="number" step="0.01" x-model="rate.igst" class="w-full rounded-md border-gray-300 bg-gray-100" readonly>
                    </div>
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" x-model="rate.active" class="form-checkbox text-blue-600">
                            <span class="ml-2 text-sm">Active</span>
                        </label>
                    </div>
                    <button type="button" @click="removeRate(index)" class="text-red-600 hover:text-red-800">Remove</button>
                    <input type="hidden" :name="`gst_rates[${index}][rate]`" x-model="rate.rate">
                    <input type="hidden" :name="`gst_rates[${index}][cgst]`" x-model="rate.cgst">
                    <input type="hidden" :name="`gst_rates[${index}][sgst]`" x-model="rate.sgst">
                    <input type="hidden" :name="`gst_rates[${index}][igst]`" x-model="rate.igst">
                    <input type="hidden" :name="`gst_rates[${index}][active]`" x-model="rate.active">
                </div>
            </template>
            
            <button type="button" @click="addRate" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                + Add GST Rate
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function gstRatesManager() {
    return {
        rates: [],
        
        initRates(rates) {
            this.rates = rates || [
                { rate: 5, cgst: 2.5, sgst: 2.5, igst: 5, active: true },
                { rate: 12, cgst: 6, sgst: 6, igst: 12, active: true },
                { rate: 18, cgst: 9, sgst: 9, igst: 18, active: true },
                { rate: 28, cgst: 14, sgst: 14, igst: 28, active: true }
            ];
        },
        
        calculateTaxes(index) {
            const rate = this.rates[index].rate;
            this.rates[index].cgst = rate / 2;
            this.rates[index].sgst = rate / 2;
            this.rates[index].igst = rate;
        },
        
        addRate() {
            this.rates.push({
                rate: 0,
                cgst: 0,
                sgst: 0,
                igst: 0,
                active: true
            });
        },
        
        removeRate(index) {
            this.rates.splice(index, 1);
        }
    }
}
</script>
@endpush