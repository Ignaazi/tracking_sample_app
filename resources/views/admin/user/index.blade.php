@extends('layouts.admin')

@section('title', 'Management User')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<!-- BOOTSTRAP ICONS CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@vite(['resources/css/user_management.css'])

<style>
    /* Konsistensi Font Nunito */
    .directory-container, 
    .directory-container *, 
    .modal, 
    .modal * {
        font-family: 'Nunito', sans-serif !important;
    }

    /* Header Grid Utama Tebal dengan Motif Batik */
    .header-green-grid {
        background-color: #064e3b; /* Hijau Pekat Solid (Tidak Transparan) */
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2310b981' fill-opacity='0.12' fill-rule='evenodd'%3E%3Cpath d='M30 30L15 15l15-15 15 15-15 15zm0 0l15 15-15 15-15-15 15-15zm-15 0L0 15l15-15 15 15-15 15zm30 0l15-15 15 15-15 15-15-15z'/%3E%3C/g%3E%3C/svg%3E");
        border: 1px solid #047857;
        border-radius: 8px; /* Tumpul Sedikit */
        padding: 22px 28px;
        box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);
    }

    /* Outer Card Wrapper (Kotak dengan Sudut Sedikit Tumpul) */
    .bordered-grid-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px; /* Tumpul Sedikit */
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    /* Tabel Header Warna Hijau Tua */
    .table-dark-green-header th {
        background-color: #064e3b !important;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #047857 !important;
    }

    /* Styling Badge Role */
    .badge-role {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-role.administrator { background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
    .badge-role.pd { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-role.qa { background-color: #fce7f3; color: #9d174d; border: 1px solid #fbcfe8; }
    .badge-role.planner { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }

    /* Custom Filter Dropdown Button Style Clean */
    .role-dropdown-btn {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        font-weight: 700;
        font-size: 13px;
        border-radius: 6px;
        padding: 7px 14px;
        transition: all 0.2s ease;
    }
    .role-dropdown-btn:hover, .role-dropdown-btn:focus {
        background-color: #26B170;
        color: #ffffff;
        border-color: #26B170;
    }

    /* Tombol Aksi Gradient Style */
    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 6px;
        font-size: 14px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        opacity: 0.95;
    }

    /* Gradient Warna Aksi */
    .btn-preview { 
        background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%); 
    }
    .btn-edit { 
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); 
    }
    .btn-delete { 
        background: linear-gradient(135deg, #f87171 0%, #dc2626 100%); 
    }

    /* Style Card Snapshot Minimalis */
    .snapshot-item {
        background-color: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        padding: 16px;
    }
    .snapshot-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
</style>

<div class="directory-container container-fluid px-0">
    
    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; font-size: 13px; border-radius: 8px; border-left: 4px solid #26B170 !important;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alert Error -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; font-size: 13px; border-radius: 8px; border-left: 4px solid #ef4444 !important;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Header Card (Tebal Solid + Motif Batik) -->
    <div class="header-green-grid d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="fw-extrabold mb-1" style="font-size: 24px; color: #ffffff;">People Directory</h1>
            <p class="mb-0" style="font-size: 13.5px; color: #a7f3d0;">Kelola hak akses pengguna, peran sistem, dan distribusi tim dari satu panel kontrol.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Tabel User & Kontrol -->
        <div class="col-xl-9 col-lg-8">
            <div class="bordered-grid-card">
                
                <!-- Toolbar Atas -->
                <div class="p-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom bg-light">
                    
                    <!-- 1. Filter Role Popup Dropdown -->
                    <div class="dropdown">
                        <button class="btn role-dropdown-btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="filterRoleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel-fill text-success"></i>
                            <span id="selectedRoleLabel">All Roles</span>
                            <span class="badge bg-success text-white ms-1 rounded-pill" id="count-all">{{ $users->total() }}</span>
                        </button>
                        <ul class="dropdown-menu shadow border-0" aria-labelledby="filterRoleDropdown" style="font-size: 13px; border-radius: 8px;">
                            <li><a class="dropdown-item filter-tab-option fw-semibold" href="#" data-role="all"><i class="bi bi-people-fill me-2 text-primary"></i>All Roles</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item filter-tab-option fw-semibold" href="#" data-role="Administrator"><i class="bi bi-shield-lock-fill me-2 text-primary"></i>Administrator</a></li>
                            <li><a class="dropdown-item filter-tab-option fw-semibold" href="#" data-role="PD"><i class="bi bi-gear-wide-connected me-2 text-warning"></i>PD</a></li>
                            <li><a class="dropdown-item filter-tab-option fw-semibold" href="#" data-role="QA"><i class="bi bi-patch-check-fill me-2 text-danger"></i>QA</a></li>
                            <li><a class="dropdown-item filter-tab-option fw-semibold" href="#" data-role="PLANNER"><i class="bi bi-journal-text me-2 text-info"></i>PLANNER</a></li>
                        </ul>
                    </div>

                    <!-- 2. Live Search & 3. Button Add User (Gradient) -->
                    <div class="d-flex gap-2 align-items-center w-100 w-md-auto">
                        <div class="position-relative flex-grow-1" style="min-width: 180px;">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 13px;"></i>
                            <input type="text" id="userSearchInput" class="form-control form-control-sm ps-5 rounded-2 border" placeholder="Search users, NIK..." style="font-size: 13px; height: 38px;">
                        </div>
                        
                        <button class="btn btn-sm text-white fw-bold d-flex align-items-center gap-2 px-3 text-nowrap shadow-sm" style="background: linear-gradient(135deg, #7ED348 0%, #26B170 100%); border: none; border-radius: 6px; height: 38px; font-size: 13px;" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus-fill"></i> Add User
                        </button>
                    </div>
                </div>

                <!-- Tabel User -->
                <div class="table-responsive" style="width: 100%; overflow-x: auto;">
                    <table class="table dir-table align-middle mb-0" id="userDirectoryTable" style="min-width: 880px;">
                        <thead class="table-dark-green-header">
                            <tr>
                                <th style="width: 50px;" class="ps-4">No</th>
                                <th style="min-width: 170px;">Name</th>
                                <th style="width: 110px;">NIK</th>
                                <th style="width: 130px;">Role</th>
                                <th style="width: 120px;">Created At</th>
                                <th style="width: 120px;">Updated At</th>
                                <th class="text-center pe-4" style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->isEmpty())
                                <tr id="noDataRow">
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-person-x fs-4 d-block mb-2 text-secondary"></i>
                                        No users registered in system.
                                    </td>
                                </tr>
                            @endif

                            @foreach($users as $index => $user)
                            <tr class="user-row" data-role="{{ $user->role }}" data-search="{{ strtolower($user->name . ' ' . $user->nik . ' ' . $user->role) }}">
                                <td class="ps-4 fw-medium text-secondary" style="font-size: 13px;">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="user-avatar d-flex align-items-center justify-content-center bg-light text-success fw-bold rounded-circle" style="font-size: 13px; border: 1.5px solid #26B170; width: 36px; height: 36px; flex-shrink: 0;">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0" style="font-size: 14px;">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary fw-semibold" style="font-size: 12.5px;">{{ $user->nik }}</span>
                                </td>
                                <td>
                                    @php
                                        $roleClass = strtolower($user->role ?: 'administrator');
                                    @endphp
                                    <span class="badge-role {{ $roleClass }}">
                                        <i class="bi bi-shield-check"></i>{{ $user->role ?: 'Administrator' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 12.5px; white-space: nowrap;">{{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}</span>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 12.5px; white-space: nowrap;">{{ $user->updated_at ? $user->updated_at->format('M d, Y') : '-' }}</span>
                                </td>
                                <td class="text-center pe-4">
                                    <!-- Include Action Component -->
                                    @include('admin.user.ActionTableUser')
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                <div class="p-3 d-flex flex-column flex-sm-row justify-content-between align-items-center border-top bg-light-subtle gap-3">
                    <div class="text-muted" style="font-size: 13px;">
                        Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                    </div>
                    <div class="dir-pagination">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>

            </div>
        </div>

        <!-- Kolom Kanan: Directory Snapshot -->
        <div class="col-xl-3 col-lg-4">
            <div class="bordered-grid-card p-4">
                <h6 class="fw-bold mb-3" style="color: #0f172a; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Directory Snapshot</h6>
                <div class="d-flex flex-column gap-3">
                    
                    <!-- Total Users -->
                    <div class="snapshot-item">
                        <div class="text-uppercase fw-bold text-muted mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Total Users</div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="snapshot-icon" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <div class="fw-extrabold text-dark" style="font-size: 26px; font-weight: 800; line-height: 1;">{{ $users->total() }}</div>
                                <div class="text-muted mt-1" style="font-size: 12px;"><i class="bi bi-shield-check text-info me-1"></i>System Accounts</div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Users -->
                    <div class="snapshot-item" style="background-color: #f0fdf4; border-color: #dcfce7;">
                        <div class="text-uppercase fw-bold text-muted mb-2" style="font-size: 11px; letter-spacing: 0.5px; color: #166534 !important;">Active Users</div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="snapshot-icon" style="background-color: #dcfce7; color: #16a34a;">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <div class="fw-extrabold" style="font-size: 26px; font-weight: 800; color: #14532d; line-height: 1;">{{ $users->total() }}</div>
                                <div class="fw-semibold mt-1" style="font-size: 12px; color: #15803d;"><i class="bi bi-check-all me-1"></i>100% Deployed</div>
                            </div>
                        </div>
                    </div>

                    <!-- Inactive Users -->
                    <div class="snapshot-item" style="background-color: #fef2f2; border-color: #fee2e2;">
                        <div class="text-uppercase fw-bold text-muted mb-2" style="font-size: 11px; letter-spacing: 0.5px; color: #991b1b !important;">Inactive Users</div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="snapshot-icon" style="background-color: #fee2e2; color: #dc2626;">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>
                            <div>
                                <div class="fw-extrabold" style="font-size: 26px; font-weight: 800; color: #7f1d1d; line-height: 1;">0</div>
                                <div class="fw-semibold mt-1" style="font-size: 12px; color: #b91c1c;"><i class="bi bi-dash-circle me-1"></i>No Inactive</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modal Add User -->
@include('admin.user.AddUser')

<!-- Script Live Filter & Search Engine -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("userSearchInput");
    const filterOptions = document.querySelectorAll(".filter-tab-option");
    const selectedRoleLabel = document.getElementById("selectedRoleLabel");
    const userRows = document.querySelectorAll(".user-row");

    let activeRole = "all";

    function filterTable() {
        const query = searchInput.value.toLowerCase().trim();

        userRows.forEach(row => {
            const rowRole = row.getAttribute("data-role");
            const searchData = row.getAttribute("data-search");

            const matchesRole = (activeRole === "all") || (rowRole === activeRole);
            const matchesSearch = searchData.includes(query);

            if (matchesRole && matchesSearch) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    filterOptions.forEach(option => {
        option.addEventListener("click", function (e) {
            e.preventDefault();
            activeRole = this.getAttribute("data-role");
            
            if (activeRole === 'all') {
                selectedRoleLabel.textContent = 'All Roles';
            } else {
                selectedRoleLabel.textContent = 'Role: ' + activeRole;
            }

            filterTable();
        });
    });

    searchInput.addEventListener("keyup", filterTable);
});
</script>

@vite(['resources/js/user_management.js'])

@endsection