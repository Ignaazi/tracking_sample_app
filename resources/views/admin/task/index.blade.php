@extends('layouts.admin')

@section('title', 'Project Task Workspace')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kanban-style.css') }}">
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4" style="font-family: 'Nunito', sans-serif;">
        <div>
            <h1 class="fw-bold mb-1" style="font-size: 24px; color: #012970;">Tasks Development Workspace</h1>
            <nav style="--bs-breadcrumb-divider: '/';">
                <ol class="breadcrumb mb-0" style="font-size: 12.5px;">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item text-muted">Forms</li>
                    <li class="breadcrumb-item active fw-semibold" style="color: #012970;">Layout Kanban</li>
                </ol>
            </nav>
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
        <div class="col-xl-3 col-md-6">
            <div class="kanban-column p-2.5 rounded-3 border-0 shadow-sm" style="background-color: #f6f9ff; min-height: 80vh;">
                
                <div class="d-flex align-items-center gap-2 px-2 py-2 mb-3">
                    <span class="d-inline-block rounded-circle" style="width: 10px; height: 10px; background-color: {{ $col['bg'] }};"></span>
                    <h6 class="m-0 fw-bold" style="font-size: 14px; color: #012970;">{{ $col['title'] }}</h6>
                    <span class="badge ms-auto rounded-pill" style="font-size: 11px; background-color: {{ $col['light_bg'] }}; color: {{ $col['badge'] }}; font-weight: 700;">{{ $col['data']->count() }}</span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($col['data'] as $task)
                        
                        <div class="card kanban-card border-0 shadow-sm rounded-3 p-3 bg-white position-relative" style="border-left: 4px solid {{ $col['bg'] }} !important;">
                            
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge rounded-1" style="font-size: 9px; padding: 4px 6px; background-color: {{ $task->development_status == 'Active' ? '#e0f2fe' : '#fee2e2' }}; color: {{ $task->development_status == 'Active' ? '#0369a1' : '#b91c1c' }}; font-weight: 700;">
                                    {{ $task->development_status }}
                                </span>
                                <div class="dropdown">
                                    <button class="btn p-0 border-0 text-muted" type="button" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis" style="font-size: 13px;"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="font-size: 12px;">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}"><i class="fa-regular fa-pen-to-square me-2 text-primary"></i>Full Edit Specs</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); if(confirm('Delete this project node?')) document.getElementById('delete-task-{{ $task->id }}').submit();"><i class="fa-regular fa-trash-can me-2"></i>Delete Project</a></li>
                                    </ul>
                                    <form id="delete-task-{{ $task->id }}" action="{{ route('admin.task.destroy', $task->id) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mb-1 lh-sm" style="font-size: 13.5px; color: #012970 !important;">{{ $task->project_name }}</h6>
                            <div class="text-muted mb-2 font-monospace" style="font-size: 10.5px;">
                                <span class="text-primary fw-bold">{{ $task->item_code }}</span> | {{ $task->sap_number }}
                            </div>

                            <div class="p-2 rounded-2 mb-3" style="background-color: #f8fafc; font-size: 11.5px;">
                                <div class="d-flex justify-content-between mb-1"><span class="text-muted">Client:</span><span class="fw-bold text-dark">{{ $task->customer }}</span></div>
                                <div class="d-flex justify-content-between mb-1"><span class="text-muted">Brand:</span><span class="fw-bold text-dark">{{ $task->brand_family }}</span></div>
                                <div class="d-flex justify-content-between"><span class="text-muted">Market:</span><span class="badge bg-secondary bg-opacity-10 text-secondary px-1.5 py-0.5">{{ $task->market }}</span></div>
                            </div>

                            <div class="pt-2.5 border-top">
                                <div class="row g-1 text-center" style="font-size: 10px; font-weight: 700;">
                                    <div class="col-3">
                                        <span class="grid-badge d-block py-1.5 rounded-2 cursor-pointer {{ $task->layout_status == 'Completed' ? 'bg-success text-white' : ($task->layout_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}" 
                                              data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_layout">LYO</span>
                                    </div>
                                    <div class="col-3">
                                        <span class="grid-badge d-block py-1.5 rounded-2 cursor-pointer {{ $task->baan_status == 'Completed' ? 'bg-success text-white' : ($task->baan_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}"
                                              data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_baan">BAAN</span>
                                    </div>
                                    <div class="col-3">
                                        <span class="grid-badge d-block py-1.5 rounded-2 cursor-pointer {{ $task->promp_status == 'Completed' ? 'bg-success text-white' : ($task->promp_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}"
                                              data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_promp">PRMP</span>
                                    </div>
                                    <div class="col-3">
                                        <span class="grid-badge d-block py-1.5 rounded-2 cursor-pointer {{ $task->job_bag_status == 'Completed' ? 'bg-success text-white' : ($task->job_bag_status == 'In Progress' ? 'bg-warning text-dark' : 'bg-light text-muted border') }}"
                                              data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_jobbag">BAG</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @include('admin.task.partials.modal-sub-process')

                        @include('admin.task.partials.modal-edit-specs')

                    @empty
                        <div class="text-center py-4 text-muted border border-dashed rounded-3 bg-white" style="font-style: italic; font-size: 11px;">
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