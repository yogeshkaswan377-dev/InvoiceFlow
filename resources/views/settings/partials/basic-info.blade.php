{{-- resources/views/settings/partials/basic-info.blade.php --}}
<div class="space-y-4">
    <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
            <input type="text" name="name" value="{{ old('name', $company->name) }}" class="w-full rounded-md border-gray-300 shadow-sm" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">GSTIN</label>
            <input type="text" name="gstin" value="{{ old('gstin', $company->gstin) }}" class="w-full rounded-md border-gray-300 shadow-sm">
            @error('gstin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">PAN</label>
            <input type="text" name="pan" value="{{ old('pan', $company->pan) }}" class="w-full rounded-md border-gray-300 shadow-sm">
            @error('pan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">CIN</label>
            <input type="text" name="cin" value="{{ old('cin', $company->cin) }}" class="w-full rounded-md border-gray-300 shadow-sm">
            @error('cin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm">
            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
            <input type="url" name="website" value="{{ old('website', $company->website) }}" class="w-full rounded-md border-gray-300 shadow-sm">
            @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>