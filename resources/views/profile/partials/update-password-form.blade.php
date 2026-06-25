<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4"><i class="fas fa-lock me-2 text-warning"></i>Update Password</h5>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:13px;">Current Password *</label>
                    <input type="password" name="current_password" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:13px;">New Password *</label>
                    <input type="password" name="password" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:13px;">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn text-white" style="background:linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius:12px; padding:10px 24px; font-weight:600;">
                    <i class="fas fa-key me-2"></i> Update Password
                </button>
                @if(session('status') === 'password-updated')
                <span class="text-success ms-2" style="font-size:13px;">
                    <i class="fas fa-check-circle me-1"></i> Updated!
                </span>
                @endif
            </div>
        </form>
    </div>
</div>