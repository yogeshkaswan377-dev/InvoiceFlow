@extends('layouts.super-admin')

@section('title', 'All Users')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Platform Users</h1>
        <p class="text-xs text-gray-500 mt-1">All registered users across all tenant organizations.</p>
    </div>
    <div class="flex items-center gap-2">
        <select class="px-3 py-1.5 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
            <option>All Roles</option>
            <option>Owner</option>
            <option>Admin</option>
            <option>Staff</option>
        </select>
        <input type="text" placeholder="Search user..." class="px-3 py-1.5 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500 w-40 transition">
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Company</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Joined</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 text-gray-600">
                @forelse($users ?? [] as $user)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-purple-50 text-purple-600 rounded-xl font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $user->company->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700">
                            {{ ucfirst($user->role ?? 'Staff') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full ring-1 ring-emerald-600/10">
                            Active
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $user->created_at?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="/super-admin/users/{{ $user->id }}" class="p-2 text-gray-400 hover:text-indigo-600 rounded-lg hover:bg-gray-50 transition">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fa-solid fa-users text-2xl block mb-2 opacity-50"></i>
                        No users registered yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection