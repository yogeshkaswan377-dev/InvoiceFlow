<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Switch Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-bold mb-4">Select a company to work with:</h3>
                    
                    <div class="space-y-3">
                        @foreach($companies as $company)
                            <form method="POST" action="{{ route('company.set', $company->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="w-full text-left p-4 border rounded-lg hover:bg-gray-50 transition">
                                    <div class="font-bold">{{ $company->name }}</div>
                                    <div class="text-sm text-gray-600">GSTIN: {{ $company->gstin ?? 'Not set' }}</div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>