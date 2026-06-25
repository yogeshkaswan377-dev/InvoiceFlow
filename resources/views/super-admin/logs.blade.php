@extends('layouts.super-admin')

@section('title', 'System Logs')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">System Logs</h1>
        <p class="text-xs text-gray-500 mt-1">Real-time platform event monitoring and diagnostics.</p>
    </div>
    <div class="flex items-center gap-2">
        <select class="px-3 py-1.5 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
            <option>All Levels</option>
            <option>Error</option>
            <option>Warning</option>
            <option>Info</option>
        </select>
        <button class="px-4 py-1.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">Filter</button>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4">Level</th>
                    <th class="px-6 py-4">Message</th>
                    <th class="px-6 py-4">Context</th>
                    <th class="px-6 py-4">Timestamp</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 text-gray-600">
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700">INFO</span></td>
                    <td class="px-6 py-4">Company registered successfully</td>
                    <td class="px-6 py-4 font-mono text-xs text-gray-500">CompanyController@store</td>
                    <td class="px-6 py-4 text-xs text-gray-400">2026-06-20 14:32:10</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700">WARN</span></td>
                    <td class="px-6 py-4">Queue worker backlog detected</td>
                    <td class="px-6 py-4 font-mono text-xs text-gray-500">QueueMonitor</td>
                    <td class="px-6 py-4 text-xs text-gray-400">2026-06-20 13:15:45</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700">ERROR</span></td>
                    <td class="px-6 py-4">Payment gateway timeout</td>
                    <td class="px-6 py-4 font-mono text-xs text-gray-500">PaymentController</td>
                    <td class="px-6 py-4 text-xs text-gray-400">2026-06-19 10:22:33</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection