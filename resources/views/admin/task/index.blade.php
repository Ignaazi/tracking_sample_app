@extends('layouts.admin')

@section('title', 'Project Task Workspace')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1" style="font-size: 24px;">Tasks Development Workspace</h1>
            <p class="text-muted mb-0" style="font-size: 13px;"><i class="fa-solid fa-list-check text-primary me-1"></i> Sprint tracking cards for checking features and milestones.</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded-3 fw-bold px-3 py-2 shadow-sm border-0" style="background-color: #4154f1;" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="fa-solid fa-plus me-1"></i> Create Task
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm rounded-3" role="alert" style="background-color: #ecfdf5; color: #065f46; font-size: 13px;">
            <i class="fa-solid fa-circle-check me-2 text-success"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3">
        
        @php
            // Struktur data mapping untuk render 4 kolom board utama
            $columns = [
                ['title' => 'To Do', 'bg' => '#3b82f6', 'data' => $todo],
                ['title' => 'In Progress', 'bg' => '#a855f7', 'data' => $inProgress],
                ['title' => 'Ready for QA', 'bg' => '#f97316', 'data' => $readyQa],
                ['title' => 'Completed', 'bg' => '#10b981', 'data' => $completed]
            ];
        @endphp

        @foreach($columns as $col)
        <div class="col-xl-3 col-md-6">
            <div class="kanban-column p-2 rounded-3 bg-light border min-vh-100">
                
                <div class="d-flex align-items-center gap-2 px-2 py-2 mb-3">
                    <span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: {{ $col['bg'] }};"></span>
                    <h6 class="m-0 fw-bold text-dark" style="font-size: 14px;">{{ $col['title'] }}</h6>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary ms-auto rounded-pill font-monospace" style="font-size: 11px;">{{ $col['data']->count() }}</span>
                </div>

                <div class="d-flex flex-column gap-2.5">
                    @forelse($col['data'] as $task)
                        @php
                            $priorityColor = match($task->priority) {
                                'High' => ['bg' => '#fee2e2', 'text' => '#ef4444'],
                                'Medium' => ['bg' => '#fef3c7', 'text' => '#d97706'],
                                default => ['bg' => '#e0f2fe', 'text' => '#0284c7']
                            };
                        @endphp
                        
                        <div class="card kanban-card border-0 shadow-sm rounded-3 p-3 bg-white transition-hover" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge text-uppercase font-monospace" style="font-size: 9px; padding: 3px 6px; background-color: {{ $priorityColor['bg'] }}; color: {{ $priorityColor['text'] }};">
                                    {{ $task->priority }}
                                </span>
                                <div class="dropdown" onclick="event.stopPropagation();">
                                    <button class="btn p-0 border-0 text-muted" type="button" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical" style="font-size: 11px;"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="font-size: 12px;">
                                        <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); if(confirm('Delete this task card?')) document.getElementById('delete-task-{{ $task->id }}').submit();"><i class="fa-regular fa-trash-can me-2"></i>Delete</a></li>
                                    </ul>
                                    <form id="delete-task-{{ $task->id }}" action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mb-1 lh-sm" style="font-size: 13.5px;">{{ $task->title }}</h6>
                            <p class="text-muted mb-3 text-truncate-2" style="font-size: 11.5px; line-height: 1.4;">{{ $task->description ?? 'No extra task summaries injected.' }}</p>
                            
                            <div class="d-flex align-items-center text-secondary font-monospace border-top pt-2 mt-auto" style="font-size: 10px;">
                                <i class="fa-regular fa-calendar text-muted me-1.5"></i>
                                <span>{{ date('M d', strtotime($task->start_date)) }} - {{ date('M d', strtotime($task->end_date)) }}</span>
                            </div>
                        </div>

                        <div class="modal fade" id="editTaskModal{{ $task->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" onclick="event.stopPropagation();">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-3">
                                    <div class="modal-header border-0 bg-light py-3">
                                        <h5 class="modal-title fw-bold text-dark" style="font-size: 15px;"><i class="fa-solid fa-sliders text-primary me-2"></i>Task Specifications</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body p-4" style="font-size: 13px;">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">Task Title Context</label>
                                                <input type="text" name="title" class="form-control rounded border shadow-none" value="{{ $task->title }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">Task Summaries</label>
                                                <textarea name="description" class="form-control rounded border shadow-none" rows="3">{{ $task->description }}</textarea>
                                            </div>
                                            <div class="row mb-3 g-2">
                                                <div class="col-6">
                                                    <label class="form-label fw-bold text-secondary">Status Pipeline</label>
                                                    <select name="status" class="form-select rounded border shadow-none" required>
                                                        <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                                        <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="Ready for QA" {{ $task->status == 'Ready for QA' ? 'selected' : '' }}>Ready for QA</option>
                                                        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-bold text-secondary">Priority Level</label>
                                                    <select name="priority" class="form-select rounded border shadow-none" required>
                                                        <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                                        <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                        <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-0 g-2">
                                                <div class="col-6">
                                                    <label class="form-label fw-bold text-secondary">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control rounded border shadow-none" value="{{ $task->start_date }}" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-bold text-secondary">End Date</label>
                                                    <input type="date" name="end_date" class="form-control rounded border shadow-none" value="{{ $task->end_date }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-light py-2">
                                            <button type="button" class="btn btn-sm btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-sm btn-primary rounded-2 px-3" style="background-color: #4154f1; border:none;">Update Card Node</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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

    <div class="modal fade" id="addTaskModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header border-0 bg-light py-3">
                    <h5 class="modal-title fw-bold text-dark" style="font-size: 15px;"><i class="fa-solid fa-calendar-plus text-primary me-2"></i>Initialize New Task Node</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4" style="font-size: 13px;">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Task Title Context</label>
                            <input type="text" name="title" class="form-control rounded border shadow-none" placeholder="e.g., Conversion Rate Analysis" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Task Summaries Details</label>
                            <textarea name="description" class="form-control rounded border shadow-none" rows="3" placeholder="Analyze system flow parameters..."></textarea>
                        </div>
                        <div class="row mb-3 g-2">
                            <div class="col-6">
                                <label class="form-label fw-bold text-secondary">Initial Board Pillar</label>
                                <select name="status" class="form-select rounded border shadow-none" required>
                                    <option value="To Do" selected>To Do</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Ready for QA">Ready for QA</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-secondary">Priority Weight</label>
                                <select name="priority" class="form-select rounded border shadow-none" required>
                                    <option value="Low" selected>Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-0 g-2">
                            <div class="col-6">
                                <label class="form-label fw-bold text-secondary">Start Date</label>
                                <input type="date" name="start_date" class="form-control rounded border shadow-none" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold text-secondary">End Date</label>
                                <input type="date" name="end_date" class="form-control rounded border shadow-none" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light py-2">
                        <button type="button" class="btn btn-sm btn-secondary rounded-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary rounded-2 px-3" style="background-color: #4154f1; border:none;">Push Task Node</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .kanban-column { background-color: #f8fafc !important; min-height: 75vh; }
        .kanban-card { transition: all 0.2s ease-in-out; border: 1px solid rgba(0,0,0,0.03) !important; }
        .kanban-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important; border-color: rgba(0,0,0,0.08) !important; }
        .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>

@endsection