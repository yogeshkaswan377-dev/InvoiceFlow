@extends('layouts.super-admin')
@section('page-title', 'My Profile')

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-20 h-20 rounded-full bg-indigo-600 text-white flex items-center justify-center text-3xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-500">Super Admin</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="pt-4 border-t">
                <h3 class="font-semibold mb-3">Change Password</h3>
                <div class="space-y-3">
                    <input type="password" name="current_password" placeholder="Current Password" class="w-full border rounded px-3 py-2">
                    <input type="password" name="password" placeholder="New Password" class="w-full border rounded px-3 py-2">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Save Changes</button>
        </form>
    </div>
</div>
@endsection