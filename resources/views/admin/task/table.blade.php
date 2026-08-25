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

    /* STYLING TABEL UTAMA HALAMAN DEPAN */
    .table-custom-simple {
        table-layout: auto !important;
        width: 100%;
        border-collapse: collapse !important;
        font-family: 'Nunito', sans-serif !important;
    }

    .table-custom-simple thead th {
        background-color: #005236 !important;
        color: #ffffff !important;
        font-weight: 800;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #003824 !important;
        padding: 12px 14px !important;
        text-align: center !important;
        vertical-align: middle !important;
    }

    .table-custom-simple tbody td {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
        padding: 12px 14px !important;
        vertical-align: middle !important;
        text-align: center !important;
        border: 1px solid #cbd5e1 !important;
        background-color: transparent !important;
    }

    .table-custom-simple tbody tr:nth-child(odd) {
        background-color: #ffffff !important;
    }

    .table-custom-simple tbody tr:nth-child(even) {
        background-color: #f8fafc !important;
    }

    .table-custom-simple tbody tr:hover {
        background-color: #f0f9ff !important;
    }

    /* BADGE STATUS PROPORSI PAS */
    .badge-status-sm {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 5px 12px !important;
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
        width: 30px;
        height: 30px;
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

    .btn-preview-info {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    }

    .btn-edit-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .btn-delete-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* TABEL DETAIL DALAM MODAL PREVIEW */
    .table-modal-preview {
        font-size: 11.5px !important;
        border-collapse: collapse !important;
        min-width: 2500px;
    }

    .table-modal-preview th {
        background-color: #005236 !important;
        color: #ffffff !important;
        font-weight: 700;
        padding: 8px 10px !important;
        border: 1px solid #003824 !important;
        text-align: center !important;
    }

    .table-modal-preview th.th-spec-green {
        background-color: #16a34a !important;
        border: 1px solid #15803d !important;
    }

    .table-modal-preview td {
        padding: 8px 10px !important;
        border: 1px solid #cbd5e1 !important;
        text-align: center !important;
    }

    .badge-seq-green {
        background-color: #16a34a !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 4px !important;
        padding: 3px 8px !important;
        font-size: 10.5px !important;
    }
</style>
@endpush

@section('content')
<main id="main" class="main workspace-container" style="background-color: #f6f9ff; min-height: 100vh;">

    <!-- Top Bar / Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: #212529; margin: 0 0 4px 0;">Data Project Status</h1>
            <p class="text-muted m-0" style="font-size: 13.5px;">Integrated master records combining project setup and item color specifications</p>
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

        <!-- Tabel Ringkas Halaman Depan -->
        <div class="table-responsive shadow-sm rounded-3 border">
            <table class="table table-custom-simple align-middle mb-0" id="projectDataTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th style="width: 160px;">Item Code</th>
                        <th style="min-width: 250px;">Project Name</th>
                        <th style="width: 200px;">Customer Name</th>
                        <th style="width: 150px;">Project Status</th>
                        <th style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="projectTableBody">
                    @forelse($tasks as $index => $task)
                        @php
                            // PENOMORAN OTOMATIS URUT (SUPPORT PAGINASI)
                            $number = method_exists($tasks, 'firstItem') 
                                ? ($tasks->firstItem() + $index) 
                                : ($index + 1);
                            
                            $displayNo = sprintf('%02d', $number);

                            // SINKRONISASI STRING STATUS LOKAL
                            $normalizedStatus = strtolower(trim($task->status ?? ''));
                        @endphp
                        <tr>
                            <td class="fw-bold">{{ $displayNo }}</td>
                            <td class="fw-bold text-primary">{{ $task->item_code }}</td>
                            <td class="fw-semibold text-start ps-3" style="color: #012970;">{{ $task->project_name ?? '-' }}</td>
                            <td>{{ $task->customer ?? '-' }}</td>
                            
                            <!-- PROJECT STATUS -->
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
                                    <!-- Button Preview Data Lengkap -->
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#previewTaskModal{{ $task->id }}" class="btn-action-sm btn-preview-info" title="Preview Full Details">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>

                                    <!-- Button Edit -->
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="btn-action-sm btn-edit-warning" title="Edit Record">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Button Delete -->
                                    <form id="delete-table-task-{{ $task->id }}" action="{{ route('admin.task.destroy', $task->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn-action-sm btn-delete-danger" onclick="if(confirm('Delete project data permanently?')) document.getElementById('delete-table-task-{{ $task->id }}').submit();" title="Delete Task">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="6" class="text-center py-4 text-muted" style="font-style: italic;">
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
                Showing {{ $tasks->count() > 0 ? (method_exists($tasks, 'firstItem') ? $tasks->firstItem() : 1) : 0 }} 
                to {{ method_exists($tasks, 'lastItem') ? $tasks->lastItem() : $tasks->count() }} 
                of {{ method_exists($tasks, 'total') ? $tasks->total() : $tasks->count() }} entries
            </div>
            
            <nav>
                @if(method_exists($tasks, 'links'))
                    {{ $tasks->links() }}
                @else
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
                @endif
            </nav>
        </div>

    </div>

</main>

<!-- MODAL PREVIEW FULL DATA (1-42) -->
@foreach($tasks as $index => $task)
    @php
        $number = method_exists($tasks, 'firstItem') 
            ? ($tasks->firstItem() + $index) 
            : ($index + 1);
        $displayNo = sprintf('%02d', $number);
    @endphp
<div class="modal fade" id="previewTaskModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width: 95vw;">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: #005236; color: #ffffff;">
                <h5 class="modal-title fw-bold" style="font-size: 16px;">
                    <i class="bi bi-file-earmark-text me-2"></i> Full Details (No: {{ $displayNo }}): {{ $task->item_code }} - {{ $task->project_name }}
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #f8fafc;">
                
                <!-- Detail Info Header Card -->
                <div class="card border-0 shadow-sm p-3 mb-4 rounded-3 bg-white">
                    <h6 class="fw-bold mb-3 text-success border-bottom pb-2"><i class="bi bi-info-circle me-1"></i> Basic Master Information</h6>
                    <div class="row g-3" style="font-size: 13px;">
                        <div class="col-md-3"><strong>Item Code:</strong> <span class="text-primary fw-bold">{{ $task->item_code }}</span></div>
                        <div class="col-md-3"><strong>Brand/Family:</strong> {{ $task->brand_family ?? '-' }}</div>
                        <div class="col-md-3"><strong>Market Zone:</strong> {{ $task->market ?? '-' }}</div>
                        <div class="col-md-3"><strong>Customer Name:</strong> {{ $task->customer ?? '-' }}</div>
                        <div class="col-md-3"><strong>PD ASCIS:</strong> {{ $task->ascis_pd ?? '-' }}</div>
                        <div class="col-md-3"><strong>CS Brand:</strong> {{ $task->cs_brand ?? '-' }}</div>
                        <div class="col-md-3"><strong>CS HW:</strong> {{ $task->cs_hw ?? '-' }}</div>
                        <div class="col-md-3"><strong>CPI HW:</strong> {{ $task->cpi_hw ?? '-' }}</div>
                    </div>
                </div>

                <!-- Preview Table Specs 1 - 42 -->
                <div class="card border-0 shadow-sm p-3 rounded-3 bg-white">
                    <h6 class="fw-bold mb-3 text-success border-bottom pb-2"><i class="bi bi-table me-1"></i> Comprehensive Specifications Grid (Cols 1-42)</h6>
                    
                    <div class="table-responsive rounded-2 border">
                        <table class="table table-modal-preview align-middle mb-0">
                            <thead>
                                <tr>
                                    <!-- SECTION 1-3 -->
                                    <th>S5 Approval</th>
                                    <th>GHW Set</th>
                                    <th>Info Rec.</th>
                                    <th>PLM Rel.</th>
                                    <th>COI No</th>
                                    <th>Green Light</th>
                                    <th>TD</th>
                                    <th>Machine</th>
                                    <th>Board</th>
                                    <th>Board U Code</th>
                                    <th>Board A Code</th>
                                    <th>Type CM</th>
                                    <th>Die Cut No</th>
                                    <th>S10 No</th>
                                    <th>S11 No</th>
                                    <th>S12 No</th>
                                    <th>Cylinder Supp.</th>
                                    <th>Repro By</th>

                                    <!-- SECTION 4: SPECS (29-42) -->
                                    <th class="th-spec-green">Seq</th>
                                    <th class="th-spec-green">Colour Name</th>
                                    <th class="th-spec-green">BAAN Cyl.</th>
                                    <th class="th-spec-green">Film No.</th>
                                    <th class="th-spec-green">Ink System</th>
                                    <th class="th-spec-green">Ink Code</th>
                                    <th class="th-spec-green">Supplier Ink</th>
                                    <th class="th-spec-green">BAAN Ink Code</th>
                                    <th class="th-spec-green">Coverage</th>
                                    <th class="th-spec-green">Usage (Kg/TH)</th>
                                    <th class="th-spec-green">Angle/Anilox</th>
                                    <th class="th-spec-green">Attachment</th>
                                    <th class="th-spec-green">Remarks</th>
                                    <th class="th-spec-green">Seq Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $specs = $task->itemSpecs ? $task->itemSpecs->sortBy('sequence') : collect();
                                @endphp
                                @forelse($specs as $spec)
                                    @php
                                        $isSpecComplete = !empty($spec->sequence) && !empty($spec->colour) && !empty($spec->baan_cylinder);
                                    @endphp
                                    <tr>
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

                                        <!-- SPECS DATA -->
                                        <td><span class="badge-seq-green">Seq {{ $spec->sequence }}</span></td>
                                        <td class="fw-semibold text-start">{{ $spec->colour }}</td>
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
                                                <a href="{{ asset($spec->main_design_attachment) }}" target="_blank" class="text-decoration-none text-primary fw-semibold">
                                                    <i class="bi bi-paperclip me-1"></i>File
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-start">{{ $spec->remarks ?? '-' }}</td>
                                        <td>
                                            @if($isSpecComplete)
                                                <span class="badge bg-success badge-status-sm">Completed</span>
                                            @else
                                                <span class="badge bg-warning text-dark badge-status-sm">Progress</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="32" class="text-center py-3 text-muted">
                                            No item specs registered for this project.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-light px-4 py-2 border-top">
                <button type="button" class="btn btn-secondary btn-sm px-3 rounded-2 fw-semibold" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

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