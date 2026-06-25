<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4"><i class="fas fa-percent me-2 text-success"></i>GST Settings</h5>

        <form action="{{ route('company.gst.update') }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">GSTIN *</label>
                    <input type="text" name="gstin" value="{{ old('gstin', $company->gstin ?? '') }}" class="form-control text-uppercase" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" maxlength="15" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">PAN</label>
                    <input type="text" name="pan" value="{{ old('pan', $company->pan ?? '') }}" class="form-control text-uppercase" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" maxlength="10">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Default GST Rate (%)</label>
                    <select name="default_gst_rate" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                        @foreach([0,5,12,18,28] as $rate)
                        <option value="{{ $rate }}" {{ ($company->default_gst_rate ?? 18) == $rate ? 'selected' : '' }}>{{ $rate }}%</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Tax Mode</label>
                    <select name="gst_mode" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                        <option value="exclusive" {{ ($company->gst_mode ?? 'exclusive') == 'exclusive' ? 'selected' : '' }}>Tax Exclusive</option>
                        <option value="inclusive" {{ ($company->gst_mode ?? '') == 'inclusive' ? 'selected' : '' }}>Tax Inclusive</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn text-white" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:10px 24px; font-weight:600;">
                    <i class="fas fa-save me-2"></i> Save GST Settings
                </button>
            </div>
        </form>
    </div>
</div>