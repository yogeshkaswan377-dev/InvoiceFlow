@extends('layouts.super-admin')
@section('page-title', 'Platform Settings')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h2 class="text-lg font-semibold mb-4">Platform Settings</h2>
    <form method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Platform Name</label>
            <input type="text" value="{{ config('app.name') }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Maintenance Mode</label>
            <select class="w-full border rounded px-3 py-2">
                <option>Off</option>
                <option>On</option>
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save Settings</button>
    </form>
</div>
@endsection