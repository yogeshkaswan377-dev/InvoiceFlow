@extends('layouts.app')

@section('title', 'Settings - GST Billing Pro')

@section('content')
<div class="mb-4">
    <h2 style="font-size:18px; font-weight:700; margin:0;">Settings</h2>
    <p style="color:#64748b; font-size:12px; margin:4px 0 0;">Manage your account and company settings</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        @include('settings.partials.basic-info')
        @include('settings.partials.gst-settings')
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-shield-alt me-2 text-success"></i>Quick Links</h5>
                <div class="list-group list-group-flush">
                    <a href="{{ route('company.settings') }}" class="list-group-item border-0 px-0" style="font-size:13px;">
                        <i class="fas fa-building me-2"></i> Company Settings
                    </a>
                    <a href="{{ route('profile.edit') }}" class="list-group-item border-0 px-0" style="font-size:13px;">
                        <i class="fas fa-user me-2"></i> My Profile
                    </a>
                    <a href="{{ route('company.switch') }}" class="list-group-item border-0 px-0" style="font-size:13px;">
                        <i class="fas fa-exchange-alt me-2"></i> Switch Company
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection