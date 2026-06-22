@extends('layouts.admin')

@section('title', 'Management User')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

@vite(['resources/css/user_management.css'])

<div class="directory-container container-fluid px-0">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; font-size: 13px;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; font-size: 13px;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="main-header-card d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="font-size: 26px; color: #0f172a;">People Directory</h1>
            <p class="text-muted mb-0" style="font-size: 13.5px;">Manage member access, lifecycle status, and team distribution from one control surface.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm px-3 fw-medium d-flex align-items-center gap-2" style="background: #2563eb; border: none; border-radius: 8px; height: 38px;" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa-solid fa-plus"></i> Add User
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="directory-card shadow-sm">
                
                <div class="p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom">
                    <div class="nav-segment">
                        <button class="btn-tab active">All <span class="tab-count">{{ $users->total() }}</span></button>
                        <button class="btn-tab">Active <span class="tab-count">{{ $users->total() }}</span></button>
                        <button class="btn-tab">Pending <span class="tab-count">0</span></button>
                        <button class="btn-tab">Inactive <span class="tab-count">0</span></button>
                    </div>
                    <div class="d-flex gap-2 justify-content-md-end w-100" style="max-width: 400px;">
                        <div class="search-input-group">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" class="form-control" placeholder="Search users, role...">
                        </div>
                        
                        <div class="dropdown">
                            <button class="btn-filter-role d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-sliders"></i> Role
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 13px; border-radius: 8px;">
                                <li><a class="dropdown-item filter-role-opt" href="#" data-role="all">All Roles</a></li>
                                <li><a class="dropdown-item filter-role-opt" href="#" data-role="Administrator">Administrator</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="table-responsive" style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table class="table dir-table align-middle mb-0" style="min-width: 850px;">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th style="min-width: 200px;">Name</th>
                                <th style="width: 120px;">Nik</th>
                                <th style="width: 150px;">Role</th>
                                <th style="width: 140px;">Joined</th>
                                <th class="text-end pe-4" style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-user-slash fs-4 d-block mb-2 text-secondary"></i>
                                        No users linked in db_sample_app.
                                    </td>
                                </tr>
                            @endif
                            @foreach($users as $index => $user)
                            <tr>
                                <td class="ps-4 fw-medium text-secondary" style="font-size: 13px;">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="user-avatar d-flex align-items-center justify-content-center bg-light text-primary fw-bold" style="font-size: 13px; border: 1px solid #e2e8f0; width: 36px; height: 36px; flex-shrink: 0;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark mb-0" style="font-size: 14px;">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary fw-medium" style="font-size: 12.5px;">{{ $user->nik }}</span>
                                </td>
                                <td>
                                    <span class="badge-role admin" style="white-space: nowrap;">
                                        <i class="fa-solid fa-user-gear" style="font-size: 10px; margin-right: 6px;"></i>{{ $user->role ?: 'Administrator' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 12.5px; white-space: nowrap;">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        <a href="#" class="btn d-inline-flex align-items-center justify-content-center p-0" title="View details" style="width: 32px; height: 32px; background-color: #2563eb; color: #ffffff; border-radius: 6px; font-size: 13px;">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn d-inline-flex align-items-center justify-content-center p-0" title="Edit" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" style="width: 32px; height: 32px; background-color: #eab308; color: #ffffff; border-radius: 6px; font-size: 13px;">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="m-0 d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn d-inline-flex align-items-center justify-content-center p-0" title="Delete" style="width: 32px; height: 32px; background-color: #ef4444; color: #ffffff; border: none; border-radius: 6px; font-size: 13px;">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editUserModal{{ $user->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                                        <div class="modal-header border-bottom p-3">
                                            <h5 class="modal-title fw-bold" style="color: #0f172a; font-size: 16px;"><i class="fa-regular fa-pen-to-square me-2 text-primary"></i>Edit User Account</h5>
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
                                                        <option value="Administrator" selected>Administrator</option>
                                                    </select>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold text-secondary">Password <small class="text-muted fw-normal">(Leave blank to keep current)</small></label>
                                                    <input type="password" name="password" class="form-control rounded" placeholder="••••••••" style="font-size: 13px; height: 38px;">
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top p-2 bg-light-subtle">
                                                <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-primary px-3" style="background-color: #2563eb; border: none; border-radius: 6px;">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3 d-flex flex-column flex-sm-row justify-content-between align-items-center border-top bg-light-subtle gap-3" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <div class="text-muted" style="font-size: 13px;">
                        Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                    </div>
                    <div class="dir-pagination">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            
            <div class="widget-box shadow-sm">
                <div class="widget-title">Directory Snapshot</div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-grid-card">
                            <div class="stat-label">Total</div>
                            <div class="stat-val">{{ $users->total() }}</div>
                            <div class="stat-sub">+2 this month</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-grid-card" style="background: #f0fdf4;">
                            <div class="stat-label" style="color: #16a34a;">Active</div>
                            <div class="stat-val" style="color: #16a34a;">{{ $users->total() }}</div>
                            <div class="stat-sub" style="color: #16a34a;">100% engagement</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-grid-card" style="background: #fffbeb;">
                            <div class="stat-label" style="color: #d97706;">Pending</div>
                            <div class="stat-val">0</div>
                            <div class="stat-sub">Needs onboarding</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-grid-card">
                            <div class="stat-label">Inactive</div>
                            <div class="stat-val">0</div>
                            <div class="stat-sub">Clean record</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-box shadow-sm">
                <div class="widget-title">Role Distribution</div>
                <div class="mb-3">
                    <div class="prog-label-row">
                        <span style="color: #475569;">Administrator</span>
                        <span class="fw-bold">{{ $users->total() }}</span>
                    </div>
                    <div class="progress progress-thin">
                        <div class="progress-bar" style="width: 100%; background-color: #2563eb;"></div>
                    </div>
                </div>
            </div>

            <div class="widget-box shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="widget-title mb-0">Recently Added</div>
                    <a href="#" class="text-primary fw-semibold" style="font-size: 12px; text-decoration: none;">View all</a>
                </div>
                
                <div class="d-flex flex-column gap-3">
                    @foreach($users->take(3) as $latestUser)
                    <div class="d-flex align-items-center gap-3">
                        <div class="user-avatar d-flex align-items-center justify-content-center bg-light text-secondary fw-semibold" style="width: 34px; height: 34px; font-size: 11px;">
                            {{ strtoupper(substr($latestUser->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="fw-semibold text-dark" style="font-size: 13px;">{{ $latestUser->name }}</div>
                            <div class="text-muted" style="font-size: 11px;">Joined recently • {{ $latestUser->role ?: 'Administrator' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fw-bold" style="color: #0f172a; font-size: 16px;"><i class="fa-solid fa-user-plus me-2 text-primary"></i>Add New User Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4" style="font-size: 13px;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Full Name</label>
                        <input type="text" name="name" class="form-control rounded" placeholder="e.g. John Doe" required style="font-size: 13px; height: 38px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">NIK (Nomor Induk Karyawan)</label>
                        <input type="text" name="nik" class="form-control rounded" placeholder="e.g. 12345678" required style="font-size: 13px; height: 38px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">System Role</label>
                        <select name="role" class="form-select rounded" required style="font-size: 13px; height: 38px;">
                            <option value="Administrator" selected>Administrator</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-secondary">Account Password</label>
                        <input type="password" name="password" class="form-control rounded" placeholder="Minimum 8 characters" required style="font-size: 13px; height: 38px;">
                    </div>
                </div>
                <div class="modal-footer border-top p-2 bg-light-subtle">
                    <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal" style="border-radius: 6px;">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary px-3" style="background-color: #2563eb; border: none; border-radius: 6px;">Register User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@vite(['resources/js/user_management.js'])

@endsection