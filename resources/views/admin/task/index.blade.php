@extends('layouts.admin')

@section('title', 'Project Task Workspace')

@push('styles')
    <!-- Hubungkan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .workspace-container,
        .workspace-container *,
        .table,
        .table * {
            font-family: 'Nunito', sans-serif !important;
        }

        .workspace-container {
            background-color: #f6f9ff;
            min-height: 100vh;
        }

        /* Garis Grid Tabel Tegas & Jelas + Teks Rata Tengah Presisi */
        .table-grid-bordered {
            border-collapse: collapse !important;
        }

        .table-grid-bordered th, 
        .table-grid-bordered td {
            border: 1px solid #cbd5e1 !important;
            padding: 8px 10px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }
        
        .table-text-unified {
            font-family: 'Nunito', sans-serif !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #111827 !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            line-height: 1.4;
            text-align: center !important;
        }

        /* FILTER GRID ATAS DENGAN PATTERN BATIK GEOMETRIS HIJAU TUA YANG JELAS & ELEGANT */
        .filter-card-wrapper {
            background-color: #ffffff;
            /* Pattern Batik Kawung / Geometri Hijau Tua SVG SVG Inline Clear */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 0 C15 15, 15 45, 30 60 C45 45, 45 15, 30 0 Z M0 30 C15 15, 45 15, 60 30 C45 45, 15 45, 0 30 Z' fill='none' stroke='%2315803d' stroke-width='1.2' stroke-opacity='0.18'/%3E%3Ccircle cx='30' cy='30' r='3' fill='%2315803d' fill-opacity='0.25'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 40px 40px;
            border: 1.5px solid rgba(21, 128, 61, 0.35) !important;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(21, 128, 61, 0.08);
            overflow: visible !important;
        }

        .filter-nav-link {
            position: relative;
            background: linear-gradient(135deg, #7ED348 0%, #26B170 100%);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 13.5px;
            padding: 0.55rem 1.3rem;
            border-radius: 6px;
            transition: all 0.25s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid transparent;
            box-shadow: 0 2px 4px rgba(38, 177, 112, 0.15);
            margin-top: 4px;
            margin-bottom: 4px;
        }
        
        .filter-nav-link i {
            color: #ffffff !important;
            font-size: 15px;
            transition: color 0.25s ease-in-out;
        }

        .filter-nav-link:hover {
            background: linear-gradient(135deg, #7ED348 0%, #26B170 100%) !important;
            filter: brightness(1.08);
            box-shadow: 0 4px 12px rgba(38, 177, 112, 0.3);
            transform: translateY(-1px);
            color: #ffffff !important;
        }

        /* KEADAAN KLIK / AKTIF: ICON & TEKS BERUBAH HIJAU TUA KELIATAN JELAS */
        .filter-nav-link.active {
            background: #ffffff !important;
            color: #15803d !important;
            border: 1.5px solid #26B170 !important;
            box-shadow: 0 2px 6px rgba(38, 177, 112, 0.25);
            filter: none;
            transform: translateY(0);
        }

        .filter-nav-link.active i {
            color: #15803d !important;
        }

        /* TOMBOL CREATE TASK HIJAU TUA DI DALAM GRID */
        .btn-create-task-green {
            background-color: #15803d !important;
            border-color: #15803d !important;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 13.5px;
            padding: 0.55rem 1.3rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(21, 128, 61, 0.25);
        }

        .btn-create-task-green:hover {
            background-color: #166534 !important;
            border-color: #166534 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(21, 128, 61, 0.35);
        }

        .count-badge-floating {
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 10.5px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 4px;
            color: #ffffff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            line-height: 1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.18);
            border: none !important;
            z-index: 2;
        }

        .count-badge-floating.bg-all { background-color: #ef4444; }
        .count-badge-floating.bg-todo { background-color: #64748b; }
        .count-badge-floating.bg-progress { background-color: #f97316; }
        .count-badge-floating.bg-complete { background-color: #3b82f6; }

        /* BADGE HEADER STATUS KOMPAK */
        .status-header-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 11px;
            letter-spacing: 0.3px;
            color: #ffffff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            text-transform: uppercase;
        }

        .status-pill-todo { background-color: #64748b; }
        .status-pill-progress { background-color: #f97316; }
        .status-pill-completed { background-color: #3b82f6; }

        /* LINGKARAN PUTIH MINI DENGAN TEKS SESUAI TEMA */
        .status-circle-badge {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #ffffff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 9.5px;
            font-weight: 900;
            line-height: 1;
        }

        .text-todo { color: #64748b !important; }
        .text-progress { color: #ea580c !important; }
        .text-completed { color: #2563eb !important; }

        .status-card-wrapper {
            transition: all 0.3s ease;
            border: 1.5px solid rgba(99, 102, 241, 0.25) !important;
            border-radius: 8px !important;
        }

        .custom-table-wrapper {
            border-radius: 8px;
            overflow: hidden;
            border: 1.5px solid rgba(99, 102, 241, 0.25) !important;
        }

        .table-header-todo th { background-color: #64748b !important; color: #ffffff !important; font-weight: 700 !important; font-size: 12px !important; text-transform: uppercase; }
        .table-header-in-progress th { background-color: #f97316 !important; color: #ffffff !important; font-weight: 700 !important; font-size: 12px !important; text-transform: uppercase; }
        .table-header-completed th { background-color: #3b82f6 !important; color: #ffffff !important; font-weight: 700 !important; font-size: 12px !important; text-transform: uppercase; }

        .action-btn-grad {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            font-size: 13.5px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }
        .action-btn-grad:hover { transform: translateY(-2px); color: #ffffff !important; }
        .btn-preview-grad { background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%); }
        .btn-edit-grad { background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); }
        .btn-delete-grad { background: linear-gradient(135deg, #f87171 0%, #dc2626 100%); }
    </style>
@endpush

@section('content')
<div class="container-fluid py-3 workspace-container">

    <!-- HEADER UTAMA -->
    <div class="mb-3">
        <h2 class="fw-bold text-dark mb-1">Project Specification Tracker</h2>
        <p class="text-muted small mb-0">Comprehensive multi-point project specifications workflow management.</p>
    </div>

    @php
        $countTodo = $todo->count();
        $countProgress = $inProgress->count();
        $countCompleted = $completed->count();
        $countAll = $countTodo + $countProgress + $countCompleted;

        $columns = [
            [
                'title' => 'To Do', 
                'status' => 'todo', 
                'data' => $todo, 
                'pill_class' => 'status-pill-todo',
                'text_class' => 'text-todo',
                'header_class' => 'table-header-todo'
            ],
            [
                'title' => 'In Progress', 
                'status' => 'in-progress', 
                'data' => $inProgress, 
                'pill_class' => 'status-pill-progress',
                'text_class' => 'text-progress',
                'header_class' => 'table-header-in-progress'
            ],
            [
                'title' => 'Completed', 
                'status' => 'completed', 
                'data' => $completed, 
                'pill_class' => 'status-pill-completed',
                'text_class' => 'text-completed',
                'header_class' => 'table-header-completed'
            ]
        ];
    @endphp

    <!-- BARIS FILTER UTAMA + GRID BATIK HIJAU TUA TEGAS + BUTTON CREATE TASK -->
    <div class="card shadow-sm p-3 mb-4 filter-card-wrapper">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            
            <!-- GROUP BUTTON FILTER NAVIGASI -->
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <button class="btn filter-nav-link active" data-filter="all">
                    <i class="bi bi-grid-fill"></i> All Projects
                    <span class="count-badge-floating bg-all">{{ $countAll }}</span>
                </button>
                <button class="btn filter-nav-link" data-filter="todo">
                    <i class="bi bi-list-task"></i> To Do
                    <span class="count-badge-floating bg-todo">{{ $countTodo }}</span>
                </button>
                <button class="btn filter-nav-link" data-filter="in-progress">
                    <i class="bi bi-arrow-repeat"></i> In Progress
                    <span class="count-badge-floating bg-progress">{{ $countProgress }}</span>
                </button>
                <button class="btn filter-nav-link" data-filter="completed">
                    <i class="bi bi-check-circle-fill"></i> Completed
                    <span class="count-badge-floating bg-complete">{{ $countCompleted }}</span>
                </button>
            </div>

            <!-- BUTTON CREATE TASK HIJAU TUA MASUK DI DALAM GRID FILTER -->
            <div>
                <button type="button" class="btn btn-create-task-green shadow-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bi bi-plus-lg me-1"></i> Create Task
                </button>
            </div>

        </div>
    </div>

    <!-- TABEL DATA PROJECT -->
    <div id="projectSectionsContainer">
        @foreach($columns as $col)
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4 status-card-wrapper" data-status="{{ $col['status'] }}">
            
            <!-- HEADER STATUS SIMPEL -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="status-header-pill {{ $col['pill_class'] }}">
                    <span>{{ $col['title'] }}</span>
                    <span class="status-circle-badge {{ $col['text_class'] }}">{{ $col['data']->count() }}</span>
                </div>
            </div>

            <!-- TABLE WRAPPER -->
            <div class="custom-table-wrapper shadow-sm">
                <div class="table-responsive">
                    <table class="table table-grid-bordered align-middle mb-0" style="font-size: 13px; table-layout: fixed; width: 100%; min-width: 4200px; --bs-table-hover-bg: #f8fafc;">
                        <thead class="{{ $col['header_class'] }}">
                            <tr>
                                <th class="py-2.5 text-center" style="width: 60px;">No</th>
                                <th class="py-2.5 text-center" style="width: 140px;">Item Code</th>
                                <th class="py-2.5 text-center" style="width: 130px;">SAP Number</th>
                                <th class="py-2.5 text-center" style="width: 150px;">Brand / Family</th>
                                <th class="py-2.5 text-center" style="width: 110px;">Market</th>
                                <th class="py-2.5 text-center" style="width: 220px;">Project Name</th>
                                <th class="py-2.5 text-center" style="width: 130px;">PD ASCIS</th>
                                <th class="py-2.5 text-center" style="width: 150px;">Customer</th>
                                <th class="py-2.5 text-center" style="width: 130px;">CS Brand</th>
                                <th class="py-2.5 text-center" style="width: 120px;">CS HW</th>
                                <th class="py-2.5 text-center" style="width: 120px;">CPI HW</th>
                                <th class="py-2.5 text-center" style="width: 160px;">S5 Internal Approval</th>
                                <th class="py-2.5 text-center" style="width: 120px;">GHW Set</th>
                                <th class="py-2.5 text-center" style="width: 150px;">Information Received</th>
                                <th class="py-2.5 text-center" style="width: 140px;">PLM Released</th>
                                <th class="py-2.5 text-center" style="width: 130px;">COI Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Green Light</th>
                                <th class="py-2.5 text-center" style="width: 100px;">TD</th>
                                <th class="py-2.5 text-center" style="width: 120px;">Machine</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Board</th>
                                <th class="py-2.5 text-center" style="width: 140px;">Board U Code</th>
                                <th class="py-2.5 text-center" style="width: 140px;">Board A Code</th>
                                <th class="py-2.5 text-center" style="width: 110px;">Type CM</th>
                                <th class="py-2.5 text-center" style="width: 140px;">Die Cut Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;">S10 Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;">S11 Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;">S12 Number</th>
                                <th class="py-2.5 text-center" style="width: 160px;">Cylinder Supplier</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Repro By</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Sequence (Seq)</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Colour</th>
                                <th class="py-2.5 text-center" style="width: 140px;">BAAN Cylinder</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Film Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Ink System</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Ink Code</th>
                                <th class="py-2.5 text-center" style="width: 140px;">Supplier Ink</th>
                                <th class="py-2.5 text-center" style="width: 140px;">BAAN Ink Code</th>
                                <th class="py-2.5 text-center" style="width: 110px;">Coverage (%)</th>
                                <th class="py-2.5 text-center" style="width: 120px;">Usage (Kg/TH)</th>
                                <th class="py-2.5 text-center" style="width: 140px;">Angle / Anilox</th>
                                <th class="py-2.5 text-center" style="width: 250px;">Remarks</th>
                                <th class="py-2.5 text-center" style="width: 240px;">Main Design / Attachment</th>
                                <th class="py-2.5 text-center" style="width: 130px;">Target Date</th>
                                <th class="py-2.5 text-center" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($col['data'] as $index => $task)
                            @php
                                $realId = $task->id ?? $task['id'] ?? $task->task_id ?? null;
                            @endphp
                            <tr>
                                <td class="text-center table-text-unified">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="table-text-unified fw-bold">{{ $task->item_code }}</td>
                                <td class="table-text-unified">{{ $task->sap_number ?? '000-000' }}</td>

                                <td class="table-text-unified">{{ $task->brand_family ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->market ?? 'INDO' }}</td>
                                <td class="table-text-unified">{{ $task->project_name }}</td>
                                <td class="table-text-unified">{{ $task->ascis_pd ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->customer }}</td>
                                <td class="table-text-unified">{{ $task->cs_brand ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cs_hw ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cpi_hw ?? '-' }}</td>

                                <td class="table-text-unified">{{ $task->s5_internal_approval ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->ghw_set ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('d-m-Y') : '-' }}</td>
                                <td class="table-text-unified">{{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('d-m-Y') : '-' }}</td>
                                <td class="table-text-unified">{{ $task->coi_number ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->green_light ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->td ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->machine ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->board ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->board_u_code ?? '-' }}</td>

                                <td class="table-text-unified">{{ $task->board_a_code ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->type_cm ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->die_cut_number ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->s10_number ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->s11_number ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->s12_number ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cylinder_supplier ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->repro_by ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->sequence_seq ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->colour ?? '-' }}</td>

                                <td class="table-text-unified">{{ $task->baan_cylinder ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->film_number ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->ink_system ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->ink_code ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->supplier_ink ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->baan_ink_code ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->coverage_percent ? $task->coverage_percent . '%' : '-' }}</td>
                                <td class="table-text-unified">{{ $task->usage_kg_th ? $task->usage_kg_th . ' Kg/TH' : '-' }}</td>
                                <td class="table-text-unified">{{ $task->angle_anilox ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->remark ?? '-' }}</td>

                                <td class="table-text-unified text-center">
                                    @if($task->main_design_attachment)
                                        <a href="#" class="text-decoration-none table-text-unified">
                                            <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>{{ $task->main_design_attachment }}
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="table-text-unified text-center">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('d M Y') : '18 Jan 2026' }}
                                </td>

                                <!-- ACTIONS -->
                                <td class="text-center py-2">
                                    <div class="d-flex align-items-center justify-content-center gap-1.5">
                                        @if($realId)
                                            <a href="#" class="action-btn-grad btn-preview-grad" data-bs-toggle="modal" data-bs-target="#previewTaskModal{{ $realId }}" title="Preview Details">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <button class="action-btn-grad btn-edit-grad" type="button" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $realId }}" title="Edit Specification">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="action-btn-grad btn-delete-grad" type="button" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data ini?')) document.getElementById('delete-task-{{ $realId }}').submit();" title="Delete Project">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                            <form id="delete-task-{{ $realId }}" action="{{ route('admin.task.destroy', ['id' => $realId]) }}" method="POST" class="d-none">
                                                @csrf 
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <button class="action-btn-grad btn-preview-grad opacity-50" type="button" disabled><i class="bi bi-eye-fill"></i></button>
                                            <button class="action-btn-grad btn-edit-grad opacity-50" type="button" disabled><i class="bi bi-pencil-square"></i></button>
                                            <button class="action-btn-grad btn-delete-grad opacity-50" type="button" disabled><i class="bi bi-trash-fill"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            @if($realId)
                                @include('admin.task.partials.modal-edit-specs')
                            @endif

                            @empty
                            <tr>
                                <td colspan="44" class="text-center py-4 text-muted border border-dashed bg-white fw-semibold" style="font-style: italic; font-size: 13px;">
                                    <i class="bi bi-info-circle me-1.5"></i>No active projects under this status.
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
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const targetFilter = button.getAttribute('data-filter');

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