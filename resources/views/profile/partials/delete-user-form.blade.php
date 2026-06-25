<div class="card border-danger rounded-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Delete Account</h5>
        <p style="font-size:13px; color:#64748b; margin-bottom:16px;">
            Once your account is deleted, all of its resources and data will be permanently deleted.
            Before deleting your account, please download any data you wish to keep.
        </p>

        <button class="btn btn-outline-danger" style="border-radius:10px; font-weight:600;" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class="fas fa-trash me-2"></i> Delete Account
        </button>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="fw-bold text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13px; color:#64748b;">
                    Are you sure you want to delete your account? This action <strong>cannot be undone</strong>.
                    Please enter your password to confirm.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf @method('DELETE')

                    <label class="form-label fw-semibold" style="font-size:13px;">Password *</label>
                    <input type="password" name="password" class="form-control" style="border-radius:12px; border:1px solid #e2e8f0; padding:10px 14px;" required>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="button" class="btn" style="background:#f1f5f9; border-radius:10px;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" style="border-radius:10px;">
                            <i class="fas fa-trash me-2"></i> Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>