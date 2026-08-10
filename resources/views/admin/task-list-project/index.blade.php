@extends('layouts.admin')

@section('title', 'Task List Project - Kanban Board')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        .kanban-container, .kanban-container * {
            font-family: 'Nunito', sans-serif !important;
        }

        /* GRID UTAMA KANBAN BOARD */
        .kanban-board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            align-items: flex-start;
            padding-bottom: 1.5rem;
        }

        @media (max-width: 992px) {
            .kanban-board {
                display: flex;
                overflow-x: auto;
                padding-bottom: 1rem;
            }
            .kanban-column {
                flex: 0 0 340px;
            }
        }

        /* STRUKTUR BASE KOLOM KANBAN */
        .kanban-column {
            border-radius: 14px;
            max-height: calc(100vh - 160px);
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }

        .kanban-column-header {
            padding: 14px 18px;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
        }

        .kanban-cards-wrapper {
            padding: 14px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* ========================================================= */
        /* 1. TEMA FULL ABU-ABU (TO DO)                              */
        /* ========================================================= */
        .col-theme-todo {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.08);
        }
        .col-theme-todo .kanban-column-header {
            background-color: #e2e8f0;
            color: #334155;
            border-bottom: 2px solid #cbd5e1;
        }
        .col-theme-todo .kanban-card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-left: 4px solid #64748b;
            box-shadow: 0 3px 6px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.02);
        }
        .col-theme-todo .kanban-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(100, 116, 139, 0.15);
            border-color: #94a3b8;
            border-left-color: #475569;
        }

        /* ========================================================= */
        /* 2. TEMA FULL BIRU MUDA (IN PROGRESS)                      */
        /* ========================================================= */
        .col-theme-progress {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.08);
        }
        .col-theme-progress .kanban-column-header {
            background-color: #e0f2fe;
            color: #0369a1;
            border-bottom: 2px solid #bae6fd;
        }
        .col-theme-progress .kanban-card {
            background: #ffffff;
            border: 1px solid #bae6fd;
            border-left: 4px solid #0284c7;
            box-shadow: 0 3px 6px rgba(2, 132, 199, 0.05), 0 1px 2px rgba(0,0,0,0.02);
        }
        .col-theme-progress .kanban-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(2, 132, 199, 0.18);
            border-color: #38bdf8;
            border-left-color: #0369a1;
        }

        /* ========================================================= */
        /* 3. TEMA FULL HIJAU MUDA (COMPLETED)                       */
        /* ========================================================= */
        .col-theme-completed {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.08);
        }
        .col-theme-completed .kanban-column-header {
            background-color: #dcfce7;
            color: #15803d;
            border-bottom: 2px solid #bbf7d0;
        }
        .col-theme-completed .kanban-card {
            background: #ffffff;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #16a34a;
            box-shadow: 0 3px 6px rgba(22, 163, 74, 0.05), 0 1px 2px rgba(0,0,0,0.02);
        }
        .col-theme-completed .kanban-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(22, 163, 74, 0.18);
            border-color: #4ade80;
            border-left-color: #15803d;
        }

        /* STYLING KARTU KANBAN 3D TIPIS */
        .kanban-card {
            border-radius: 10px;
            padding: 14px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        /* BADGE ITEM CODE DENGAN TEMA WARNA EMAS */
        .badge-itemcode-gold {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #b45309 !important;
            border: 1px solid #fcd34d !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            padding: 4px 9px !important;
            border-radius: 6px !important;
            letter-spacing: 0.5px;
        }

        /* LOGO DI SEBELAH KANAN */
        .card-header-logo {
            height: 24px;
            width: auto;
            max-width: 80px;
            object-fit: contain;
        }

        /* SUB-PROCESS GRID */
        .sub-process-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #cbd5e1;
        }

        .sub-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 5px 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* STATUS BADGE SUB-PROSES */
        .status-Completed, .status-completed {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-In-Progress, .status-in-progress, .status-In_Progress {
            background-color: #fef9c3;
            color: #a16207;
            border: 1px solid #fef08a;
        }

        .status-Pending, .status-pending, .status-To-Do {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        /* TOMBOL DETAIL (GRADIENT BLUE & SOFT HOVER/CLICK) */
        .btn-detail-gradient {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%) !important;
            color: #ffffff !important;
            border: none !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            border-radius: 6px !important;
            padding: 4px 12px !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25);
            transition: all 0.25s ease !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* HOVER EFFECT (EFFEK SAMAR) */
        .btn-detail-gradient:hover {
            opacity: 0.75 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2) !important;
            color: #ffffff !important;
        }

        /* ACTIVE / CLICK EFFECT (EFFEK LEBIH SAMAR) */
        .btn-detail-gradient:active {
            opacity: 0.5 !important;
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
<div class="container-fluid p-4 kanban-container" style="background-color: #f8fafc; min-height: 100vh;">

    <!-- TOP HEADER BAR -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1 fs-4" style="color: #0f172a !important;">Project Development Kanban</h3>
        <p class="text-secondary small mb-0" style="font-size: 13px;">Real-time monitoring for Layout, BaaN, Prompt, & Job Bag workflows.</p>
    </div>

    <!-- KANBAN BOARD GRID -->
    <div class="kanban-board">

        @php
            $columns = [
                [
                    'title' => 'TO DO', 
                    'tasks' => $todoTasks, 
                    'theme_class' => 'col-theme-todo', 
                    'badge_class' => 'bg-secondary'
                ],
                [
                    'title' => 'IN PROGRESS', 
                    'tasks' => $inProgressTasks, 
                    'theme_class' => 'col-theme-progress', 
                    'badge_class' => 'bg-primary'
                ],
                [
                    'title' => 'COMPLETED', 
                    'tasks' => $completedTasks, 
                    'theme_class' => 'col-theme-completed', 
                    'badge_class' => 'bg-success'
                ]
            ];
        @endphp

        @foreach($columns as $col)
        <div class="kanban-column {{ $col['theme_class'] }}">
            
            <!-- COLUMN HEADER -->
            <div class="kanban-column-header">
                <span class="fw-extrabold">{{ $col['title'] }}</span>
                <span class="badge {{ $col['badge_class'] }} rounded-pill px-2.5 py-1" style="font-size: 11px;">
                    {{ $col['tasks']->count() }}
                </span>
            </div>

            <!-- CARDS WRAPPER -->
            <div class="kanban-cards-wrapper">
                @forelse($col['tasks'] as $task)
                <div class="kanban-card">
                    
                    <!-- ITEM CODE (EMAS) & LOGO LOGO1.PNG (DI KANAN) -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge badge-itemcode-gold font-monospace text-uppercase">
                            {{ $task->item_code }}
                        </span>
                        <img src="{{ asset('logo1.png') }}" alt="Logo" class="card-header-logo">
                    </div>

                    <!-- PROJECT NAME & CUSTOMER -->
                    <h6 class="fw-bold text-dark mb-1 fs-6 text-truncate" title="{{ $task->project_name }}" style="color: #0f172a !important;">
                        {{ $task->project_name }}
                    </h6>
                    <p class="text-muted small mb-2 d-flex align-items-center gap-1" style="font-size: 12px;">
                        <i class="bi bi-building text-secondary"></i>
                        <span class="text-truncate">{{ $task->customer ?? '-' }}</span>
                    </p>

                    <!-- 4 SUB-PROCESS STATUS GRID -->
                    <div class="sub-process-grid">
                        @php
                            $subProcesses = [
                                ['label' => 'Layout', 'status' => $task->layout_status ?? 'Pending'],
                                ['label' => 'BaaN', 'status' => $task->baan_status ?? 'Pending'],
                                ['label' => 'Prompt', 'status' => $task->promp_status ?? 'Pending'],
                                ['label' => 'Job Bag', 'status' => $task->job_bag_status ?? 'Pending'],
                            ];
                        @endphp

                        @foreach($subProcesses as $sub)
                        @php
                            $normalizedStatus = str_replace([' ', '_'], '-', strtolower($sub['status']));
                            $iconClass = 'bi-dash-circle';
                            
                            if (in_array($normalizedStatus, ['completed', 'done'])) {
                                $iconClass = 'bi-check-circle-fill';
                            } elseif (in_array($normalizedStatus, ['in-progress', 'progress'])) {
                                $iconClass = 'bi-clock-history';
                            }
                        @endphp
                        <div class="sub-badge status-{{ $sub['status'] }}">
                            <span>{{ $sub['label'] }}</span>
                            <i class="bi {{ $iconClass }}" style="font-size: 11px;"></i>
                        </div>
                        @endforeach
                    </div>

                    <!-- CARD FOOTER -->
                    <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top border-light">
                        <span class="text-secondary fw-semibold d-flex align-items-center gap-1" style="font-size: 11px;">
                            <i class="bi bi-palette text-primary"></i>
                            {{ $task->itemSpecs ? $task->itemSpecs->count() : 0 }} Specs
                        </span>
                        
                        <!-- TOMBOL DETAIL BIRU GRADIENT -->
                        <a href="{{ route('admin.task.subProcess', $task->id ?? 1) }}" class="btn-detail-gradient">
                            Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                </div>
                @empty
                <!-- EMPTY STATE -->
                <div class="text-center py-5 text-muted small bg-white rounded-3 border border-dashed">
                    <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary opacity-50"></i>
                    <span class="fw-semibold">Belum ada project</span>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection