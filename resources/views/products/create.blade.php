<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Product</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Name *</label>
                            <input type="text" name="name" required class="w-full rounded-md border-gray-300">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">HSN/SAC Code</label>
                            <input type="text" name="hsn_sac_code" maxlength="8" class="w-full rounded-md border-gray-300">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Unit Price *</label>
                                <input type="number" name="unit_price" required min="0" step="0.01" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">GST Rate *</label>
                                <select name="gst_rate" required class="w-full rounded-md border-gray-300">
                                    <option value="0">0%</option>
                                    <option value="5">5%</option>
                                    <option value="12">12%</option>
                                    <option value="18" selected>18%</option>
                                    <option value="28">28%</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Description</label>
                            <textarea name="description" rows="2" class="w-full rounded-md border-gray-300"></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Save Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
