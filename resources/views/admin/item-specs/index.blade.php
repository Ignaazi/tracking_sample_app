@extends('layouts.admin')

@section('title', 'Item Specifications Workspace')

@push('styles')
    <!-- Bootstrap Icons & Google Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        .workspace-container, .workspace-container *, .table, .table * {
            font-family: 'Nunito', sans-serif !important;
        }
        .workspace-container { background-color: #f6f9ff; min-height: 100vh; }
        .table-grid-bordered { border-collapse: collapse !important; }
        .table-grid-bordered th, .table-grid-bordered td {
            border: 1px solid #cbd5e1 !important;
            padding: 8px 10px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }
        .table-text-unified {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #111827 !important;
            line-height: 1.4;
            text-align: center !important;
        }
        .filter-card-wrapper {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 0 C15 15, 15 45, 30 60 C45 45, 45 15, 30 0 Z M0 30 C15 15, 45 15, 60 30 C45 45, 15 45, 0 30 Z' fill='none' stroke='%2315803d' stroke-width='1.2' stroke-opacity='0.18'/%3E%3Ccircle cx='30' cy='30' r='3' fill='%2315803d' fill-opacity='0.25'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 40px 40px;
            border: 1.5px solid rgba(21, 128, 61, 0.35) !important;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(21, 128, 61, 0.08);
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
        }
        .filter-nav-link.active {
            background: #ffffff !important;
            color: #15803d !important;
            border: 1.5px solid #26B170 !important;
        }
        .count-badge-floating {
            position: absolute;
            top: -8px; right: -8px;
            font-size: 10.5px; font-weight: 800;
            padding: 2px 7px; border-radius: 4px;
            color: #ffffff !important;
        }
        .bg-all { background-color: #ef4444; }
        .bg-todo { background-color: #64748b; }
        .bg-progress { background-color: #f97316; }
        .bg-complete { background-color: #3b82f6; }
        .status-header-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 2px 8px; border-radius: 12px;
            font-weight: 800; font-size: 11px; color: #ffffff !important;
        }
        .status-pill-todo { background-color: #64748b; }
        .status-pill-progress { background-color: #f97316; }
        .status-pill-completed { background-color: #3b82f6; }
        .status-circle-badge {
            width: 16px; height: 16px; border-radius: 50%;
            background-color: #ffffff !important;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 9.5px; font-weight: 900;
        }
        .status-card-wrapper { border: 1.5px solid rgba(99, 102, 241, 0.25) !important; border-radius: 8px !important; }
        .custom-table-wrapper { border-radius: 8px; overflow: hidden; border: 1.5px solid rgba(99, 102, 241, 0.25) !important; }
        .table-header-todo th { background-color: #64748b !important; color: #ffffff !important; }
        .table-header-in-progress th { background-color: #f97316 !important; color: #ffffff !important; }
        .table-header-completed th { background-color: #3b82f6 !important; color: #ffffff !important; }

        /* GAP / JARAK RENGGANG TOMBOL ACTION */
        .action-btn-container {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
        }

        /* GRADIENT ACTION BUTTONS */
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
        .btn-add-grad { background: linear-gradient(135deg, #4ade80 0%, #16a34a 100%); }
    </style>
@endpush

@section('content')
<div class="container-fluid py-3 workspace-container">

    <div class="mb-3">
        <h2 class="fw-bold text-dark mb-1">Item Specifications Tracker</h2>
        <p class="text-muted small mb-0">Automatic task integration & ink printing specifications workspace.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $countTodo = $todoSpecs->count();
        $countProgress = $inProgressSpecs->count();
        $countCompleted = $completedSpecs->count();
        $countAll = $countTodo + $countProgress + $countCompleted;

        $columns = [
            ['title' => 'To Do', 'status' => 'todo', 'data' => $todoSpecs, 'pill_class' => 'status-pill-todo', 'header_class' => 'table-header-todo'],
            ['title' => 'In Progress', 'status' => 'in-progress', 'data' => $inProgressSpecs, 'pill_class' => 'status-pill-progress', 'header_class' => 'table-header-in-progress'],
            ['title' => 'Completed', 'status' => 'completed', 'data' => $completedSpecs, 'pill_class' => 'status-pill-completed', 'header_class' => 'table-header-completed']
        ];
    @endphp

    <!-- FILTER BOARD UTAMA -->
    <div class="card shadow-sm p-3 mb-4 filter-card-wrapper">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <button class="btn filter-nav-link active" data-filter="all">
                    <i class="bi bi-grid-fill"></i> All Items <span class="count-badge-floating bg-all">{{ $countAll }}</span>
                </button>
                <button class="btn filter-nav-link" data-filter="todo">
                    <i class="bi bi-list-task"></i> To Do <span class="count-badge-floating bg-todo">{{ $countTodo }}</span>
                </button>
                <button class="btn filter-nav-link" data-filter="in-progress">
                    <i class="bi bi-arrow-repeat"></i> In Progress <span class="count-badge-floating bg-progress">{{ $countProgress }}</span>
                </button>
                <button class="btn filter-nav-link" data-filter="completed">
                    <i class="bi bi-check-circle-fill"></i> Completed <span class="count-badge-floating bg-complete">{{ $countCompleted }}</span>
                </button>
            </div>
        </div>
    </div>

    <!-- TABEL TASK UTAMA & NESTED SPECIFICATIONS -->
    <div id="itemSpecSectionsContainer">
        @foreach($columns as $col)
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4 status-card-wrapper" data-status="{{ $col['status'] }}">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="status-header-pill {{ $col['pill_class'] }}">
                    <span>{{ $col['title'] }}</span>
                    <span class="status-circle-badge text-dark">{{ $col['data']->count() }}</span>
                </div>
            </div>

            <div class="custom-table-wrapper shadow-sm">
                <div class="table-responsive">
                    <table class="table table-grid-bordered align-middle mb-0" style="font-size: 13px;">
                        <thead class="{{ $col['header_class'] }}">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="width: 140px;">Item Code</th>
                                <th>Project Name</th>
                                <th>Customer</th>
                                <th>Market</th>
                                <th>TD</th>
                                <th>Board</th>
                                <th>CS Brand</th>
                                <th>CS HW</th>
                                <th>Registered Specs</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($col['data'] as $index => $task)
                            <tr>
                                <td class="table-text-unified">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="table-text-unified fw-bold text-success">{{ $task->item_code }}</td>
                                <td class="table-text-unified fw-bold">{{ $task->project_name }}</td>
                                <td class="table-text-unified">{{ $task->customer }}</td>
                                <td class="table-text-unified">{{ $task->market ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->td ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->board ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cs_brand ?? '-' }}</td>
                                <td class="table-text-unified">{{ $task->cs_hw ?? '-' }}</td>
                                <td class="table-text-unified">
                                    @if($task->itemSpecs && $task->itemSpecs->count() > 0)
                                        <span class="badge bg-success px-2 py-1"><i class="bi bi-palette me-1"></i>{{ $task->itemSpecs->count() }} Sequences</span>
                                    @else
                                        <span class="text-muted small">No Specs Recorded</span>
                                    @endif
                                </td>
                                
                                <!-- ACTION UTAMA (TANPA TOMBOL DELETE) -->
                                <td class="text-center py-2">
                                    <div class="action-btn-container">
                                        <button class="action-btn-grad btn-preview-grad" type="button" data-bs-toggle="modal" data-bs-target="#previewTaskModal{{ $task->id }}" title="Preview Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        <button class="action-btn-grad btn-edit-grad" type="button" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" title="Edit Task">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="action-btn-grad btn-add-grad" type="button" data-bs-toggle="modal" data-bs-target="#addSpecModal{{ $task->id }}" title="Add Spec Sequence">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- SUB-TABEL SPESIFIKASI UNTUK TASK YBS -->
                            @if($task->itemSpecs && $task->itemSpecs->isNotEmpty())
                            <tr style="background-color: #f4fbf7;">
                                <td colspan="11" class="p-3">
                                    <div class="border border-success rounded bg-white p-3 shadow-sm text-start">
                                        <div class="fw-bold text-success mb-2" style="font-size: 12px;">
                                            <i class="bi bi-palette me-1"></i> PRINTING COLOUR & INK SPECIFICATIONS FOR [{{ $task->item_code }}]:
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered align-middle mb-0" style="font-size: 12px;">
                                                <thead class="bg-success text-white">
                                                    <tr>
                                                        <th>Sequence</th>
                                                        <th>Colour</th>
                                                        <th>BAAN Cylinder</th>
                                                        <th>Film No.</th>
                                                        <th>Ink System</th>
                                                        <th>Ink Code</th>
                                                        <th>Supplier</th>
                                                        <th>BAAN Ink Code</th>
                                                        <th>Coverage (%)</th>
                                                        <th>Usage (Kg/TH)</th>
                                                        <th>Angle / Anilox</th>
                                                        <th>Attachment</th>
                                                        <th style="width: 110px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($task->itemSpecs->sortBy('sequence') as $spec)
                                                    <tr>
                                                        <td><span class="badge bg-dark rounded-pill px-2">Seq {{ $spec->sequence }}</span></td>
                                                        <td class="fw-bold">{{ $spec->colour }}</td>
                                                        <td><code>{{ $spec->baan_cylinder ?? '-' }}</code></td>
                                                        <td>{{ $spec->film_number ?? '-' }}</td>
                                                        <td>{{ $spec->ink_system ?? '-' }}</td>
                                                        <td><span class="badge bg-light text-dark border">{{ $spec->ink_code ?? '-' }}</span></td>
                                                        <td><span class="badge bg-secondary">{{ $spec->supplier_ink ?? '-' }}</span></td>
                                                        <td><code>{{ $spec->baan_ink_code ?? '-' }}</code></td>
                                                        <td>{{ $spec->coverage ? $spec->coverage . '%' : '-' }}</td>
                                                        <td>{{ $spec->usage_kg_th ? number_format($spec->usage_kg_th, 2) : '-' }}</td>
                                                        <td>{{ $spec->angle_anilox ?? '-' }}</td>
                                                        <td>
                                                            @if($spec->main_design_attachment)
                                                                <a href="{{ asset($spec->main_design_attachment) }}" target="_blank" class="btn btn-xs btn-outline-success p-0 px-1"><i class="bi bi-paperclip me-1"></i>File</a>
                                                            @else
                                                                <span class="text-muted" style="font-size: 10px;">None</span>
                                                            @endif
                                                        </td>
                                                        <!-- ACTIONS UNTUK SPEC (TANPA TOMBOL DELETE) -->
                                                        <td class="text-center py-2">
                                                            <div class="action-btn-container">
                                                                <button class="action-btn-grad btn-preview-grad" type="button" data-bs-toggle="modal" data-bs-target="#previewSpecModal{{ $spec->id }}" title="Preview Details">
                                                                    <i class="bi bi-eye-fill"></i>
                                                                </button>
                                                                <button class="action-btn-grad btn-edit-grad" type="button" data-bs-toggle="modal" data-bs-target="#editSpecModal{{ $spec->id }}" title="Edit Specification">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    @include('admin.item-specs.partials.modal-edit', ['spec' => $spec])
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif

                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4 text-muted border border-dashed bg-white fw-semibold">
                                    <i class="bi bi-info-circle me-1.5"></i>No active tasks under this status.
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
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush