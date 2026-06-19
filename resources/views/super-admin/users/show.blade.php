@extends('layouts.super-admin')
@section('page-title', 'User Details')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-indigo-600 text-white flex items-center justify-center text-2xl font-bold">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">User Info</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Role</span><span>{{ $user->roles->first()->name ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Company</span><span>{{ $user->company->name ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Phone</span><span>{{ $user->phone ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Joined</span><span>{{ $user->created_at->format('d M Y') }}</span></div>
            </dl>
        </div>
    </div>

    <a href="{{ route('super-admin.users') }}" class="text-indigo-600 hover:underline text-sm">← Back to Users</a>
</div>
@endsection