@extends('layouts.super-admin')

@section('title', 'Super Admin Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="h-16 w-16 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                {{ strtoupper(substr(auth()->user()->name ?? 'SA', 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name ?? 'Super Admin' }}</h2>
                <p class="text-sm text-gray-500">{{ auth()->user()->email ?? 'admin@system.io' }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="p-4 bg-gray-50 rounded-xl">
                <span class="text-xs font-bold uppercase text-gray-400">Role</span>
                <h4 class="font-semibold text-indigo-600">Super Administrator</h4>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <span class="text-xs font-bold uppercase text-gray-400">Permissions</span>
                <h4 class="font-semibold text-gray-900">Full Platform Access</h4>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <span class="text-xs font-bold uppercase text-gray-400">Last Login</span>
                <h4 class="font-semibold text-gray-900">{{ now()->format('d M Y, H:i') }}</h4>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-rose-50 text-rose-700 text-sm font-semibold rounded-xl hover:bg-rose-100 transition">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Sign Out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection