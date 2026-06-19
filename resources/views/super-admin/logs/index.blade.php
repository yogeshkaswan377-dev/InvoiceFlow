@extends('layouts.super-admin')
@section('page-title', 'System Logs')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b flex justify-between">
        <h2 class="font-semibold text-lg">System Logs</h2>
        <span class="text-xs text-gray-500">Last 200 entries</span>
    </div>
    <div class="bg-gray-900 text-gray-200 p-4 overflow-x-auto max-h-[600px] overflow-y-auto font-mono text-xs leading-relaxed">
        @forelse($logs as $line)
        <div class="{{ str_contains($line, 'ERROR') ? 'text-red-400' : (str_contains($line, 'WARN') ? 'text-yellow-400' : 'text-gray-300') }}">{{ $line }}</div>
        @empty
        <p class="text-gray-500">No logs found.</p>
        @endforelse
    </div>
</div>
@endsection