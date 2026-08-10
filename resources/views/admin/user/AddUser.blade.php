<!-- Modal Add User -->
<div class="modal fade" id="addUserModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold" style="color: #0f172a; font-size: 16px;"><i class="bi bi-person-plus-fill me-2 text-success"></i>Add New User Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4" style="font-size: 13px;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Full Name</label>
                        <input type="text" name="name" class="form-control rounded" placeholder="e.g. John Doe" required style="font-size: 13px; height: 38px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">NIK (Nomor Induk Karyawan - Angka saja)</label>
                        <input type="text" name="nik" class="form-control rounded" placeholder="e.g. 123456" required style="font-size: 13px; height: 38px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">System Role</label>
                        <select name="role" class="form-select rounded" required style="font-size: 13px; height: 38px;">
                            <option value="Administrator" selected>Administrator</option>
                            <option value="PD">Project Developer (PD)</option>
                            <option value="QA">Quality Assurance (QA)</option>
                            <option value="PLANNER">Planner</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Digital Signature (Tanda Tangan)</label>
                        <input type="file" name="signature" class="form-control rounded" accept="image/png, image/jpeg, image/jpg, image/webp" style="font-size: 13px;">
                        <small class="text-muted" style="font-size: 11px;">* Format: PNG, JPG, JPEG, WEBP (Max. 2MB). Disarankan transparan (PNG).</small>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-secondary">Account Password</label>
                        <input type="password" name="password" class="form-control rounded" placeholder="Minimum 8 characters" required style="font-size: 13px; height: 38px;">
                    </div>
                </div>
                <div class="modal-footer border-top p-2 bg-light-subtle">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Cancel</button>
                    <button type="submit" class="btn btn-sm text-white px-3" style="background: linear-gradient(90deg, #7ED348 0%, #26B170 100%); border: none; border-radius: 6px;">Register User</button>
                </div>
            </form>
        </div>
    </div>
</div>