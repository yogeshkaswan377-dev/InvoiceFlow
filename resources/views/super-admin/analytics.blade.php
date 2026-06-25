@extends('layouts.super-admin')

@section('title', 'Analytics')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">Engine Core Analytics</h1>
    <p class="text-xs text-gray-500 mt-1">Visual database usage graphs, bandwidth usage pools, and latency metrics charts.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <a href="/super-admin/analytics" class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 hover:shadow-md transition">
        <i class="fa-solid fa-chart-line text-2xl text-indigo-600 mb-2 block"></i>
        <h3 class="font-semibold text-gray-900">Revenue Analytics</h3>
        <p class="text-xs text-gray-500 mt-1">Platform-wide revenue charts</p>
    </a>
    <a href="/super-admin/analytics" class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 hover:shadow-md transition">
        <i class="fa-solid fa-users text-2xl text-emerald-600 mb-2 block"></i>
        <h3 class="font-semibold text-gray-900">User Growth</h3>
        <p class="text-xs text-gray-500 mt-1">Signup & conversion metrics</p>
    </a>
</div>
@endsection