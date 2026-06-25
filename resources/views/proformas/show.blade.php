@extends('layouts.app')

@section('title', 'Proforma Details - GST Billing Pro')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('proformas.index') }}" class="btn btn-sm" style="background:#f1f5f9; border-radius:10px; color:#64748b;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 style="font-size:18px; font-weight:700; margin:0;">Proforma #{{ $proforma->invoice_number ?? 'N/A' }}</h2>
    </div>
    <a href="{{ route('proformas.pdf', $proforma) }}" class="btn" style="background:#d1fae5; color:#065f46; border-radius:10px; font-weight:600; font-size:13px;">
        <i class="fas fa-file-pdf me-1"></i> PDF
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Items</h5>
                <table class="table table-hover">
                    <thead class="text-muted" style="font-size:11px; background:#f8fafc;">
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>GST</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proforma->items ?? [] as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ $item->gst_rate }}%</td>
                            <td class="fw-bold">₹{{ number_format($item->line_total_with_gst ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">No items</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Details</h5>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Client</span><span class="fw-semibold">{{ $proforma->client->name ?? 'N/A' }}</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Date</span><span>{{ $proforma->invoice_date?->format('d M Y') }}</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Valid Until</span><span>{{ $proforma->due_date?->format('d M Y') }}</span></div>
                <hr>
                <div class="d-flex justify-content-between"><span class="fw-bold">Total</span><span class="fw-bold" style="color:#1e3a8a; font-size:18px;">₹{{ number_format($proforma->grand_total ?? 0, 2) }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection