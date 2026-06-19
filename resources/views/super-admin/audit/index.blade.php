@extends('layouts.super-admin')
@section('page-title', 'Audit Trail')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">📋 Audit Trail</h2>
        <div class="flex gap-3">
            <input type="date" class="border rounded px-3 py-1 text-sm">
            <select class="border rounded px-3 py-1 text-sm">
                <option>All Companies</option>
                @foreach($companies ?? [] as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3">Time</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Action</th>
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Resource</th>
                    <th class="px-4 py-3">IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($audits ?? [] as $audit)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3 text-xs">{{ $audit->created_at?->format('d M Y H:i') ?? '—' }}</td>
                    <td class="px-4 py-3 text-xs">{{ $audit->user->name ?? 'System' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full 
                            {{ str_contains($audit->event ?? '', 'delete') ? 'bg-red-100 text-red-800' : '' }}
                            {{ str_contains($audit->event ?? '', 'create') ? 'bg-green-100 text-green-800' : '' }}
                            {{ str_contains($audit->event ?? '', 'update') ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ ucfirst($audit->event ?? '—') }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $audit->company->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-xs">{{ $audit->auditable_type ?? '—' }} #{{ $audit->auditable_id ?? '' }}</td>
                    <td class="px-4 py-3 text-xs font-mono">{{ $audit->ip_address ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No audit records yet. Data will appear as users interact with the platform.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection