<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4"><i class="fas fa-info-circle me-2 text-primary"></i>Basic Information</h5>

        <form action="{{ route('company.settings.update') }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Company Name *</label>
                    <input type="text" name="name" value="{{ old('name', $company->name ?? '') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Trade Name</label>
                    <input type="text" name="trade_name" value="{{ old('trade_name', $company->trade_name ?? '') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $company->email ?? '') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $company->phone ?? '') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold" style="font-size:13px;">Address</label>
                    <textarea name="address" rows="2" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">{{ old('address', $company->address ?? '') }}</textarea>
                </div>
                <div class="col-md-4">
                    <input type="text" name="city" value="{{ old('city', $company->city ?? '') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" placeholder="City">
                </div>
                <div class="col-md-4">
                    <input type="text" name="state" value="{{ old('state', $company->state ?? '') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" placeholder="State">
                </div>
                <div class="col-md-4">
                    <input type="text" name="pincode" value="{{ old('pincode', $company->pincode ?? '') }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" placeholder="Pincode">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn text-white" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:10px 24px; font-weight:600;">
                    <i class="fas fa-save me-2"></i> Save Information
                </button>
            </div>
        </form>
    </div>
</div>