<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('company.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="font-bold mb-4">Basic Information</h3>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Company Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                           class="w-full rounded-md border-gray-300 shadow-sm">
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                            
                            <!-- Tax Information -->
                            <div>
                                <h3 class="font-bold mb-4">Tax Information</h3>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">GSTIN (15 characters)</label>
                                    <input type="text" name="gstin" value="{{ old('gstin') }}" maxlength="15"
                                           class="w-full rounded-md border-gray-300 shadow-sm uppercase">
                                    <p class="text-xs text-gray-500 mt-1">Format: 27ABCDE1234F1Z5</p>
                                    @error('gstin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">PAN (10 characters)</label>
                                    <input type="text" name="pan" value="{{ old('pan') }}" maxlength="10"
                                           class="w-full rounded-md border-gray-300 shadow-sm uppercase">
                                    @error('pan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            
                            <!-- Address -->
                            <div class="md:col-span-2">
                                <h3 class="font-bold mb-4">Address</h3>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Address Line 1</label>
                                    <input type="text" name="address_line1" value="{{ old('address_line1') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Address Line 2</label>
                                    <input type="text" name="address_line2" value="{{ old('address_line2') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">City</label>
                                        <input type="text" name="city" value="{{ old('city') }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium mb-1">State</label>
                                        <input type="text" name="state" value="{{ old('state') }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium mb-1">State Code</label>
                                        <input type="text" name="state_code" value="{{ old('state_code') }}" maxlength="2"
                                               class="w-full rounded-md border-gray-300 shadow-sm uppercase"
                                               placeholder="27">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Pincode</label>
                                        <input type="text" name="pincode" value="{{ old('pincode') }}" maxlength="6"
                                               class="w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Create Company
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>