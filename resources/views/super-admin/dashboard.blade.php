@extends('layouts.super-admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <x-super-admin.stats-card label="Total Companies" :value="$totalCompanies" color="blue" />
        <x-super-admin.stats-card label="Active Companies" :value="$activeCompanies" color="green" />
        <x-super-admin.stats-card label="Total Users" :value="$totalUsers" color="purple" />
        <x-super-admin.stats-card label="Total Invoices" :value="$totalInvoices" color="yellow" />
        <x-super-admin.stats-card label="Revenue" :value="'₹' . number_format($totalRevenue, 0)" color="emerald" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Recent Companies</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th>Company</th>
                        <th>Plan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentCompanies as $c)
                    <tr class="border-t">
                        <td class="py-2">{{ $c->name }}</td>
                        <td class="py-2 capitalize">{{ $c->subscription_plan }}</td>
                        <td class="py-2"><span class="px-2 py-0.5 text-xs rounded-full {{ $c->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $c->is_active ? 'Active' : 'Suspended' }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="/super-admin/companies" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 text-center">🏢<br><span class="text-sm font-medium">Companies</span></a>
                <a href="/super-admin/users" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 text-center">👥<br><span class="text-sm font-medium">Users</span></a>
                <a href="/super-admin/analytics" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 text-center">📈<br><span class="text-sm font-medium">Analytics</span></a>
                <a href="/super-admin/logs" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 text-center">📝<br><span class="text-sm font-medium">Logs</span></a>
            </div>
        </div>
    </div>
</div>
@endsection