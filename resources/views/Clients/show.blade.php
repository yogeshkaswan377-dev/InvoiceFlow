@extends('layouts.app')

@section('title', $client->name . ' - Client Details')
@section('meta_description', 'View client details, invoices history, GSTIN and contact information.')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('clients.index') }}" class="btn btn-sm" style="background:#f1f5f9; border-radius:10px; color:#64748b;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div style="width:56px; height:56px; border-radius:16px; background:linear-gradient(135deg, #1e3a8a, #3b82f6); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:22px; color:white;">
            {{ strtoupper(substr($client->name, 0, 1)) }}
        </div>
        <div>
            <h2 style="font-size:20px; font-weight:700; margin:0;">{{ $client->name }}</h2>
            <p style="color:#64748b; font-size:13px; margin:2px 0 0;">{{ $client->company_name ?? 'Individual Client' }}</p>
        </div>
    </div>
    <a href="{{ route('clients.edit', $client) }}" class="btn text-white" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:10px 20px; font-weight:600; text-decoration:none;">
        <i class="fas fa-edit me-2"></i> Edit
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-info-circle me-2 text-primary"></i>Details</h5>

                @if($client->gstin)
                <div class="mb-3">
                    <small class="text-muted d-block">GSTIN</small>
                    <span class="fw-semibold badge" style="background:#d1fae5; color:#065f46; font-size:13px;">{{ $client->gstin }}</span>
                </div>
                @endif

                @if($client->pan)
                <div class="mb-3">
                    <small class="text-muted d-block">PAN</small>
                    <span class="fw-semibold">{{ $client->pan }}</span>
                </div>
                @endif

                @if($client->email)
                <div class="mb-3">
                    <small class="text-muted d-block">Email</small>
                    <span class="fw-semibold"><i class="fas fa-envelope me-1 text-muted"></i> {{ $client->email }}</span>
                </div>
                @endif

                @if($client->phone)
                <div class="mb-3">
                    <small class="text-muted d-block">Phone</small>
                    <span class="fw-semibold"><i class="fas fa-phone me-1 text-muted"></i> {{ $client->phone }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Address</h5>
                <p style="font-size:13px; line-height:1.6; color:#475569;">
                    {{ $client->address_line_1 ?? 'N/A' }}<br>
                    {{ $client->city ?? '' }}{{ $client->city && $client->state ? ', ' : '' }}{{ $client->state ?? '' }}
                    {{ $client->pincode ? ' - ' . $client->pincode : '' }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="p-4 border-bottom">
                    <h5 class="fw-bold mb-0"><i class="fas fa-file-invoice me-2 text-primary"></i>Invoice History</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="text-muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.05em; background:#f8fafc;">
                            <tr>
                                <th class="ps-4">Invoice #</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($client->invoices ?? [] as $invoice)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                                <td class="fw-bold">₹{{ number_format($invoice->grand_total) }}</td>
                                <td>
                                    <span class="badge rounded-pill" style="background:{{ $invoice->status == 'paid' ? '#d1fae5' : '#fef3c7' }}; color:{{ $invoice->status == 'paid' ? '#065f46' : '#92400e' }};">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('gst-invoices.show', $invoice) }}" class="btn btn-sm" style="background:#dbeafe; color:#1d4ed8; border-radius:8px; font-size:11px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No invoices yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection