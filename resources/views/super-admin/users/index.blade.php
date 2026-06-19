@extends('layouts.super-admin')
@section('page-title', 'Users')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <h2 class="font-semibold text-lg">All Users</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $user->email }}</td>
                    <td class="px-4 py-3 text-xs">{{ $user->company->name ?? '—' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded-full bg-gray-100">{{ $user->roles->first()->name ?? '—' }}</span></td>
                    <td class="px-4 py-3 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3"><a href="/super-admin/users/{{ $user->id }}" class="text-indigo-600 hover:underline text-xs">View</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $users->links() }}</div>
</div>
@endsection