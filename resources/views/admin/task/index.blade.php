@extends('layouts.admin')

@section('title', 'Project Task Workspace')

@push('styles')
    <!-- Hubungkan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Paksa semua elemen di dalam workspace menggunakan font Nunito */
        .workspace-container,
        .workspace-container * {
            font-family: 'Nunito', sans-serif !important;
        }

        .workspace-container {
            background-color: #f6f9ff;
            min-height: 100vh;
        }
        
        .text-wrap-custom {
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            line-height: 1.4;
            color: #212529 !important; /* Paksa semua teks berwarna hitam */
        }

        /* Penulisan kode tetap menggunakan font Nunito namun dikombinasikan dengan ukuran proporsional */
        .font-code {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #212529 !important; /* Set warna hitam untuk teks kode */
        }

        .process-pill {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.25rem 0.6rem !important;
            border-radius: 6px !important;
            cursor: pointer;
            text-transform: capitalize;
            display: inline-block;
            margin: 2px;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        
        .process-pill:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* Tema warna status yang seragam, clean, & profesional */
        .sp-completed { 
            background-color: #e8f5e9 !important; 
            color: #2e7d32 !important; 
            border-color: #c8e6c9 !important;
        }
        .sp-progress { 
            background-color: #fff3e0 !important; 
            color: #ef6c00 !important; 
            border-color: #ffe0b2 !important;
        }
        .sp-default { 
            background-color: #f1f5f9 !important; 
            color: #475569 !important; 
            border-color: #e2e8f0 !important;
        }

        /* Custom Baris Filter Style */
        .filter-nav-link {
            color: #4f5e71;
            font-weight: 700;
            font-size: 14px;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid transparent;
        }
        
        .filter-nav-link:hover {
            background-color: #f1f5f9;
            color: #4154f1;
        }

        .filter-nav-link.active {
            background-color: #e0e4ff !important;
            color: #4154f1 !important;
            border-color: rgba(65, 84, 241, 0.15) !important;
        }

        /* Transisi halus saat card disembunyikan */
        .status-card-wrapper {
            transition: all 0.3s ease;
        }

        /* Desain Action Buttons Group */
        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
        }

        /* Tombol Edit Kuning/Amber */
        .action-btn-edit {
            color: #856404;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
        }

        .action-btn-edit:hover {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        /* Tombol Delete Merah */
        .action-btn-delete {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .action-btn-delete:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Trik khusus menjaga lekukan border-radius di dalam tabel responsive yang bisa di-scroll */
        .custom-table-wrapper {
            border-radius: 8px;
            overflow: hidden; /* Mengunci sudut luar */
            border: 1px solid #dee2e6;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid py-3 workspace-container">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">Project Specification Tracker</h2>
            <p class="text-muted small mb-0">Comprehensive multi-point project specifications workflow management.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary btn-sm rounded-3 px-3 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal" style="background-color: #4154f1; border-color: #4154f1;">
                <i class="bi bi-plus-lg"></i> Create Task
            </button>
        </div>
    </div>

    <!-- GARIS FILTER DENGAN IKON -->
    <div class="card border-0 shadow-sm rounded-3 p-2 bg-white mb-4">
        <div class="d-flex flex-wrap gap-2">
            <button class="btn filter-nav-link active" data-filter="all">
                <i class="bi bi-grid-fill"></i> All Projects
            </button>
            <button class="btn filter-nav-link" data-filter="todo">
                <i class="bi bi-list-task text-secondary"></i> To Do
            </button>
            <button class="btn filter-nav-link" data-filter="in-progress">
                <i class="bi bi-play-circle-fill text-warning"></i> In Progress
            </button>
            <button class="btn filter-nav-link" data-filter="completed">
                <i class="bi bi-check-circle-fill text-success"></i> Completed
            </button>
        </div>
    </div>
    
    @php
        $columns = [
            ['title' => 'To Do', 'status' => 'todo', 'data' => $todo, 'badge_bg' => '#f1f5f9', 'badge_text' => '#475569'],
            ['title' => 'In Progress', 'status' => 'in-progress', 'data' => $inProgress, 'badge_bg' => '#fff7ed', 'badge_text' => '#ea580c'],
            ['title' => 'Completed', 'status' => 'completed', 'data' => $completed, 'badge_bg' => '#e8f5e9', 'badge_text' => '#2e7d32']
        ];
    @endphp

    <!-- CONTAINER MAP KELOMPOK TABEL -->
    <div id="projectSectionsContainer">
        @foreach($columns as $col)
        <!-- KELOMPOK WORKFLOW STATUS -->
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4 status-card-wrapper" data-status="{{ $col['status'] }}">
            
            <!-- Header Status Kelompok -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background-color: {{ $col['badge_bg'] }}; color: {{ $col['badge_text'] }}; font-size: 13px;">
                        {{ $col['title'] }}
                    </span>
                    <span class="text-muted fw-semibold font-code" style="color: #212529 !important;">({{ $col['data']->count() }} Projects)</span>
                </div>
            </div>

            <!-- Wrapper Khusus Penjaga Lekukan Sudut -->
            <div class="custom-table-wrapper shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="font-size: 13px; table-layout: fixed; width: 100%; min-width: 4500px; --bs-table-hover-bg: #f8fafc;">
                        <thead style="background-color: #f3f6f9; color: #212529; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <tr>
                                <!-- Headers -->
                                <th class="py-3 ps-3" style="border-bottom: 2px solid #cbd5e1; width: 60px;">No</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Item Code</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 150px;">Brand / Family</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 110px;">Market</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 220px;">Project Name</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">PD ASCIS</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 150px;">Customer</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">CS Brand</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">CS HW</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">CPI HW</th>

                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 160px;">S5 Internal Approval</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">GHW Set</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 150px;">Information Received</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">PLM Released</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">COI Number</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Green Light</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 100px;">TD</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">Machine</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Board</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Board U Code</th>

                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Board A Code</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 110px;">Type CM</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Die Cut Number</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">S10 Number</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">S11 Number</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">S12 Number</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 160px;">Cylinder Supplier</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Repro By</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Sequence (Seq)</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Colour</th>

                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">BAAN Cylinder</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Film Number</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Ink System</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Ink Code</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Supplier Ink</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">BAAN Ink Code</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 110px;">Coverage (%)</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">Usage (Kg/TH)</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Angle / Anilox</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 250px;">Remarks</th>

                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 240px;">Main Design / Attachment</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Target Date</th>
                                
                                <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 320px;">Internal Status Sub-Proses</th>
                                <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">SAP Number</th>
                                <th class="py-3 text-end pe-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($col['data'] as $index => $task)
                            @php
                                // Mengunci variabel realId dari baris teratas loop agar konsisten di render ke modal dan route form
                                $realId = $task->id ?? $task['id'] ?? $task->task_id ?? $task['task_id'] ?? $task->id_task ?? $task['id_task'] ?? null;
                            @endphp
                            <tr style="border-bottom: 1px solid #e9ecef; color: #212529;">
                                <td class="py-3 ps-3 fw-semibold text-wrap-custom">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-3 fw-bold font-code text-wrap-custom">{{ $task->item_code }}</td>
                                <td class="py-3 fw-semibold text-wrap-custom">{{ $task->brand_family ?? '-' }}</td>
                                <td class="py-3 fw-semibold text-wrap-custom text-uppercase">[ {{ $task->market ?? 'INDO' }} ]</td>
                                <td class="py-3 fw-semibold text-wrap-custom">{{ $task->project_name }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->ascis_pd ?? '-' }}</td>
                                <td class="py-3 fw-semibold text-wrap-custom">{{ $task->customer }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->cs_brand ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->cs_hw ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->cpi_hw ?? '-' }}</td>

                                <td class="py-3 text-wrap-custom">{{ $task->s5_internal_approval ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->ghw_set ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('d-m-Y') : '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('d-m-Y') : '-' }}</td>
                                <td class="py-3 text-wrap-custom font-code">{{ $task->coi_number ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->green_light ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->td ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->machine ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->board ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->board_u_code ?? '-' }}</td>

                                <td class="py-3 font-code text-wrap-custom">{{ $task->board_a_code ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->type_cm ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom font-code">{{ $task->die_cut_number ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->s10_number ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->s11_number ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->s12_number ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->cylinder_supplier ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->repro_by ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->sequence_seq ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->colour ?? '-' }}</td>

                                <td class="py-3 font-code text-wrap-custom">{{ $task->baan_cylinder ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->film_number ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom text-break">{{ $task->ink_system ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->ink_code ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom text-break">{{ $task->supplier_ink ?? '-' }}</td>
                                <td class="py-3 font-code text-wrap-custom">{{ $task->baan_ink_code ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->coverage_percent ? $task->coverage_percent . '%' : '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->usage_kg_th ? $task->usage_kg_th . ' Kg/TH' : '-' }}</td>
                                <td class="py-3 text-wrap-custom">{{ $task->angle_anilox ?? '-' }}</td>
                                <td class="py-3 text-wrap-custom" style="font-size: 12.5px;">{{ $task->remark ?? '-' }}</td>

                                <td class="py-3 text-wrap-custom">
                                    @if($task->main_design_attachment)
                                        <a href="#" class="text-decoration-none fw-semibold" style="color: #212529 !important;">
                                            <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>{{ $task->main_design_attachment }}
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="py-3 text-wrap-custom font-code">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('d M Y') : '18 Jan 2026' }}
                                </td>

                                <td class="text-center py-3">
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        @if($realId)
                                            <span class="badge process-pill {{ $task->layout_status == 'Completed' ? 'sp-completed' : ($task->layout_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $realId }}_layout">Layout</span>
                                            <span class="badge process-pill {{ $task->baan_status == 'Completed' ? 'sp-completed' : ($task->baan_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $realId }}_baan">Baan</span>
                                            <span class="badge process-pill {{ $task->promp_status == 'Completed' ? 'sp-completed' : ($task->promp_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $realId }}_promp">Prompt</span>
                                            <span class="badge process-pill {{ $task->job_bag_status == 'Completed' ? 'sp-completed' : ($task->job_bag_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $realId }}_jobbag">Job Bag</span>
                                        @else
                                            <span class="badge process-pill sp-default opacity-50">Layout</span>
                                            <span class="badge process-pill sp-default opacity-50">Baan</span>
                                            <span class="badge process-pill sp-default opacity-50">Prompt</span>
                                            <span class="badge process-pill sp-default opacity-50">Job Bag</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 font-code text-wrap-custom fw-semibold">{{ $task->sap_number ?? '000-000' }}</td>

                                <!-- KOLOM ACTIONS -->
                                <td class="text-end py-3 pe-3">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        @if($realId)
                                            <!-- Tombol Edit Warna Kuning -->
                                            <button class="action-btn action-btn-edit" 
                                                    type="button" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editTaskModal{{ $realId }}" 
                                                    title="Edit Specification">
                                                <i class="bi bi-pencil-square" style="font-size: 15px;"></i>
                                            </button>

                                            <!-- Tombol Delete Warna Merah -->
                                            <button class="action-btn action-btn-delete" 
                                                    type="button" 
                                                    onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data ini?')) document.getElementById('delete-task-{{ $realId }}').submit();" 
                                                    title="Delete Project">
                                                <i class="bi bi-trash" style="font-size: 15px;"></i>
                                            </button>

                                            <!-- Form Hidden Delete (Menggunakan route: admin.task.destroy) -->
                                            <form id="delete-task-{{ $realId }}" action="{{ route('admin.task.destroy', ['id' => $realId]) }}" method="POST" class="d-none">
                                                @csrf 
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <button class="action-btn action-btn-edit opacity-50" type="button" disabled><i class="bi bi-pencil-square" style="font-size: 15px;"></i></button>
                                            <button class="action-btn action-btn-delete opacity-50" type="button" disabled><i class="bi bi-trash" style="font-size: 15px;"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            @if($realId)
                                @include('admin.task.partials.modal-sub-process')
                                @include('admin.task.partials.modal-edit-specs')
                            @endif

                            @empty
                            <tr>
                                <td colspan="45" class="text-center py-5 text-muted border border-dashed bg-white fw-semibold" style="font-style: italic; font-size: 14px;">
                                    <i class="bi bi-info-circle me-2"></i>No active projects under this status.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @endforeach
    </div>

</div>

@include('admin.task.partials.modal-create-task')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-nav-link');
        const statusCards = document.querySelectorAll('.status-card-wrapper');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // 1. Ganti status active class tombol filter
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                // 2. Ambil nilai status filter yang di-klik
                const targetFilter = button.getAttribute('data-filter');

                // 3. Logika sembunyikan/tampilkan tabel status kelompok
                statusCards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    
                    if (targetFilter === 'all' || cardStatus === targetFilter) {
                        card.style.display = 'block';
                        setTimeout(() => { card.style.opacity = '1'; }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush