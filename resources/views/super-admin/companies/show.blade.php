@extends('layouts.super-admin')
@section('page-title', 'Company Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">{{ $company->name }}</h2>
        <span class="px-3 py-1 text-sm rounded-full {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $company->is_active ? 'Active' : 'Suspended' }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Company Info</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">GSTIN</span><span>{{ $company->gstin ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">State</span><span>{{ $company->state_code ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Plan</span><span class="capitalize">{{ $company->subscription_plan }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Joined</span><span>{{ $company->created_at->format('d M Y') }}</span></div>
            </dl>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Stats</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Users</span><span>{{ $company->users_count }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Clients</span><span>{{ $company->clients_count ?? 0 }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Invoices</span><span>{{ $company->invoices_count }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Revenue</span><span>₹{{ number_format($company->invoices_sum_grand_total ?? 0, 0) }}</span></div>
            </dl>
        </div>
    </div>
</div>
@endsection