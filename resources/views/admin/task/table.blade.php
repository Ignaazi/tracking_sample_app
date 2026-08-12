@extends('layouts.admin')

@section('title', 'Data Project Status - NiceAdmin')

@push('styles')
<!-- Bootstrap Icons & Google Fonts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    .workspace-container, .workspace-container * {
        font-family: 'Nunito', sans-serif !important;
    }

    /* STYLING TABEL KOTAK-KOTAK LEBIH LEGA & PANJANG */
    .table-custom-grid {
        table-layout: auto !important;
        width: 100%;
        min-width: 5000px;
        border-collapse: collapse !important;
        font-family: 'Nunito', sans-serif !important;
    }

    /* HEADER TABEL UTAMA (KOLOM 1-28) - HIJAU TUA */
    .table-custom-grid thead th {
        background-color: #005236 !important;
        color: #ffffff !important;
        font-weight: 800;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #003824 !important;
        padding: 12px 10px !important;
        text-align: center !important;
        vertical-align: middle !important;
        font-family: 'Nunito', sans-serif !important;
    }

    /* HEADER TABEL KHUSUS ITEM SPECS (KOLOM 29-42) - HIJAU TERANG */
    .table-custom-grid thead th.th-spec-green {
        background-color: #16a34a !important;
        color: #ffffff !important;
        border: 1px solid #15803d !important;
    }

    /* HEADER TABEL KHUSUS PROJECT STATUS & ACTIONS - ABU-ABU */
    .table-custom-grid thead th.th-gray {
        background-color: #475569 !important;
        color: #ffffff !important;
        border: 1px solid #334155 !important;
    }

    /* ISI SEL TABEL DIBUAT BEREGANG DAN LEGA */
    .table-custom-grid tbody td {
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
        padding: 10px 12px !important;
        vertical-align: middle !important;
        text-align: center !important;
        border: 1px solid #cbd5e1 !important;
        font-style: normal !important;
        font-family: 'Nunito', sans-serif !important;
        background-color: transparent !important;
    }

    /* ZEBRA STRIPING BARIS TABEL */
    .table-custom-grid tbody tr:nth-child(odd) {
        background-color: #ffffff !important;
    }

    .table-custom-grid tbody tr:nth-child(even) {
        background-color: #f8fafc !important;
    }

    .table-custom-grid tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    /* BADGE SEQUENCE HIJAU TERANG */
    .badge-seq-green {
        background-color: #16a34a !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 4px !important;
        padding: 4px 10px !important;
        font-size: 11px !important;
        display: inline-block;
        font-family: 'Nunito', sans-serif !important;
    }

    /* BADGE STATUS PROPORSI PAS */
    .badge-status-sm {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 4px 10px !important;
        border-radius: 4px !important;
        font-family: 'Nunito', sans-serif !important;
    }

    /* STYLES TOMBOL ACTION */
    .table-action-btns {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-action-sm {
        width: 28px;
        height: 28px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        color: #ffffff !important;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-action-sm:hover {
        transform: translateY(-1px);
        opacity: 0.9;
    }

    .btn-edit-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .btn-delete-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
</style>
@endpush

@section('content')
<main id="main" class="main workspace-container" style="background-color: #f6f9ff; min-height: 100vh;">

    <!-- Top Bar / Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: #212529; margin: 0 0 4px 0;">Data Project Status</h1>
            <p class="text-muted m-0" style="font-size: 13.5px;">Integrated master records combining project setup (1-28) and item color specifications (29-42)</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm rounded-3" role="alert" style="background-color: #e8f5e9; color: #1b5e20; font-size: 13.5px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-5">
        
        <!-- Filter, Search, dan Tombol Export CSV -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2" style="font-size: 14px; color: #212529;">
                <select class="form-select border rounded-3 shadow-none text-center" style="width: 80px; height: 38px; font-size: 14px; color: #212529;">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-secondary">entries </span>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <div style="width: 260px;">
                    <input type="text" id="tableSearchInput" class="form-control border rounded-3 shadow-none" placeholder="Search orders..." style="height: 38px; font-size: 14px; padding-left: 15px; color: #212529;">
                </div>
                <button type="button" onclick="exportTableToCSV('data-project-status.csv')" class="btn btn-white bg-white border rounded-3 fw-semibold px-3 d-flex align-items-center gap-2 shadow-sm" style="height: 38px; font-size: 13px; color: #212529;">
                    <i class="bi bi-download text-success"></i> Export CSV
                </button>
            </div>
        </div>

        <!-- Table Responsive dengan Kombinasi Header: Hijau Tua | Hijau Terang | Abu-abu -->
        <div class="table-responsive shadow-sm rounded-3 border">
            <table class="table table-custom-grid align-middle mb-0" id="projectDataTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        
                        <!-- SECTION 1: IDENTITY & GENERAL SPECIFICATIONS (1 - 10) [HIJAU TUA] -->
                        <th style="width: 130px;">Item Code</th>
                        <th style="width: 120px;">Brand / Family</th>
                        <th style="width: 110px;">Market Zone</th>
                        <th style="width: 200px;">Project Name</th>
                        <th style="width: 120px;">PD ASCIS</th>
                        <th style="width: 140px;">Customer Name</th>
                        <th style="width: 120px;">CS Brand</th>
                        <th style="width: 110px;">CS HW</th>
                        <th style="width: 110px;">CPI HW</th>

                        <!-- SECTION 2: APPROVAL & TECHNICAL MILESTONES (11 - 18) [HIJAU TUA] -->
                        <th style="width: 150px;">S5 Internal Approval</th>
                        <th style="width: 120px;">GHW Set</th>
                        <th style="width: 140px;">Information Received</th>
                        <th style="width: 140px;">PLM Released</th>
                        <th style="width: 120px;">COI Number</th>
                        <th style="width: 120px;">Green Light</th>
                        <th style="width: 100px;">TD</th>
                        <th style="width: 120px;">Machine</th>

                        <!-- SECTION 3: BOARD, CODES, DIE CUT & CYLINDER SPECS (19 - 28) [HIJAU TUA] -->
                        <th style="width: 120px;">Board</th>
                        <th style="width: 130px;">Board U Code</th>
                        <th style="width: 130px;">Board A Code</th>
                        <th style="width: 100px;">Type CM</th>
                        <th style="width: 130px;">Die Cut Number</th>
                        <th style="width: 120px;">S10 Number</th>
                        <th style="width: 120px;">S11 Number</th>
                        <th style="width: 120px;">S12 Number</th>
                        <th style="width: 140px;">Cylinder Supplier</th>
                        <th style="width: 120px;">Repro By</th>

                        <!-- SECTION 4: PRINTING COLOUR & INK SPECS (29 - 42) [HIJAU TERANG] -->
                        <th class="th-spec-green" style="width: 120px;">Sequence</th>
                        <th class="th-spec-green" style="width: 140px;">Colour Name</th>
                        <th class="th-spec-green" style="width: 130px;">BAAN Cylinder</th>
                        <th class="th-spec-green" style="width: 120px;">Film Number</th>
                        <th class="th-spec-green" style="width: 120px;">Ink System</th>
                        <th class="th-spec-green" style="width: 120px;">Ink Code</th>
                        <th class="th-spec-green" style="width: 120px;">Supplier Ink</th>
                        <th class="th-spec-green" style="width: 130px;">BAAN Ink Code</th>
                        <th class="th-spec-green" style="width: 110px;">Coverage (%)</th>
                        <th class="th-spec-green" style="width: 120px;">Usage (Kg/TH)</th>
                        <th class="th-spec-green" style="width: 130px;">Angle / Anilox</th>
                        <th class="th-spec-green" style="width: 150px;">Attachment File</th>
                        <th class="th-spec-green" style="width: 170px;">Remarks</th>
                        <th class="th-spec-green" style="width: 120px;">Seq Status</th>

                        <!-- PROJECT MASTER STATUS & ACTIONS [ABU-ABU] -->
                        <th class="th-gray" style="width: 130px;">Project Status</th>
                        <th class="th-gray" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="projectTableBody">
                    @forelse($tasks as $index => $task)
                        @php
                            $specs = $task->itemSpecs ? $task->itemSpecs->sortBy('sequence') : collect();
                            $specCount = $specs->count();
                            
                            // NOMOR BERFORMAT 2 DIGIT (01, 02, 03, DST.)
                            $rawNo = preg_replace('/[^0-9]/', '', $task->no ?? '');
                            $displayNo = !empty($rawNo) ? sprintf('%02d', (int)$rawNo) : sprintf('%02d', $index + 1);

                            // SINKRONISASI STRING STATUS LOKAL
                            $normalizedStatus = strtolower(trim($task->status ?? ''));
                        @endphp

                        @if($specCount > 0)
                            @foreach($specs as $sIndex => $spec)
                            @php
                                $isSpecComplete = !empty($spec->sequence) &&
                                                  !empty($spec->colour) &&
                                                  !empty($spec->baan_cylinder) &&
                                                  !empty($spec->film_number) &&
                                                  !empty($spec->ink_system) &&
                                                  !empty($spec->ink_code) &&
                                                  !empty($spec->supplier_ink) &&
                                                  !empty($spec->baan_ink_code) &&
                                                  !is_null($spec->coverage) &&
                                                  !is_null($spec->usage_kg_th) &&
                                                  !empty($spec->angle_anilox);
                            @endphp
                            <tr>
                                @if($sIndex === 0)
                                    <!-- NO (START DARI 01) & SECTION 1-3 (DATA TASK 1-28) DENGAN ROWSPAN -->
                                    <td rowspan="{{ $specCount }}" class="fw-bold">{{ $displayNo }}</td>
                                    
                                    <!-- SECTION 1 (1 - 10) -->
                                    <td rowspan="{{ $specCount }}" class="fw-bold text-primary">{{ $task->item_code }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->brand_family ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->market ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}" class="fw-semibold text-start ps-2" style="color: #012970; line-height: 1.2;">{{ $task->project_name ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->ascis_pd ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->customer ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->cs_brand ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->cs_hw ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->cpi_hw ?? '-' }}</td>

                                    <!-- SECTION 2 (11 - 18) -->
                                    <td rowspan="{{ $specCount }}">{{ $task->s5_internal_approval ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->ghw_set ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('d-m-Y') : '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('d-m-Y') : '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->coi_number ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->green_light ? \Carbon\Carbon::parse($task->green_light)->format('d-m-Y') : '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->td ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->machine ?? '-' }}</td>

                                    <!-- SECTION 3 (19 - 28) -->
                                    <td rowspan="{{ $specCount }}">{{ $task->board ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->board_u_code ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->board_a_code ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->type_cm ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->die_cut_number ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->s10_number ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->s11_number ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->s12_number ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->cylinder_supplier ?? '-' }}</td>
                                    <td rowspan="{{ $specCount }}">{{ $task->repro_by ?? '-' }}</td>
                                @endif

                                <!-- SECTION 4: ITEM SPECS (29 - 42) PER SEQUENCE -->
                                <td><span class="badge-seq-green">Seq {{ $spec->sequence }}</span></td>
                                <td class="text-start ps-2">{{ $spec->colour }}</td>
                                <td>{{ $spec->baan_cylinder ?? '-' }}</td>
                                <td>{{ $spec->film_number ?? '-' }}</td>
                                <td>{{ $spec->ink_system ?? '-' }}</td>
                                <td>{{ $spec->ink_code ?? '-' }}</td>
                                <td>{{ $spec->supplier_ink ?? '-' }}</td>
                                <td>{{ $spec->baan_ink_code ?? '-' }}</td>
                                <td>{{ $spec->coverage ? $spec->coverage . '%' : '-' }}</td>
                                <td>{{ $spec->usage_kg_th ? number_format($spec->usage_kg_th, 2) : '-' }}</td>
                                <td>{{ $spec->angle_anilox ?? '-' }}</td>
                                <td>
                                    @if($spec->main_design_attachment)
                                        <a href="{{ asset($spec->main_design_attachment) }}" target="_blank" class="text-decoration-none text-primary fw-semibold" style="font-size: 11px;">
                                            <i class="bi bi-paperclip me-1"></i>Attachment
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size: 11px;">-</span>
                                    @endif
                                </td>
                                <td class="text-start ps-2" style="font-size: 11px;">{{ $spec->remarks ?? '-' }}</td>
                                <td>
                                    @if($isSpecComplete)
                                        <span class="badge bg-success badge-status-sm">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark badge-status-sm">Progress</span>
                                    @endif
                                </td>

                                @if($sIndex === 0)
                                    <!-- REALTIME PROJECT MASTER STATUS -->
                                    <td rowspan="{{ $specCount }}">
                                        @if($normalizedStatus === 'completed' || $normalizedStatus === 'done')
                                            <span class="badge bg-success badge-status-sm">Completed</span>
                                        @elseif($normalizedStatus === 'in-progress' || $normalizedStatus === 'in progress' || $normalizedStatus === 'progress')
                                            <span class="badge bg-warning text-dark badge-status-sm">In Progress</span>
                                        @else
                                            <span class="badge bg-secondary badge-status-sm">To Do</span>
                                        @endif
                                    </td>

                                    <!-- ACTIONS -->
                                    <td rowspan="{{ $specCount }}">
                                        <div class="table-action-btns">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="btn-action-sm btn-edit-warning" title="Edit Record">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form id="delete-table-task-{{ $task->id ?? $task->item_code }}" action="{{ route('admin.task.destroy', $task->id ?? $task->item_code) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn-action-sm btn-delete-danger" onclick="if(confirm('Delete project data permanently?')) document.getElementById('delete-table-task-{{ $task->id ?? $task->item_code }}').submit();" title="Delete Task">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        @else
                            <!-- BARIS JIKA BELUM ADA ITEM SPEC (29-42) TERHUBUNG -->
                            <tr>
                                <td class="fw-bold">{{ $displayNo }}</td>
                                <td class="fw-bold text-primary">{{ $task->item_code }}</td>
                                <td>{{ $task->brand_family ?? '-' }}</td>
                                <td>{{ $task->market ?? '-' }}</td>
                                <td class="fw-semibold text-start ps-2" style="color: #012970; line-height: 1.2;">{{ $task->project_name ?? '-' }}</td>
                                <td>{{ $task->ascis_pd ?? '-' }}</td>
                                <td>{{ $task->customer ?? '-' }}</td>
                                <td>{{ $task->cs_brand ?? '-' }}</td>
                                <td>{{ $task->cs_hw ?? '-' }}</td>
                                <td>{{ $task->cpi_hw ?? '-' }}</td>

                                <td>{{ $task->s5_internal_approval ?? '-' }}</td>
                                <td>{{ $task->ghw_set ?? '-' }}</td>
                                <td>{{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $task->coi_number ?? '-' }}</td>
                                <td>{{ $task->green_light ? \Carbon\Carbon::parse($task->green_light)->format('d-m-Y') : '-' }}</td>
                                <td>{{ $task->td ?? '-' }}</td>
                                <td>{{ $task->machine ?? '-' }}</td>

                                <td>{{ $task->board ?? '-' }}</td>
                                <td>{{ $task->board_u_code ?? '-' }}</td>
                                <td>{{ $task->board_a_code ?? '-' }}</td>
                                <td>{{ $task->type_cm ?? '-' }}</td>
                                <td>{{ $task->die_cut_number ?? '-' }}</td>
                                <td>{{ $task->s10_number ?? '-' }}</td>
                                <td>{{ $task->s11_number ?? '-' }}</td>
                                <td>{{ $task->s12_number ?? '-' }}</td>
                                <td>{{ $task->cylinder_supplier ?? '-' }}</td>
                                <td>{{ $task->repro_by ?? '-' }}</td>

                                <!-- EMPTY ITEM SPECS PLACEHOLDERS (29 - 42) -->
                                <td colspan="14" class="text-muted font-italic bg-light py-2" style="font-size: 11px;">
                                    Item specifications (29-42) not created yet.
                                </td>

                                <!-- REALTIME PROJECT MASTER STATUS -->
                                <td>
                                    @if($normalizedStatus === 'completed' || $normalizedStatus === 'done')
                                        <span class="badge bg-success badge-status-sm">Completed</span>
                                    @elseif($normalizedStatus === 'in-progress' || $normalizedStatus === 'in progress' || $normalizedStatus === 'progress')
                                        <span class="badge bg-warning text-dark badge-status-sm">In Progress</span>
                                    @else
                                        <span class="badge bg-secondary badge-status-sm">To Do</span>
                                    @endif
                                </td>

                                <!-- ACTIONS -->
                                <td>
                                    <div class="table-action-btns">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="btn-action-sm btn-edit-warning" title="Edit Record">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form id="delete-table-task-{{ $task->id ?? $task->item_code }}" action="{{ route('admin.task.destroy', $task->id ?? $task->item_code) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn-action-sm btn-delete-danger" onclick="if(confirm('Delete project data permanently?')) document.getElementById('delete-table-task-{{ $task->id ?? $task->item_code }}').submit();" title="Delete Task">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                    <tr id="noDataRow">
                        <td colspan="45" class="text-center py-4 text-muted" style="font-style: italic;">
                            <i class="bi bi-inbox d-block mb-2 opacity-40" style="font-size: 24px;"></i>
                            No individual project data entries stored inside database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3" style="font-size: 14px; color: #212529;">
            <div class="fw-semibold">
                Showing {{ $tasks->count() > 0 ? 1 : 0 }} to {{ min($tasks->count(), 25) }} of {{ $tasks->count() }} entries
            </div>
            
            <nav>
                <ul class="pagination pagination-sm m-0 gap-2">
                    <li class="page-item disabled">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #15803d); opacity: 0.6;" href="#">
                            <i class="bi bi-chevron-left" style="font-size: 14px;"></i>
                        </a>
                    </li>

                    <li class="page-item active">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #15803d);" href="#">
                            1
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #15803d);" href="#">
                            <i class="bi bi-chevron-right" style="font-size: 14px;"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>

</main>

<!-- Loop Modal Edit Specs -->
@foreach($tasks as $task)
    @include('admin.task.partials.modal-edit-specs', ['task' => $task])
@endforeach

@endsection

@push('scripts')
<!-- JAVASCRIPT SEARCH REALTIME & EXPORT CSV -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('tableSearchInput');
        const tableBody = document.getElementById('projectTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filterValue = this.value.toLowerCase().trim();

                for (let i = 0; i < rows.length; i++) {
                    if (rows[i].id === 'noDataRow') continue;

                    const rowText = rows[i].textContent.toLowerCase();
                    if (rowText.includes(filterValue)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        }
    });

    function exportTableToCSV(filename) {
        const csv = [];
        const rows = document.querySelectorAll("#projectDataTable tr");
        
        for (let i = 0; i < rows.length; i++) {
            if (rows[i].id === 'noDataRow') continue;
            
            const row = [], cols = rows[i].querySelectorAll("td, th");
            
            for (let j = 0; j < cols.length - 1; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/^\s+|\s+$/g, '');
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            
            csv.push(row.join(","));
        }

        const csvFile = new Blob(["\uFEFF" + csv.join("\n")], { type: "text/csv;charset=utf-8;" });
        const downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endpush