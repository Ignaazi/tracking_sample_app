@extends('layouts.admin')

@section('title', 'Management User')

@section('content')

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark mb-1" style="font-size: 24px;">Management User</h1>
        <p class="text-muted mb-0" style="font-size: 13px;">Manage system users, application access roles, and account privileges.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="background-color: #e1fcef; color: #0f5132; font-size: 13px;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="background-color: #fde1e1; color: #842029; font-size: 13px;">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="font-size: 13px;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold" style="color: #012970; font-size: 16px;">
                <i class="fa-solid fa-users-gear me-2 text-primary"></i>User Accounts List
            </h5>
            <button type="button" class="btn btn-primary btn-sm rounded px-3 fw-bold d-flex align-items-center gap-2" style="font-size: 12px; background-color: #4154f1; border-color: #4154f1;" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa-solid fa-plus"></i> Add New User
            </button>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                    <thead class="table-light text-muted" style="font-size: 12px; text-transform: uppercase;">
                        <tr>
                            <th class="ps-3 py-3" style="width: 50px;">#</th>
                            <th>Full Name</th>
                            <th>NIK (Employee ID)</th>
                            <th>Role Access</th>
                            <th class="pe-3 text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-user-slash fs-3 d-block mb-2 text-secondary"></i>
                                    No users found in the database.
                                </td>
                            </tr>
                        @endif
                        @foreach($users as $index => $user)
                        <tr>
                            <td class="ps-3 text-secondary font-monospace">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; font-size: 12px;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-secondary font-monospace fw-bold">{{ $user->nik }}</td>
                            <td>
                                @if($user->role == 'Costing')
                                    <span class="badge px-2 py-1.5 rounded-pill" style="background-color: #e1fcef; color: #0f5132; font-size: 11px;">Costing</span>
                                @elseif($user->role == 'Engineering')
                                    <span class="badge px-2 py-1.5 rounded-pill" style="background-color: #eef2ff; color: #4154f1; font-size: 11px;">Engineering</span>
                                @elseif($user->role == 'Production')
                                    <span class="badge px-2 py-1.5 rounded-pill" style="background-color: #fff3bf; color: #664d03; font-size: 11px;">Production</span>
                                @else
                                    <span class="badge px-2 py-1.5 rounded-pill bg-light text-secondary border" style="font-size: 11px;">{{ $user->role }}</span>
                                @endif
                            </td>
                            <td class="pe-3 text-end">
                                <div class="d-inline-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary border-0 p-1 px-2" title="Edit User" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1 px-2" title="Delete User">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editUserModal{{ $user->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-0 bg-light py-3">
                                        <h5 class="modal-title fw-bold" style="color: #012970; font-size: 16px;"><i class="fa-regular fa-pen-to-square me-2"></i>Edit User Account</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4" style="font-size: 13px;">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">Full Name</label>
                                                <input type="text" name="name" class="form-control form-control-sm rounded" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">NIK (Nomor Induk Karyawan)</label>
                                                <input type="text" name="nik" class="form-control form-control-sm rounded font-monospace" value="{{ $user->nik }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">System Role</label>
                                                <select name="role" class="form-select form-select-sm rounded" required>
                                                    <option value="Costing" {{ $user->role == 'Costing' ? 'selected' : '' }}>Costing</option>
                                                    <option value="Engineering" {{ $user->role == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                                                    <option value="Production" {{ $user->role == 'Production' ? 'selected' : '' }}>Production</option>
                                                </select>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-bold text-secondary">Password <small class="text-muted fw-normal">(Leave blank to keep current)</small></label>
                                                <input type="password" name="password" class="form-control form-control-sm rounded" placeholder="••••••••">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-light-subtle py-2">
                                            <button type="button" class="btn btn-sm btn-secondary rounded px-3" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-primary rounded px-3" style="background-color: #4154f1;">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light py-3">
                    <h5 class="modal-title fw-bold" style="color: #012970; font-size: 16px;"><i class="fa-solid fa-user-plus me-2"></i>Add New User Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4" style="font-size: 13px;">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-sm rounded" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">NIK (Nomor Induk Karyawan)</label>
                            <input type="text" name="nik" class="form-control form-control-sm rounded font-monospace" placeholder="e.g. 12345678" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">System Role</label>
                            <select name="role" class="form-select form-select-sm rounded" required>
                                <option value="" selected disabled>-- Select Access Role --</option>
                                <option value="Costing">Costing (Purchase Requests & Stock Depleted)</option>
                                <option value="Engineering">Engineering (Nozzles, Racks, & Barcode Stock)</option>
                                <option value="Production">Production (Line Requests & Item In)</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold text-secondary">Account Password</label>
                            <input type="password" name="password" class="form-control form-control-sm rounded" placeholder="Minimum 8 characters" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light-subtle py-2">
                        <button type="button" class="btn btn-sm btn-secondary rounded px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary rounded px-3" style="background-color: #4154f1;">Register User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection