@extends('layouts.admin')

@section('title', 'Data Project Status - NiceAdmin')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@push('styles')
<style>
    /* STYLING TABEL KOTAK-KOTAK COMPACT & HEADER HIJAU TUA */
    .table-custom-grid {
        table-layout: fixed !important;
        width: 100%;
        min-width: 4200px;
        border-collapse: collapse !important;
    }

    /* HANYA HEADER TABEL YANG BERUBAH KE HIJAU TUA */
    .table-custom-grid thead th {
        background-color: #005236 !important;
        color: #ffffff !important;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #003824 !important;
        padding: 8px 6px !important;
        text-align: center !important;
        vertical-align: middle !important;
    }

    /* ISI SEL TABEL DIBUAT DENGAN PADDING COMPACT */
    .table-custom-grid tbody td {
        font-size: 11.5px;
        font-weight: 600;
        color: #000000 !important;
        padding: 5px 6px !important;
        vertical-align: middle !important;
        text-align: center !important;
        border: 1px solid #cbd5e1 !important;
    }

    /* ZEBRA STRIPING BARIS TABEL */
    .table-custom-grid tbody tr:nth-child(odd) {
        background-color: #ffffff !important;
    }

    .table-custom-grid tbody tr:nth-child(even) {
        background-color: #f8fafc !important;
    }

    .table-custom-grid tbody tr:hover {
        background-color: #e2e8f0 !important;
    }
</style>
@endpush

@section('content')
<main id="main" class="main" style="font-family: 'Nunito', sans-serif; background-color: #f6f9ff; min-height: 100vh;">

    <!-- Top Bar / Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: #212529; margin: 0 0 4px 0;">Data Project Status</h1>
            <p class="text-muted m-0" style="font-size: 13.5px;">Track and manage customer database records individually per entity</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm rounded-3" role="alert" style="background-color: #e8f5e9; color: #1b5e20; font-size: 13.5px; font-family: 'Nunito', sans-serif;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-5">
        
        <!-- Filter, Search, dan Tombol Export CSV -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2" style="font-size: 14px; color: #212529;">
                <select class="form-select border rounded-3 shadow-none text-center" style="width: 80px; height: 38px; font-size: 14px; font-family: 'Nunito', sans-serif; color: #212529;">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-secondary">entries </span>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <div style="width: 260px;">
                    <input type="text" id="tableSearchInput" class="form-control border rounded-3 shadow-none" placeholder="Search orders..." style="height: 38px; font-size: 14px; padding-left: 15px; font-family: 'Nunito', sans-serif; color: #212529;">
                </div>
                <button type="button" onclick="exportTableToCSV('data-project-status.csv')" class="btn btn-white bg-white border rounded-3 fw-semibold px-3 d-flex align-items-center gap-2 shadow-sm" style="height: 38px; font-size: 13px; color: #212529; font-family: 'Nunito', sans-serif;">
                    <i class="bi bi-download text-success"></i> Export CSV
                </button>
            </div>
        </div>

        <!-- Table Responsive COMPACT dengan Header Hijau Tua -->
        <div class="table-responsive shadow-sm rounded-3 border">
            <table class="table table-custom-grid align-middle mb-0" id="projectDataTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 130px;">Item Code</th>
                        <th style="width: 140px;">Brand / Family</th>
                        <th style="width: 100px;">Market</th>
                        <th style="width: 200px;">Project Name</th>
                        <th style="width: 120px;">PD ASCIS</th>
                        <th style="width: 130px;">Customer</th>
                        <th style="width: 120px;">CS Brand</th>
                        <th style="width: 110px;">CS HW</th>
                        <th style="width: 110px;">CPI HW</th>

                        <th style="width: 150px;">S5 Internal Approval</th>
                        <th style="width: 110px;">GHW Set</th>
                        <th style="width: 140px;">Information Received</th>
                        <th style="width: 130px;">PLM Released</th>
                        <th style="width: 120px;">COI Number</th>
                        <th style="width: 120px;">Green Light</th>
                        <th style="width: 90px;">TD</th>
                        <th style="width: 110px;">Machine</th>
                        <th style="width: 120px;">Board</th>
                        <th style="width: 130px;">Board U Code</th>

                        <th style="width: 130px;">Board A Code</th>
                        <th style="width: 100px;">Type CM</th>
                        <th style="width: 130px;">Die Cut Number</th>
                        <th style="width: 120px;">S10 Number</th>
                        <th style="width: 120px;">S11 Number</th>
                        <th style="width: 120px;">S12 Number</th>
                        <th style="width: 150px;">Cylinder Supplier</th>
                        <th style="width: 120px;">Repro By</th>
                        <th style="width: 120px;">Sequence (Seq)</th>
                        <th style="width: 120px;">Colour</th>

                        <th style="width: 130px;">BAAN Cylinder</th>
                        <th style="width: 120px;">Film Number</th>
                        <th style="width: 120px;">Ink System</th>
                        <th style="width: 120px;">Ink Code</th>
                        <th style="width: 130px;">Supplier Ink</th>
                        <th style="width: 130px;">BAAN Ink Code</th>
                        <th style="width: 100px;">Coverage (%)</th>
                        <th style="width: 110px;">Usage (Kg/TH)</th>
                        <th style="width: 130px;">Angle / Anilox</th>
                        <th style="width: 220px;">Remarks</th>

                        <th style="width: 200px;">Main Design / Attachment</th>
                        <th style="width: 130px;">Project Status</th>
                        
                        <!-- Internal Tracking -->
                        <th style="width: 110px;">Dev Status</th>
                        <th style="width: 120px;">Layout Status</th>
                        <th style="width: 120px;">Baan Status</th>
                        <th style="width: 120px;">Promp Status</th>
                        <th style="width: 130px;">Job Bag Status</th>
                        <th style="width: 120px;">SAP Number</th>
                        
                        <!-- Actions -->
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="projectTableBody">
                    @forelse($tasks as $index => $task)
                    <tr>
                        <!-- No -->
                        <td class="fw-bold">
                            {{ str_pad($task->no ?? ($index + 1), 2, '0', STR_PAD_LEFT) }}
                        </td>
                        
                        <!-- Item Code -->
                        <td class="fw-bold font-monospace text-primary text-break" style="word-break: break-all;">{{ $task->item_code }}</td>

                        <!-- Brand Family -->
                        <td class="fw-semibold">{{ $task->brand_family ?? '-' }}</td>

                        <!-- Market -->
                        <td class="fw-semibold">{{ $task->market ?? '-' }}</td>

                        <!-- Project Name -->
                        <td class="fw-semibold text-break" style="color: #012970; line-height: 1.2;">{{ $task->project_name }}</td>
                        
                        <!-- PD ASCIS -->
                        <td>{{ $task->ascis_pd ?? '-' }}</td>

                        <!-- Customer ID -->
                        <td class="fw-semibold">{{ $task->customer }}</td>

                        <!-- CS Brand -->
                        <td>{{ $task->cs_brand ?? '-' }}</td>

                        <!-- CS HW -->
                        <td>{{ $task->cs_hw ?? '-' }}</td>

                        <!-- CPI HW -->
                        <td>{{ $task->cpi_hw ?? '-' }}</td>

                        <!-- S5 Internal Approval -->
                        <td class="text-break">{{ $task->s5_internal_approval ?? '-' }}</td>

                        <!-- GHW Set -->
                        <td>{{ $task->ghw_set ?? '-' }}</td>

                        <!-- Information Received -->
                        <td class="font-monospace">
                            {{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('d-m-Y') : '-' }}
                        </td>

                        <!-- PLM Released -->
                        <td class="font-monospace">
                            {{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('d-m-Y') : '-' }}
                        </td>

                        <!-- COI Number -->
                        <td class="text-break">{{ $task->coi_number ?? '-' }}</td>

                        <!-- Green Light -->
                        <td>{{ $task->green_light ?? '-' }}</td>

                        <!-- TD -->
                        <td>{{ $task->td ?? '-' }}</td>

                        <!-- Machine -->
                        <td>{{ $task->machine ?? '-' }}</td>

                        <!-- Board -->
                        <td class="text-break">{{ $task->board ?? '-' }}</td>

                        <!-- Board U Code -->
                        <td class="font-monospace text-break">{{ $task->board_u_code ?? '-' }}</td>

                        <!-- Board A Code -->
                        <td class="font-monospace text-break">{{ $task->board_a_code ?? '-' }}</td>

                        <!-- Type CM -->
                        <td>{{ $task->type_cm ?? '-' }}</td>

                        <!-- Die Cut Number -->
                        <td class="text-break">{{ $task->die_cut_number ?? '-' }}</td>

                        <!-- S10 Number -->
                        <td class="font-monospace">{{ $task->s10_number ?? '-' }}</td>

                        <!-- S11 Number -->
                        <td class="font-monospace">{{ $task->s11_number ?? '-' }}</td>

                        <!-- S12 Number -->
                        <td class="font-monospace">{{ $task->s12_number ?? '-' }}</td>

                        <!-- Cylinder Supplier -->
                        <td class="text-break" style="line-height: 1.2;">{{ $task->cylinder_supplier ?? '-' }}</td>

                        <!-- Repro By -->
                        <td>{{ $task->repro_by ?? '-' }}</td>

                        <!-- Sequence (Seq) -->
                        <td>{{ $task->sequence_seq ?? '-' }}</td>

                        <!-- Colour -->
                        <td class="text-break" style="line-height: 1.2;">{{ $task->colour ?? '-' }}</td>

                        <!-- BAAN Cylinder -->
                        <td class="font-monospace text-break">{{ $task->baan_cylinder ?? '-' }}</td>

                        <!-- Film Number -->
                        <td class="font-monospace text-break">{{ $task->film_number ?? '-' }}</td>

                        <!-- Ink System -->
                        <td class="text-break">{{ $task->ink_system ?? '-' }}</td>

                        <!-- Ink Code -->
                        <td class="font-monospace text-break">{{ $task->ink_code ?? '-' }}</td>

                        <!-- Supplier Ink -->
                        <td class="text-break">{{ $task->supplier_ink ?? '-' }}</td>

                        <!-- BAAN Ink Code -->
                        <td class="font-monospace text-break">{{ $task->baan_ink_code ?? '-' }}</td>

                        <!-- Coverage (%) -->
                        <td>{{ $task->coverage_percent ? $task->coverage_percent . '%' : '-' }}</td>

                        <!-- Usage (Kg/TH) -->
                        <td>{{ $task->usage_kg_th ? $task->usage_kg_th . ' Kg/TH' : '-' }}</td>

                        <!-- Angle / Anilox -->
                        <td class="text-break">{{ $task->angle_anilox ?? '-' }}</td>

                        <!-- Remarks -->
                        <td class="text-break" style="line-height: 1.2; font-size: 11px;">
                            {{ $task->remark ?? '-' }}
                        </td>

                        <!-- Main Design / Attachment -->
                        <td class="text-break" style="line-height: 1.2;">
                            @if($task->main_design_attachment)
                                <a href="#" class="text-decoration-none text-primary fw-semibold">
                                    <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>{{ $task->main_design_attachment }}
                                </a>
                            @else
                                <span class="text-muted font-italic">-</span>
                            @endif
                        </td>

                        <!-- Project Status -->
                        <td>
                            @php
                                $statusStyle = [
                                    'To Do'        => ['bg' => '#f1f5f9', 'text' => '#475569'],
                                    'In Progress' => ['bg' => '#fff7ed', 'text' => '#ea580c'],
                                    'Ready for QA'=> ['bg' => '#eff6ff', 'text' => '#2563eb'],
                                    'Completed'   => ['bg' => '#e8f5e9', 'text' => '#2e7d32']
                                ];
                                $style = $statusStyle[$task->status] ?? ['bg' => '#f8fafc', 'text' => '#64748b'];
                            @endphp
                            <span class="badge rounded-pill px-2 py-0.5" style="background-color: {{ $style['bg'] }}; color: {{ $style['text'] }}; font-size: 10.5px;">
                                {{ $task->status }}
                            </span>
                        </td>

                        <!-- Dev Status -->
                        <td>
                            <span class="badge rounded-pill px-2 py-0.5 text-dark" style="font-size: 10.5px; background-color: #f1f5f9;">
                                {{ $task->development_status ?? 'Active' }}
                            </span>
                        </td>

                        <!-- Layout Status -->
                        <td>
                            <span class="badge rounded-pill px-2 py-0.5" style="font-size: 10.5px;
                                {{ $task->layout_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->layout_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->layout_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- Baan Status -->
                        <td>
                            <span class="badge rounded-pill px-2 py-0.5" style="font-size: 10.5px;
                                {{ $task->baan_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->baan_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->baan_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- Promp Status -->
                        <td>
                            <span class="badge rounded-pill px-2 py-0.5" style="font-size: 10.5px;
                                {{ $task->promp_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->promp_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->promp_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- Job Bag Status -->
                        <td>
                            <span class="badge rounded-pill px-2 py-0.5" style="font-size: 10.5px;
                                {{ $task->job_bag_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->job_bag_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->job_bag_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- SAP Number -->
                        <td class="fw-bold font-monospace text-break" style="font-size: 11.5px; word-break: break-all;">
                            {{ $task->sap_number ?? '-' }}
                        </td>

                        <!-- Actions Buttons -->
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editTaskModalTable{{ $task->item_code }}" class="btn btn-sm text-dark d-flex align-items-center justify-content-center shadow-none border-0" style="width: 26px; height: 26px; border-radius: 4px; background-color: #ffc107;" title="Edit Record">
                                    <i class="bi bi-pencil-square" style="font-size: 12px;"></i>
                                </button>
                                <button type="button" onclick="event.preventDefault(); if(confirm('Delete project data permanently?')) document.getElementById('delete-table-task-{{ $task->item_code }}').submit();" class="btn btn-sm text-white d-flex align-items-center justify-content-center shadow-none border-0" style="width: 26px; height: 26px; border-radius: 4px; background-color: #dc3545;" title="Delete Record">
                                    <i class="bi bi-trash3-fill" style="font-size: 12px;"></i>
                                </button>
                            </div>
                            <form id="delete-table-task-{{ $task->item_code }}" action="{{ route('admin.task.destroy', $task->item_code) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="49" class="text-center py-4 text-muted" style="font-style: italic; font-family: 'Nunito', sans-serif;">
                            <i class="bi bi-inbox d-block mb-2 opacity-40" style="font-size: 24px;"></i>
                            No individual project data entries stored inside database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (DIBALIKIN KE WARNA SEMULA SAMA DENGAN WARNA ORIGINAL BRO) -->
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3" style="font-size: 14px; color: #212529; font-family: 'Nunito', sans-serif;">
            <div class="fw-semibold">
                Showing 1 to {{ min($tasks->count(), 25) }} of {{ $tasks->count() }} entries
            </div>
            
            <nav>
                <ul class="pagination pagination-sm m-0 gap-2">
                    <li class="page-item disabled">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14); opacity: 0.6;" href="#">
                            <i class="bi bi-chevron-left" style="font-size: 14px; display: inline-block;"></i>
                        </a>
                    </li>

                    <li class="page-item active">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            1
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            2
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            3
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            <i class="bi bi-chevron-right" style="font-size: 14px; display: inline-block;"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>

</main>

<!-- Loop Modal Edit Specs -->
@foreach($tasks as $task)
    @include('admin.task.partials.modal-edit-table-specs')
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- JAVASCRIPT SEARCH REALTIME & EXPORT CSV -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('tableSearchInput');
        const tableBody = document.getElementById('projectTableBody');
        const rows = tableBody.getElementsByTagName('tr');

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

        const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        const downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endsection