<!-- Modal Add User -->
<div class="modal fade @if($errors->any()) show @endif" id="addUserModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" @if($errors->any()) style="display: block;" @endif>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold" style="color: #0f172a; font-size: 16px;"><i class="bi bi-person-plus-fill me-2 text-success"></i>Add New User Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4" style="font-size: 13px;">
                    
                    <!-- FULL NAME -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Full Name</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="form-control rounded @error('name') is-invalid @enderror" 
                               placeholder="e.g. John Doe" 
                               required 
                               style="font-size: 13px; height: 38px;">
                        @error('name')
                            <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIK FIELD -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">NIK (Nomor Induk Karyawan)</label>
                        <input type="text" 
                               id="nikInput"
                               name="nik" 
                               value="{{ old('nik') }}" 
                               class="form-control rounded @error('nik') is-invalid @enderror" 
                               placeholder="e.g. 123456" 
                               required 
                               onkeyup="validateNikRealtime(this)"
                               onblur="validateNikRealtime(this)"
                               style="font-size: 13px; height: 38px;">
                        
                        <!-- ALERT BOX REALTIME (BOOTSTRAP STYLE) -->
                        <div id="nikAlert" class="alert alert-warning d-flex align-items-center py-2 px-3 mt-2 mb-0 rounded-2 d-none" role="alert" style="font-size: 12px;">
                            <i class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0" style="font-size: 14px;"></i>
                            <span id="nikAlertMessage"></span>
                        </div>

                        @error('nik')
                            <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                        @else
                            <small id="nikInfo" class="text-muted" style="font-size: 11px;">* Format: Wajib persis 6 digit angka.</small>
                        @enderror
                    </div>

                    <!-- SYSTEM ROLE -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">System Role</label>
                        <select name="role" class="form-select rounded @error('role') is-invalid @enderror" required style="font-size: 13px; height: 38px;">
                            <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="PD" {{ old('role') == 'PD' ? 'selected' : '' }}>Project Developer (PD)</option>
                            <option value="QA" {{ old('role') == 'QA' ? 'selected' : '' }}>Quality Assurance (QA)</option>
                            <option value="PLANNER" {{ old('role') == 'PLANNER' ? 'selected' : '' }}>Planner</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DIGITAL SIGNATURE -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Digital Signature (Tanda Tangan)</label>
                        <input type="file" 
                               name="signature" 
                               class="form-control rounded @error('signature') is-invalid @enderror" 
                               accept="image/png, image/jpeg, image/jpg, image/webp" 
                               style="font-size: 13px;">
                        @error('signature')
                            <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                        @else
                            <small class="text-muted" style="font-size: 11px;">* Format: PNG, JPG, JPEG, WEBP (Max. 2MB). Disarankan transparan (PNG).</small>
                        @enderror
                    </div>

                    <!-- ACCOUNT PASSWORD -->
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-secondary">Account Password</label>
                        <input type="password" 
                               name="password" 
                               class="form-control rounded @error('password') is-invalid @enderror" 
                               placeholder="Minimum 8 characters" 
                               required 
                               minlength="8" 
                               style="font-size: 13px; height: 38px;">
                        @error('password')
                            <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                        @enderror
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

<!-- SCRIPT VALIDASI REALTIME -->
<script>
function validateNikRealtime(input) {
    const val = input.value;
    const alertBox = document.getElementById('nikAlert');
    const alertMsg = document.getElementById('nikAlertMessage');
    const infoEl = document.getElementById('nikInfo');
    const isNumeric = /^\d+$/.test(val);

    // Reset State
    input.classList.remove('is-invalid', 'is-valid');
    alertBox.classList.add('d-none');
    if (infoEl) infoEl.classList.remove('d-none');

    if (val.length === 0) {
        return;
    }

    // 1. Mengandung karakter non-angka
    if (!isNumeric) {
        input.classList.add('is-invalid');
        alertMsg.innerText = 'Peringatan Format: NIK hanya boleh berisi karakter angka.';
        alertBox.classList.remove('d-none');
        if (infoEl) infoEl.classList.add('d-none');
        return;
    }

    // 2. Kurang dari 6 digit
    if (val.length < 6) {
        input.classList.add('is-invalid');
        alertMsg.innerText = `Peringatan Panjang Digit: NIK saat ini ${val.length} digit (Membutuhkan ${6 - val.length} digit lagi).`;
        alertBox.classList.remove('d-none');
        if (infoEl) infoEl.classList.add('d-none');
        return;
    }

    // 3. Lebih dari 6 digit
    if (val.length > 6) {
        input.classList.add('is-invalid');
        alertMsg.innerText = `Peringatan Panjang Digit: NIK melebihi batas (${val.length} digit, maksimal 6 digit).`;
        alertBox.classList.remove('d-none');
        if (infoEl) infoEl.classList.add('d-none');
        return;
    }

    // 4. Valid (Tepat 6 digit angka)
    input.classList.add('is-valid');
}
</script>