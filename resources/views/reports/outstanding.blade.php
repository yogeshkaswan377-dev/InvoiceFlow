@extends('layouts.app')

@section('title', 'Outstanding Payments - GST Billing Pro')
@section('meta_description', 'Track overdue invoices and outstanding payments. Send payment reminders to clients.')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h2>Outstanding Payments</h2>
        <a href="{{ route('reports.gstr1') }}">View GSTR-1</a>
        <p style="color:#64748b; font-size:12px; margin:4px 0 0;">Track overdue and pending invoices</p>
    </div>
</div>

{{-- Summary --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="border-left-color:#f59e0b;">
            <h6 class="text-muted mb-2">Total Outstanding</h6>
            <h3 class="mb-0 fw-bold">₹3,20,000</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-left-color:#ef4444;">
            <h6 class="text-muted mb-2">Overdue</h6>
            <h3 class="mb-0 fw-bold">₹1,40,000</h3>
            <small class="text-danger">12 invoices</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-left-color:#3b82f6;">
            <h6 class="text-muted mb-2">Avg Days Overdue</h6>
            <h3 class="mb-0 fw-bold">18</h3>
            <small class="text-muted">days</small>
        </div>
    </div>
</div>

{{-- Outstanding Invoices Table --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-0 pt-4">
        <h5 class="fw-bold mb-0">Overdue & Pending Invoices</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="text-muted" style="font-size:11px; text-transform:uppercase; letter-spacing:0.05em; background:#f8fafc;">
                    <tr>
                        <th class="ps-4">Invoice #</th>
                        <th>Client</th>
                        <th>Due Date</th>
                        <th>Days Overdue</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-semibold">INV-2024-045</td>
                        <td>Singh Distributors</td>
                        <td>10 Jun 2026</td>
                        <td class="text-danger fw-semibold">10 days</td>
                        <td class="fw-bold">₹22,000</td>
                        <td><span class="badge rounded-pill" style="background:#fee2e2; color:#991b1b;">Overdue</span></td>
                        <td>
                            <button class="btn btn-sm text-white" style="background:#f59e0b; border-radius:8px; font-size:11px;">
                                <i class="fas fa-envelope me-1"></i> Remind
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection