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

        /* FILTER GRID ATAS */
        .filter-card-wrapper {
            background-color: #ffffff;
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

    <!-- ALERT SUKSES DAN ERROR -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill fs-3 me-3 text-success"></i>
            <div>
                <strong class="d-block fs-6">Berhasil Disimpan!</strong>
                <span class="small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start mb-4 border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-danger mt-1"></i>
            <div class="flex-grow-1">
                <strong class="d-block fs-6 mb-1">Gagal Menyimpan Project!</strong>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        // Ambil koleksi dasar task dari controller
        $allTasksCollection = $tasks ?? collect();

        // Daftar 28 field utama yang harus terisi lengkap untuk berpindah dari To Do -> In Progress
        $required28Fields = [
            'no', 'item_code', 'brand_family', 'market', 'project_name',
            'ascis_pd', 'customer', 'cs_brand', 'cs_hw', 'cpi_hw',
            's5_internal_approval', 'ghw_set', 'information_received',
            'plm_released', 'coi_number', 'green_light', 'td', 'machine',
            'board', 'board_u_code', 'board_a_code', 'type_cm',
            'die_cut_number', 's10_number', 's11_number', 's12_number',
            'cylinder_supplier', 'repro_by'
        ];

        // 1. COMPLETED: Task dengan status completed/done
        $completedData = $allTasksCollection->filter(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['completed', 'done']);
        });

        // Task tersisa yang belum completed
        $activeTasks = $allTasksCollection->reject(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['completed', 'done']);
        });

        // 2. IN PROGRESS: Task aktif yang ke-28 data spesifikasinya terisi LENGKAP
        $inProgressData = $activeTasks->filter(function($t) use ($required28Fields) {
            foreach ($required28Fields as $field) {
                if (is_null($t->$field) || trim((string)$t->$field) === '') {
                    return false; // Ada yang kosong, bukan In Progress
                }
            }
            return true;
        });

        // 3. TO DO: Task aktif yang masih ada field KOSONG / BELUM LENGKAP
        $todoData = $activeTasks->reject(function($t) use ($required28Fields) {
            foreach ($required28Fields as $field) {
                if (is_null($t->$field) || trim((string)$t->$field) === '') {
                    return false;
                }
            }
            return true;
        });

        $countTodo = $todoData->count();
        $countProgress = $inProgressData->count();
        $countCompleted = $completedData->count();
        $countAll = $countTodo + $countProgress + $countCompleted;

        $columns = [
            [
                'title' => 'To Do', 
                'status' => 'todo', 
                'data' => $todoData, 
                'pill_class' => 'status-pill-todo',
                'text_class' => 'text-todo',
                'header_class' => 'table-header-todo'
            ],
            [
                'title' => 'In Progress', 
                'status' => 'in-progress', 
                'data' => $inProgressData, 
                'pill_class' => 'status-pill-progress',
                'text_class' => 'text-progress',
                'header_class' => 'table-header-in-progress'
            ],
            [
                'title' => 'Completed', 
                'status' => 'completed', 
                'data' => $completedData, 
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

            <!-- BUTTON CREATE TASK -->
            <div>
                <button type="button" class="btn btn-create-task-green shadow-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bi bi-plus-lg me-1"></i> Create Task
                </button>
            </div>

        </div>
    </div>

    <!-- TABEL DATA PROJECT (28 KOLOM MURNI TABLE TASK) -->
    <div id="projectSectionsContainer">
        @foreach($columns as $col)
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4 status-card-wrapper" data-status="{{ $col['status'] }}">
            
            <!-- HEADER STATUS -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="status-header-pill {{ $col['pill_class'] }}">
                    <span>{{ $col['title'] }}</span>
                    <span class="status-circle-badge {{ $col['text_class'] }}">{{ $col['data']->count() }}</span>
                </div>
            </div>

            <!-- TABLE WRAPPER -->
            <div class="custom-table-wrapper shadow-sm">
                <div class="table-responsive">
                    <table class="table table-grid-bordered align-middle mb-0" style="font-size: 13px; table-layout: fixed; width: 100%; min-width: 3200px; --bs-table-hover-bg: #f8fafc;">
                        <thead class="{{ $col['header_class'] }}">
                            <tr>
                                <th class="py-2.5 text-center" style="width: 140px;"> No</th>
                                <th class="py-2.5 text-center" style="width: 140px;"> Item Code</th>
                                <th class="py-2.5 text-center" style="width: 150px;"> Brand / Family</th>
                                <th class="py-2.5 text-center" style="width: 110px;"> Market</th>
                                <th class="py-2.5 text-center" style="width: 220px;"> Project Name</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> PD ASCIS</th>
                                <th class="py-2.5 text-center" style="width: 150px;"> Customer</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> CS Brand</th>
                                <th class="py-2.5 text-center" style="width: 120px;"> CS HW</th>
                                <th class="py-2.5 text-center" style="width: 120px;"> CPI HW</th>
                                <th class="py-2.5 text-center" style="width: 160px;"> S5 Internal Approval</th>
                                <th class="py-2.5 text-center" style="width: 120px;"> GHW Set</th>
                                <th class="py-2.5 text-center" style="width: 150px;"> Information Received</th>
                                <th class="py-2.5 text-center" style="width: 140px;"> PLM Released</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> COI Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> Green Light</th>
                                <th class="py-2.5 text-center" style="width: 100px;"> TD</th>
                                <th class="py-2.5 text-center" style="width: 120px;"> Machine</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> Board</th>
                                <th class="py-2.5 text-center" style="width: 140px;"> Board U Code</th>
                                <th class="py-2.5 text-center" style="width: 140px;"> Board A Code</th>
                                <th class="py-2.5 text-center" style="width: 110px;"> Type CM</th>
                                <th class="py-2.5 text-center" style="width: 140px;"> Die Cut Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> S10 Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> S11 Number</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> S12 Number</th>
                                <th class="py-2.5 text-center" style="width: 160px;"> Cylinder Supplier</th>
                                <th class="py-2.5 text-center" style="width: 130px;"> Repro By</th>
                                <th class="py-2.5 text-center" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($col['data'] as $index => $task)
                            @php
                                $realId = $task->id ?? null;
                            @endphp
                            <tr>
                                <!-- DITAMPILKAN CREATTASK0001 ATO AUTOMATIC NO -->
                                <td class="text-center table-text-unified fw-bold text-dark">{{ $task->no ?? ('CREATTASK' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)) }}</td>
                                <td class="table-text-unified fw-bold text-primary">{{ $task->item_code }}</td>
                                <td class="table-text-unified">{{ $task->brand_family ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->market ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->project_name ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->ascis_pd ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->customer ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cs_brand ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cs_hw ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cpi_hw ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->s5_internal_approval ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->ghw_set ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('d-m-Y') : '-' }}</td>
                                <td class="table-text-unified">{{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('d-m-Y') : '-' }}</td>
                                <td class="table-text-unified">{{ $task->coi_number ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->green_light ? \Carbon\Carbon::parse($task->green_light)->format('d-m-Y') : '-' }}</td>
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

                                <!-- ACTIONS -->
                                <td class="text-center py-2">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        @if($realId)
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
                                            <button class="action-btn-grad btn-edit-grad opacity-50" type="button" disabled><i class="bi bi-pencil-square"></i></button>
                                            <button class="action-btn-grad btn-delete-grad opacity-50" type="button" disabled><i class="bi bi-trash-fill"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- INCLUDE MODAL EDIT PER BARIS DATA -->
                            @if($realId)
                                @include('admin.task.partials.modal-edit-specs', ['task' => $task])
                            @endif

                            @empty
                            <tr>
                                <td colspan="29" class="text-center py-4 text-muted border border-dashed bg-white fw-semibold" style="font-style: italic; font-size: 13px;">
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
        // --- LOGIKA FILTER TABEL ---
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

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var addTaskModalElement = document.getElementById('addTaskModal');
        if (addTaskModalElement) {
            var addTaskModal = new bootstrap.Modal(addTaskModalElement);
            addTaskModal.show();
        }
    });
</script>
@endif
@endpush