<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Name *</label>
                            <input type="text" name="name" value="{{ $product->name }}" required class="w-full rounded-md border-gray-300">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">HSN/SAC Code</label>
                            <input type="text" name="hsn_sac_code" value="{{ $product->hsn_sac_code }}" maxlength="8" class="w-full rounded-md border-gray-300">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Unit Price *</label>
                                <input type="number" name="unit_price" value="{{ $product->unit_price }}" required min="0" step="0.01" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">GST Rate *</label>
                                <select name="gst_rate" required class="w-full rounded-md border-gray-300">
                                    @foreach([0,5,12,18,28] as $rate)
                                        <option value="{{ $rate }}" {{ $product->gst_rate == $rate ? 'selected' : '' }}>{{ $rate }}%</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded border-gray-300">
                                <span class="ml-2 text-sm">Active</span>
                            </label>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>