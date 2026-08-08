<div class="d-inline-flex justify-content-center align-items-center gap-2 px-2">
    <!-- 1. Preview Icon Button -->
    <button type="button" class="action-btn btn-preview" title="Preview" data-bs-toggle="modal" data-bs-target="#previewUserModal{{ $user->id }}">
        <i class="bi bi-eye-fill"></i>
    </button>

    <!-- 2. Edit Icon Button -->
    <button type="button" class="action-btn btn-edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
        <i class="bi bi-pencil-square"></i>
    </button>
    
    <!-- 3. Delete Icon Button -->
    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="m-0 d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="action-btn btn-delete" title="Delete">
            <i class="bi bi-trash-fill"></i>
        </button>
    </form>
</div>

<!-- Modal Preview User -->
<div class="modal fade text-start" id="previewUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom p-3 bg-light">
                <h5 class="modal-title fw-bold" style="color: #0f172a; font-size: 16px;"><i class="bi bi-card-heading me-2 text-info"></i>User Detail Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="font-size: 13px;">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light text-success fw-bold rounded-circle mb-2" style="font-size: 22px; border: 2px solid #26B170; width: 64px; height: 64px;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                    <span class="badge-role {{ strtolower($user->role) }}">{{ $user->role }}</span>
                </div>
                <div class="p-3 bg-light rounded-3 border">
                    <div class="row g-2">
                        <div class="col-5 text-muted">NIK / ID:</div>
                        <div class="col-7 fw-bold text-dark">{{ $user->nik }}</div>

                        <div class="col-5 text-muted">System Role:</div>
                        <div class="col-7 fw-bold text-dark">{{ $user->role }}</div>

                        <div class="col-5 text-muted">Created At:</div>
                        <div class="col-7 text-dark">{{ $user->created_at ? $user->created_at->format('d F Y, H:i') : '-' }}</div>

                        <div class="col-5 text-muted">Updated At:</div>
                        <div class="col-7 text-dark">{{ $user->updated_at ? $user->updated_at->format('d F Y, H:i') : '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top p-2 bg-light">
                <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade text-start" id="editUserModal{{ $user->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold" style="color: #0f172a; font-size: 16px;"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit User Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4" style="font-size: 13px;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Full Name</label>
                        <input type="text" name="name" class="form-control rounded" value="{{ $user->name }}" required style="font-size: 13px; height: 38px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">NIK (Nomor Induk Karyawan)</label>
                        <input type="text" name="nik" class="form-control rounded" value="{{ $user->nik }}" required style="font-size: 13px; height: 38px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">System Role</label>
                        <select name="role" class="form-select rounded" required style="font-size: 13px; height: 38px;">
                            <option value="Administrator" {{ $user->role == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="PD" {{ $user->role == 'PD' ? 'selected' : '' }}>PD</option>
                            <option value="QA" {{ $user->role == 'QA' ? 'selected' : '' }}>QA</option>
                            <option value="PLANNER" {{ $user->role == 'PLANNER' ? 'selected' : '' }}>PLANNER</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-secondary">Password <small class="text-muted fw-normal">(Opsional, kosongi jika tidak diubah)</small></label>
                        <input type="password" name="password" class="form-control rounded" placeholder="••••••••" style="font-size: 13px; height: 38px;">
                    </div>
                </div>
                <div class="modal-footer border-top p-2 bg-light-subtle">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-3" style="background-color: #26B170; border: none; border-radius: 6px;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>