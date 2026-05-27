<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Welcome to GST Invoice SaaS Platform!</h3>
                    <p class="mb-2">Company: <strong>{{ $company->name ?? 'Not selected' }}</strong></p>
                    <p class="mb-2">GSTIN: <strong>{{ $company->gstin ?? 'Not set' }}</strong></p>
                    <p class="mb-4">Role: <strong>@if(auth()->user()->hasRole('owner')) Owner @elseif(auth()->user()->hasRole('admin')) Admin @else Staff @endif</strong></p>
                    
                    <div class="mt-6 p-4 bg-gray-50 rounded">
                        <p class="text-gray-600">Phase 1 Complete ✓</p>
                        <p class="text-gray-500 text-sm mt-2">Next phases will add: Client Management, Invoices, GST Calculations, PDF Generation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>