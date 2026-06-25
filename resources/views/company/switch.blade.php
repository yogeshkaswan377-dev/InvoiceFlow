@extends('layouts.app')

@section('title', 'Switch Company - GST Billing Pro')
@section('meta_description', 'Switch between your registered companies to manage different businesses.')

@section('content')
<div class="mb-4">
    <h2 style="font-size:18px; font-weight:700; margin:0;">Switch Company</h2>
    <p style="color:#64748b; font-size:12px; margin:4px 0 0;">Select a company to manage</p>
</div>

<div class="row g-4">
    @forelse($companies ?? [] as $comp)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 {{ ($comp->id == session('current_company_id')) ? 'border-primary' : '' }}"
            style="transition:all 0.3s; {{ ($comp->id == session('current_company_id')) ? 'border:2px solid #3b82f6;' : '' }}">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px; height:52px; border-radius:14px; background:{{ ($comp->id == session('current_company_id')) ? 'linear-gradient(135deg, #1e3a8a, #3b82f6)' : 'linear-gradient(135deg, #e2e8f0, #cbd5e1)' }}; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:20px; color:{{ ($comp->id == session('current_company_id')) ? 'white' : '#64748b' }};">
                        {{ strtoupper(substr($comp->name, 0, 2)) }}
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $comp->name }}</h6>
                        <small class="text-muted">{{ $comp->gstin ?? 'No GSTIN' }}</small>
                    </div>
                    @if($comp->id == session('current_company_id'))
                    <span class="badge ms-auto" style="background:#d1fae5; color:#065f46;">Active</span>
                    @endif
                </div>

                @if($comp->id == session('current_company_id'))
                <button class="btn w-100" style="background:#f1f5f9; color:#64748b; border-radius:10px;" disabled>
                    <i class="fas fa-check-circle me-2"></i> Current Company
                </button>
                @else
                <a href="{{ route('company.switch-to', $comp->id) }}" class="btn text-white w-100" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:10px; font-weight:600; text-decoration:none;">
                    <i class="fas fa-exchange-alt me-2"></i> Switch to {{ $comp->name }}
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-building fa-3x d-block mb-3 opacity-25"></i>
        <h5 class="text-muted">No companies found</h5>
        <a href="{{ route('company.create') }}" class="btn text-white mt-2" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:10px; padding:8px 20px;">Add Your First Company</a>
    </div>
    @endforelse

    @if(count($companies ?? []) > 0)
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('company.create') }}" class="card border-dashed rounded-4 h-100 text-decoration-none" style="border:2px dashed #cbd5e1; transition:all 0.3s; display:flex; align-items:center; justify-content:center; min-height:180px;">
            <div class="text-center">
                <div style="width:52px; height:52px; border-radius:14px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:24px; color:#94a3b8; margin:0 auto 12px;">
                    <i class="fas fa-plus"></i>
                </div>
                <span style="color:#64748b; font-weight:600; font-size:14px;">Add New Company</span>
            </div>
        </a>
    </div>
    @endif
</div>
@endsection