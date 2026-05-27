{{-- resources/views/clients/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Add New Client')

@section('content')
<div class="py-12" x-data="clientForm()" x-init="init()">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Add New Client</h2>
                    <a href="{{ route('clients.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Clients</a>
                </div>

                <form method="POST" action="{{ route('clients.store') }}" @submit="validateForm">
                    @csrf

                    <!-- Client Type Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client Type</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="client_type" value="business" x-model="clientType" @change="onClientTypeChange" class="form-radio text-blue-600">
                                <span class="ml-2">Business</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="client_type" value="individual" x-model="clientType" @change="onClientTypeChange" class="form-radio text-blue-600">
                                <span class="ml-2">Individual</span>
                            </label>
                        </div>
                        @error('client_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Basic Information -->
                    <div class="border-t pt-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person Name *</label>
                                <input type="text" name="name" x-model="form.name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div x-show="clientType === 'business'">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                                <input type="text" name="company_name" x-model="form.company_name" class="w-full rounded-md border-gray-300 shadow-sm">
                                @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" x-model="form.email" class="w-full rounded-md border-gray-300 shadow-sm">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" name="phone" x-model="form.phone" class="w-full rounded-md border-gray-300 shadow-sm">
                                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- GST Details (Conditional) -->
                    <div class="border-t pt-6 mb-6" x-show="clientType === 'business'">
                        <h3 class="text-lg font-semibold mb-4">GST Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">GSTIN *</label>
                                <input type="text" name="gstin" x-model="form.gstin" 
                                       @blur="validateGSTIN" 
                                       class="w-full rounded-md border-gray-300 shadow-sm"
                                       :class="{'border-red-500': gstinError}">
                                <p x-show="gstinError" class="text-red-500 text-xs mt-1" x-text="gstinError"></p>
                                @error('gstin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">PAN</label>
                                <input type="text" name="pan" x-model="form.pan" class="w-full rounded-md border-gray-300 shadow-sm">
                                @error('pan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="border-t pt-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Address Details</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1</label>
                                <input type="text" name="address_line_1" x-model="form.address_line_1" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2</label>
                                <input type="text" name="address_line_2" x-model="form.address_line_2" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                    <input type="text" name="city" x-model="form.city" class="w-full rounded-md border-gray-300 shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                    <select name="state_code" x-model="form.state_code" @change="onStateChange" class="w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Select State</option>
                                        @foreach($states ?? getIndianStates() as $code => $name)
                                            <option value="{{ $code }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pincode</label>
                                    <input type="text" name="pincode" x-model="form.pincode" class="w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                <input type="text" name="country" x-model="form.country" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Business Settings -->
                    <div class="border-t pt-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Business Settings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Credit Limit</label>
                                <input type="number" step="0.01" name="credit_limit" x-model="form.credit_limit" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Terms (days)</label>
                                <input type="number" name="payment_terms" x-model="form.payment_terms" class="w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                <textarea name="notes" x-model="form.notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" x-model="form.is_active" class="form-checkbox text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Active</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 border-t pt-6">
                        <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function clientForm() {
    return {
        clientType: 'business',
        gstinError: '',
        form: {
            name: '',
            company_name: '',
            email: '',
            phone: '',
            gstin: '',
            pan: '',
            address_line_1: '',
            address_line_2: '',
            city: '',
            state_code: '',
            pincode: '',
            country: 'India',
            credit_limit: 0,
            payment_terms: '',
            notes: '',
            is_active: true
        },
        
        init() {
            // Any initialization logic
        },
        
        onClientTypeChange() {
            if (this.clientType === 'individual') {
                this.form.gstin = '';
                this.form.company_name = '';
            }
        },
        
        async validateGSTIN() {
            if (!this.form.gstin) {
                this.gstinError = '';
                return;
            }
            
            // Client-side validation
            const gstin = this.form.gstin.toUpperCase();
            if (!/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9A-Z]{1}[0-9A-Z]{1}$/.test(gstin)) {
                this.gstinError = 'Invalid GSTIN format';
                return;
            }
            
            // Extract state from GSTIN
            const stateCode = gstin.substring(0, 2);
            if (stateCode && !this.form.state_code) {
                this.form.state_code = stateCode;
                this.onStateChange();
            }
            
            this.gstinError = '';
        },
        
        onStateChange() {
            // Auto-calculate place of supply would happen on server
            // This is just for UX feedback
            if (this.form.state_code) {
                console.log('State selected:', this.form.state_code);
            }
        },
        
        validateForm(event) {
            if (this.clientType === 'business' && !this.form.gstin) {
                event.preventDefault();
                alert('GSTIN is required for business clients');
                return false;
            }
            
            if (!this.form.name) {
                event.preventDefault();
                alert('Contact person name is required');
                return false;
            }
            
            if (this.clientType === 'business' && !this.form.company_name) {
                event.preventDefault();
                alert('Company name is required for business clients');
                return false;
            }
            
            return true;
        }
    }
}
</script>
@endpush
@endsection