@extends('layouts.app')

@section('title', 'Edit Invoice - GST Billing Pro')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('gst-invoices.show', $invoice) }}" class="btn btn-sm" style="background:#f1f5f9; border-radius:10px; color:#64748b;">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 style="font-size:18px; font-weight:700; margin:0;">Edit Invoice #{{ $invoice->invoice_number }}</h2>
</div>

<form action="{{ route('gst-invoices.update', $invoice) }}" method="POST" class="row g-4">
    @csrf @method('PUT')

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Client & Details</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">Client</label>
                        <select name="client_id" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                            @foreach($clients ?? [] as $client)
                            <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Invoice Date</label>
                        <input type="date" name="invoice_date" value="{{ $invoice->invoice_date?->format('Y-m-d') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Due Date</label>
                        <input type="date" name="due_date" value="{{ $invoice->due_date?->format('Y-m-d') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">Status</label>
                        <select name="status" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                            <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ $invoice->status == 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Notes</h5>
                <textarea name="notes" rows="4" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">{{ $invoice->notes }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn text-white w-100 mt-3" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:14px; font-weight:600;">
            <i class="fas fa-save me-2"></i> Update Invoice
        </button>
    </div>
</form>
@endsection