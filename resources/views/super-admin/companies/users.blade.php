@extends('layouts.super-admin')
@section('page-title', 'Company Users — ' . $company->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('super-admin.companies.show', $company) }}" class="text-gray-500 hover:text-gray-700">← Back to Company</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center font-bold">{{ strtoupper(substr($company->name, 0, 2)) }}</div>
            <div>
                <h2 class="text-lg font-bold">{{ $company->name }}</h2>
                <p class="text-sm text-gray-500">All Users</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Last Login</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users ?? [] as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <select class="border rounded px-2 py-1 text-xs">
                            <option {{ ($user->roles->first()->name ?? '') === 'owner' ? 'selected' : '' }}>Owner</option>
                            <option {{ ($user->roles->first()->name ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option {{ ($user->roles->first()->name ?? '') === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $user->last_login_at?->format('d M Y') ?? 'Never' }}</td>
                    <td class="px-4 py-3">
                        <button class="text-red-600 hover:underline text-xs">Disable</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No users in this company.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection