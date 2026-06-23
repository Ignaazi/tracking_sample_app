@extends('layouts.admin')

@section('title', 'Project Task Workspace')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kanban-style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .kanban-column {
            background-color: #f6f9ff;
            min-height: 82vh;
            border-radius: 12px;
        }
        .kanban-card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            background-color: #ffffff;
        }
        .kanban-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(1, 41, 112, 0.08) !important;
        }
        /* Style 4 Kotak Point Utama di Kartu Kanban - DIKUNCI BIAR TIDAK ACAK-ACAKAN */
        .sub-process-grid-item {
            font-size: 10px;
            font-weight: 800;
            padding: 5px 0;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            width: 23%; /* Mengunci lebar proporsional 4 kotak */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        /* Badge Tanggal Soft Orange Premium ala Template NiceAdmin */
        .date-badge-custom {
            background-color: #fff7ed;
            color: #c2410c;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
    </style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4" style="font-family: 'Nunito', sans-serif;">
        <div>
            <h1 class="fw-bold mb-1" style="font-size: 24px; color: #012970;">Tasks Development Workspace</h1>
            <p class="text-muted m-0" style="font-size: 13.5px;">Track manufacturing specifications and pipeline stages</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded-3 fw-bold px-3 py-2 shadow-sm border-0 d-flex align-items-center gap-1" style="background-color: #4154f1; font-size: 13px;" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="fa-solid fa-plus"></i> Create Task
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm rounded-3" role="alert" style="background-color: #ecfdf5; color: #065f46; font-size: 13px; font-family: 'Nunito', sans-serif;">
            <i class="fa-solid fa-circle-check me-2 text-success"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3" style="font-family: 'Nunito', sans-serif;">
        
        @php
            $columns = [
                ['title' => 'To Do', 'bg' => '#3b82f6', 'light_bg' => '#eff6ff', 'badge' => '#2563eb', 'data' => $todo],
                ['title' => 'In Progress', 'bg' => '#a855f7', 'light_bg' => '#f3e8ff', 'badge' => '#7c3aed', 'data' => $inProgress],
                ['title' => 'Ready for QA', 'bg' => '#f97316', 'light_bg' => '#fff7ed', 'badge' => '#ea580c', 'data' => $readyQa],
                ['title' => 'Completed', 'bg' => '#10b981', 'light_bg' => '#ecfdf5', 'badge' => '#059669', 'data' => $completed]
            ];
        @endphp

        @foreach($columns as $col)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="kanban-column p-3 border-0 shadow-sm">
                
                <div class="d-flex align-items-center gap-2 px-1 mb-3">
                    <span class="d-inline-block rounded-circle" style="width: 10px; height: 10px; background-color: {{ $col['bg'] }};"></span>
                    <h6 class="m-0 fw-bold" style="font-size: 14px; color: #1e293b;">{{ $col['title'] }}</h6>
                    <span class="badge ms-auto rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; background-color: #e2e8f0; color: #475569; font-weight: 700; padding: 0;">
                        {{ $col['data']->count() }}
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($col['data'] as $task)
                        
                        <div class="card kanban-card shadow-xs p-3 position-relative" style="border-left: 4px solid {{ $col['bg'] }} !important;">
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                
                                <div class="d-flex gap-1 flex-grow-1">
                                    <span class="sub-process-grid-item {{ $task->layout_status == 'Completed' ? 'bg-success text-white' : ($task->layout_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}" 
                                          data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_layout">LYO</span>
                                    
                                    <span class="sub-process-grid-item {{ $task->baan_status == 'Completed' ? 'bg-success text-white' : ($task->baan_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}"
                                          data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_baan">BAAN</span>
                                    
                                    <span class="sub-process-grid-item {{ $task->promp_status == 'Completed' ? 'bg-success text-white' : ($task->promp_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}"
                                          data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_promp">PRMP</span>
                                    
                                    <span class="sub-process-grid-item {{ $task->job_bag_status == 'Completed' ? 'bg-success text-white' : ($task->job_bag_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}"
                                          data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_jobbag">BAG</span>
                                </div>

                                <div class="dropdown ms-2">
                                    <button class="btn p-0 border-0 text-muted shadow-none" type="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-ellipsis" style="font-size: 14px;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="font-size: 12px;">
                                        <li><a class="dropdown-item py-1.5" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}"><i class="fa-regular fa-pen-to-square me-2 text-primary"></i>Full Edit Specs</a></li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li><a class="dropdown-item text-danger py-1.5" href="#" onclick="event.preventDefault(); if(confirm('Delete this project node?')) document.getElementById('delete-task-{{ $task->id }}').submit();"><i class="fa-regular fa-trash-can me-2"></i>Delete Project</a></li>
                                    </ul>
                                    <form id="delete-task-{{ $task->id }}" action="{{ route('admin.task.destroy', $task->id) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-1" style="font-size: 14px; color: #1e293b;">{{ $task->project_name }}</h6>
                            
                            <div class="text-muted mb-2" style="font-size: 11.5px;">
                                <span class="fw-bold text-dark">{{ $task->item_code }}</span> <span class="text-secondary">• {{ $task->sap_number ?? '000-000' }}</span>
                            </div>

                            <div class="text-secondary mb-3" style="font-size: 12px; line-height: 1.45;">
                                Client <span class="fw-bold text-dark">{{ $task->customer }}</span> untuk brand <span class="fw-bold text-dark">{{ $task->brand_family ?? '-' }}</span>, distribusi pasar <span class="fw-bold text-dark text-uppercase">[{{ $task->market ?? 'INDO' }}]</span>.
                            </div>

                            <div class="pt-2.5 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="date-badge-custom">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <span>
                                        {{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('M d') : 'Jan 01' }} - 
                                        {{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('d, Y') : '2026' }}
                                    </span>
                                </div>

                                <span class="badge rounded-1 px-2 py-1 text-uppercase" style="font-size: 9.5px; font-weight: 800; background-color: {{ $task->development_status == 'Active' ? '#e0f2fe' : '#fee2e2' }}; color: {{ $task->development_status == 'Active' ? '#0369a1' : '#b91c1c' }};">
                                    {{ $task->development_status }}
                                </span>
                            </div>

                        </div>

                        @include('admin.task.partials.modal-sub-process')
                        @include('admin.task.partials.modal-edit-specs')

                    @empty
                        <div class="text-center py-4 text-muted border border-dashed rounded-3 bg-white" style="font-style: italic; font-size: 11.5px; border-color: #cbd5e1 !important;">
                            Empty stack items.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
        @endforeach

    </div>

    @include('admin.task.partials.modal-create-task')

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/kanban-script.js') }}"></script>
@endpush