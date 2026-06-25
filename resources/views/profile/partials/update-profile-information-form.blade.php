<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4"><i class="fas fa-user-circle me-2 text-primary"></i>Profile Information</h5>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf @method('PATCH')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Name *</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Email *</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:13px;">Timezone</label>
                    <select name="timezone" class="form-select" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;">
                        <option value="Asia/Kolkata" {{ (auth()->user()->timezone ?? 'Asia/Kolkata') == 'Asia/Kolkata' ? 'selected' : '' }}>IST (India)</option>
                        <option value="Asia/Dubai">GST (Dubai)</option>
                        <option value="America/New_York">EST (New York)</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn text-white" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:10px 24px; font-weight:600;">
                    <i class="fas fa-save me-2"></i> Save
                </button>
                @if(session('status') === 'profile-updated')
                <span class="text-success ms-2" style="font-size:13px;">
                    <i class="fas fa-check-circle me-1"></i> Saved!
                </span>
                @endif
            </div>
        </form>
    </div>
</div>