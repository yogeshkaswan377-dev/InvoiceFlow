@extends('layouts.super-admin')

@section('title', 'Platform Settings')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">Platform Settings</h1>
    <p class="text-xs text-gray-500 mt-1">Global configuration for the entire SaaS platform.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- General Settings --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">General Configuration</h3>
        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold uppercase text-gray-400 block mb-1">Platform Name</label>
                <input type="text" value="GST Billing Pro" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="text-xs font-bold uppercase text-gray-400 block mb-1">Default Currency</label>
                <select class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
                    <option>INR (₹)</option>
                    <option>USD ($)</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-bold uppercase text-gray-400 block mb-1">Default Timezone</label>
                <select class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
                    <option>Asia/Kolkata</option>
                    <option>UTC</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Email Settings --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Email Configuration</h3>
        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold uppercase text-gray-400 block mb-1">SMTP Host</label>
                <input type="text" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="text-xs font-bold uppercase text-gray-400 block mb-1">From Address</label>
                <input type="email" value="noreply@gstbillingpro.com" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
        </div>
    </div>

    {{-- GST Defaults --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Tax Defaults</h3>
        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold uppercase text-gray-400 block mb-1">Default GST Rate</label>
                <select class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
                    <option>18%</option>
                    <option>5%</option>
                    <option>12%</option>
                    <option>28%</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-bold uppercase text-gray-400 block mb-1">Invoice Prefix</label>
                <input type="text" value="INV" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
            </div>
        </div>
    </div>

    {{-- Danger Zone --}}
    <div class="bg-white rounded-2xl shadow-sm border border-rose-200/60 p-6">
        <h3 class="text-lg font-bold text-rose-700 mb-4">Danger Zone</h3>
        <p class="text-xs text-gray-500 mb-4">Irreversible platform-wide actions.</p>
        <div class="space-y-2">
            <button class="w-full px-4 py-2 bg-rose-50 text-rose-700 text-sm font-semibold rounded-xl hover:bg-rose-100 transition">
                Clear System Cache
            </button>
            <button class="w-full px-4 py-2 bg-rose-50 text-rose-700 text-sm font-semibold rounded-xl hover:bg-rose-100 transition">
                Reset All Tenant Data
            </button>
        </div>
    </div>
</div>

<div class="mt-6 text-right">
    <button class="px-6 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-600/10 transition">
        Save Settings
    </button>
</div>
@endsection