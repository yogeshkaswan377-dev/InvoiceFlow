@extends('layouts.super-admin')

@section('title', 'Company Users')

@section('content')
<div class="mb-6">
    <a href="/super-admin/companies/{{ $company->id ?? 1 }}" class="text-sm text-indigo-600 hover:text-indigo-700">
        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Company
    </a>
</div>

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">{{ $company->name ?? 'Company' }} — Users</h1>
        <p class="text-xs text-gray-500 mt-1">Team members belonging to this tenant.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Joined</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 text-gray-600">
                @forelse($users ?? [] as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 bg-indigo-50 text-indigo-600 rounded-lg font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <span class="font-semibold text-gray-900">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700">
                            {{ ucfirst($user->role ?? 'Staff') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $user->created_at?->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection