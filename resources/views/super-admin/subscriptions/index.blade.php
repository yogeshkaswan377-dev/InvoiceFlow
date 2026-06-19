@extends('layouts.super-admin')
@section('page-title', 'Subscriptions')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <h2 class="font-semibold text-lg">Subscription Plans</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Plan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Expires</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                <tr class="border-t">
                    <td class="px-4 py-3 font-medium">{{ $company->name }}</td>
                    <td class="px-4 py-3 capitalize">{{ $company->subscription_plan }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded-full {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $company->is_active ? 'Active' : 'Suspended' }}</span></td>
                    <td class="px-4 py-3 text-xs">{{ $company->subscription_expires_at?->format('d M Y') ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center">No subscriptions.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection