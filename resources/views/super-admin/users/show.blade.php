@extends('layouts.super-admin')

@section('title', 'User Details')

@section('content')
<div class="mb-6">
    <a href="/super-admin/users" class="text-sm text-indigo-600 hover:text-indigo-700">
        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Users
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
    <div class="flex items-center gap-4 mb-6">
        <div class="h-14 w-14 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
            {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $user->name ?? 'User Name' }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email ?? 'user@email.com' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="p-4 bg-gray-50 rounded-xl">
            <span class="text-xs font-bold uppercase text-gray-400">Role</span>
            <h4 class="font-semibold text-indigo-600">{{ ucfirst($user->role ?? 'Staff') }}</h4>
        </div>
        <div class="p-4 bg-gray-50 rounded-xl">
            <span class="text-xs font-bold uppercase text-gray-400">Company</span>
            <h4 class="font-semibold text-gray-900">{{ $user->company->name ?? 'N/A' }}</h4>
        </div>
        <div class="p-4 bg-gray-50 rounded-xl">
            <span class="text-xs font-bold uppercase text-gray-400">Joined</span>
            <h4 class="font-semibold text-gray-900">{{ $user->created_at?->format('d M Y') ?? 'N/A' }}</h4>
        </div>
    </div>
</div>
@endsection