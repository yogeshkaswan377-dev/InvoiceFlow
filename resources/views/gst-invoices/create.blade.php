@extends('layouts.app')

@section('title', 'Create GST Invoice - GST Billing Pro')
@section('meta_description', 'Create a new GST invoice with auto tax calculation, client selection, and product items.')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('gst-invoices.index') }}" class="btn btn-sm" style="background:#f1f5f9; border-radius:10px; color:#64748b;">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 style="font-size:18px; font-weight:700; margin:0;">Create GST Invoice</h2>
</div>

<form action="{{ route('gst-invoices.store') }}" method="POST" class="row g-4">
    @csrf

    <div class="col-lg-8">
        {{-- Client & Invoice Details --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-user me-2 text-primary"></i>Client & Details</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">Client *</label>
                        <select name="client_id" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                            <option value="">Select Client</option>
                            @foreach($clients ?? [] as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} {{ $client->gstin ? '- ' . $client->gstin : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Invoice Date *</label>
                        <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" style="font-size:13px;">Due Date *</label>
                        <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+15 days')) }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">Invoice Type</label>
                        <select name="invoice_type" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                            <option value="gst_invoice">Tax Invoice</option>
                            <option value="bill_of_supply">Bill of Supply</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">Place of Supply</label>
                        <select name="place_of_supply" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                            <option value="intra_state">Intra-State (CGST + SGST)</option>
                            <option value="inter_state">Inter-State (IGST)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-list me-2 text-primary"></i>Line Items</h5>
                    <button type="button" class="btn btn-sm text-white" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:10px;" onclick="addItem()">
                        <i class="fas fa-plus me-1"></i> Add Item
                    </button>
                </div>
                <div id="items-container">
                    <div class="row g-2 item-row mb-2">
                        <div class="col-md-5">
                            <input type="text" name="items[0][name]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="Item name" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="items[0][hsn]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="HSN">
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="items[0][qty]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="Qty" value="1">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[0][rate]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="Rate" step="0.01">
                        </div>
                        <div class="col-md-2">
                            <select name="items[0][gst_rate]" class="form-select" style="border-radius:10px; border:1px solid #e2e8f0;">
                                <option value="18">18%</option>
                                <option value="5">5%</option>
                                <option value="12">12%</option>
                                <option value="28">28%</option>
                                <option value="0">0%</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Totals --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-calculator me-2 text-success"></i>Invoice Totals</h5>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Subtotal</span><span class="fw-semibold">₹0.00</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">CGST</span><span class="fw-semibold">₹0.00</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">SGST</span><span class="fw-semibold">₹0.00</span></div>
                <hr>
                <div class="d-flex justify-content-between"><span class="fw-bold">Grand Total</span><span class="fw-bold" style="color:#1e3a8a; font-size:18px;">₹0.00</span></div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <label class="form-label fw-semibold" style="font-size:13px;">Notes</label>
                <textarea name="notes" rows="3" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" placeholder="Additional notes..."></textarea>
            </div>
        </div>

        <button type="submit" class="btn text-white w-100" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:14px; font-weight:600; font-size:15px;">
            <i class="fas fa-save me-2"></i> Create Invoice
        </button>
    </div>
</form>

<script>
    let itemIndex = 1;

    function addItem() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'row g-2 item-row mb-2';
        row.innerHTML = `
        <div class="col-md-5"><input type="text" name="items[${itemIndex}][name]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="Item name"></div>
        <div class="col-md-2"><input type="text" name="items[${itemIndex}][hsn]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="HSN"></div>
        <div class="col-md-1"><input type="number" name="items[${itemIndex}][qty]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="Qty" value="1"></div>
        <div class="col-md-2"><input type="number" name="items[${itemIndex}][rate]" class="form-control" style="border-radius:10px; border:1px solid #e2e8f0;" placeholder="Rate" step="0.01"></div>
        <div class="col-md-2"><select name="items[${itemIndex}][gst_rate]" class="form-select" style="border-radius:10px; border:1px solid #e2e8f0;"><option value="18">18%</option><option value="5">5%</option><option value="12">12%</option><option value="28">28%</option><option value="0">0%</option></select></div>
    `;
        container.appendChild(row);
        itemIndex++;
    }
</script>
@endsection