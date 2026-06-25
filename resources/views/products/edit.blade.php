@extends('layouts.app')

@section('title', 'Edit Product - GST Billing Pro')
@section('meta_description', 'Update product details, HSN/SAC codes, GST rates and pricing.')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-sm" style="background:#f1f5f9; border-radius:10px; color:#64748b;">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h2 style="font-size:18px; font-weight:700; margin:0;">Edit Product: {{ $product->name }}</h2>
</div>

<form action="{{ route('products.update', $product) }}" method="POST" class="row g-4">
    @csrf
    @method('PUT')

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Product Information</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">Product Name *</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">HSN/SAC Code</label>
                        <input type="text" name="hsn_sac_code" value="{{ $product->hsn_sac_code }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:13px;">Type *</label>
                        <select name="type" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                            <option value="goods" {{ $product->type === 'goods' ? 'selected' : '' }}>Goods (HSN)</option>
                            <option value="service" {{ $product->type === 'service' ? 'selected' : '' }}>Service (SAC)</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" style="font-size:13px;">Description</label>
                        <textarea name="description" rows="3" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">{{ $product->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Pricing & GST</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:13px;">Unit Price (₹) *</label>
                    <input type="number" name="unit_price" value="{{ $product->unit_price }}" step="0.01" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:13px;">GST Rate (%) *</label>
                    <select name="gst_rate" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                        @foreach([0,5,12,18,28] as $rate)
                        <option value="{{ $rate }}" {{ $product->gst_rate == $rate ? 'selected' : '' }}>{{ $rate }}%</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn text-white w-100" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:12px; font-weight:600;">
                    <i class="fas fa-save me-2"></i> Update Product
                </button>
            </div>
        </div>
    </div>
</form>
@endsection