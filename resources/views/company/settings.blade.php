<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Company Settings</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">{{ session('success') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('company.update', $company) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium mb-1">Company Name</label>
                                <input type="text" name="name" value="{{ $company->name }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Email</label>
                                <input type="email" name="email" value="{{ $company->email }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Phone</label>
                                <input type="text" name="phone" value="{{ $company->phone }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">GSTIN</label>
                                <input type="text" name="gstin" value="{{ $company->gstin }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">PAN</label>
                                <input type="text" name="pan" value="{{ $company->pan }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">State</label>
                                <input type="text" name="state" value="{{ $company->state }}" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold mb-4">Address</h3>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1">Address</label>
                                <input type="text" name="address_line_1" value="{{ $company->address_line_1 }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">City</label>
                                <input type="text" name="city" value="{{ $company->city }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Pincode</label>
                                <input type="text" name="pincode" value="{{ $company->pincode }}" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold mb-4">Logo & Signature</h3>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium mb-1">Logo</label>
                                <input type="file" name="logo" class="w-full">
                                @if($company->logo_path)
                                <img src="{{ asset($company->logo_path) }}" class="mt-2 max-h-16">
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Signature</label>
                                <input type="file" name="signature" class="w-full">
                                @if($company->signature_path)
                                <img src="{{ asset($company->signature_path) }}" class="mt-2 max-h-16">
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>