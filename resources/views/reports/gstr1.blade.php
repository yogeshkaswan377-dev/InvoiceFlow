<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">GSTR1 Summary - {{ date('F Y', mktime(0,0,0,$month,1,$year)) }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Total Invoices</p>
                    <p class="text-2xl font-bold">{{ $summary['total_invoices'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Total Value</p>
                    <p class="text-2xl font-bold">₹{{ number_format($summary['total_value'], 0) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">Total GST</p>
                    <p class="text-2xl font-bold">₹{{ number_format($summary['total_gst'], 0) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-sm text-gray-500">B2B / B2C</p>
                    <p class="text-2xl font-bold">{{ $summary['b2b']->count() }} / {{ $summary['b2c']->count() }}</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold mb-2">IGST</h3>
                    <p class="text-xl">₹{{ number_format($summary['total_igst'], 2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold mb-2">CGST</h3>
                    <p class="text-xl">₹{{ number_format($summary['total_cgst'], 2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold mb-2">SGST</h3>
                    <p class="text-xl">₹{{ number_format($summary['total_sgst'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>