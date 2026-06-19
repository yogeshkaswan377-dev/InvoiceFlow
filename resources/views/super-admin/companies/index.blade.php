@extends('layouts.super-admin')
@section('page-title', 'Companies')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="font-semibold text-lg">All Companies</h2>
        <input type="text" placeholder="Search..." class="border rounded px-3 py-1 text-sm w-64">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Owner</th>
                    <th class="px-4 py-3">Plan</th>
                    <th class="px-4 py-3">Users</th>
                    <th class="px-4 py-3">Invoices</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Created</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="font-medium">{{ $company->name }}</div>
                        <div class="text-xs text-gray-500">{{ $company->email }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $company->owner->name ?? '—' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800 capitalize">{{ $company->subscription_plan }}</span></td>
                    <td class="px-4 py-3">{{ $company->users_count }}</td>
                    <td class="px-4 py-3">{{ $company->invoices_count }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded-full {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $company->is_active ? 'Active' : 'Suspended' }}</span></td>
                    <td class="px-4 py-3 text-xs">{{ $company->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <a href="/super-admin/companies/{{ $company->id }}" class="text-indigo-600 hover:underline text-xs">View</a>
                        @if($company->is_active)
                        <form action="{{ route('super-admin.companies.suspend', $company) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button class="text-red-600 hover:underline text-xs">Suspend</button>
                        </form>
                        @else
                        <form action="{{ route('super-admin.companies.approve', $company) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button class="text-green-600 hover:underline text-xs">Approve</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">No companies found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $companies->links() }}</div>
</div>
@endsection