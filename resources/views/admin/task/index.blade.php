@extends('layouts.admin')

@section('title', 'Project Task Workspace')

@push('styles')
    <!-- Hubungkan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* ==========================================================================
           CSS KANBAN BOARD MURNI (SESUAI KODE YANG LU KASIH)
           ========================================================================== */
        .kanban-board {
            display: flex;
            gap: 1.25rem;
            overflow-x: auto;
            padding: 1rem 0;
            align-items: flex-start;
            min-height: calc(100vh - 100px);
        }

        .kanban-column {
            flex: 0 0 300px;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }

        .kanban-column-header {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }

        .kanban-column-title {
            display: flex;
            align-items: center;
            color: #212529;
        }

        .kanban-column-count {
            font-size: 0.85rem;
            background-color: #e9ecef;
            color: #6c757d;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            margin-left: 0.5rem;
        }

        .kanban-column-btn {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.25rem;
        }

        .kanban-column-btn:hover {
            background-color: #e9ecef;
            color: #212529;
        }

        .kanban-column-body {
            padding: 0 1rem 1rem 1rem;
            overflow-y: auto;
            flex-grow: 1;
            min-height: 150px;
            transition: background-color 0.2s ease;
        }

        .kanban-column-body.drag-over {
            background-color: #e9ecef;
            border-radius: 0 0 0.5rem 0.5rem;
        }

        /* Desain Kartu (Card) */
        .kanban-card {
            background-color: #ffffff;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #dee2e6;
            cursor: grab;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            position: relative;
        }

        .kanban-card:active {
            cursor: grabbing;
        }

        .kanban-card.dragging {
            opacity: 0.5;
        }

        .kanban-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .kanban-card-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #212529;
            margin: 0.5rem 0;
        }

        .kanban-card-description {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .kanban-card-labels {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            margin-bottom: 0.5rem;
        }

        /* Badge Sub-Proses Lu */
        .process-pill {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.15rem 0.5rem !important;
            border-radius: 0.25rem !important;
            cursor: pointer;
            text-transform: capitalize;
        }

        /* Warna Status Custom */
        .sp-completed { background-color: #dcfce7; color: #15803d; }
        .sp-progress { background-color: #fee2e2; color: #b91c1c; }
        .sp-default { background-color: #f3f4f6; color: #374151; }

        .kanban-due-date {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.15rem 0.4rem;
            border-radius: 0.25rem;
            margin-bottom: 0.75rem;
            background-color: #f3f4f6;
            color: #374151;
        }

        .kanban-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #6c757d;
            border-top: 1px solid #f4f6f9;
            padding-top: 0.5rem;
        }

        .kanban-card-meta {
            display: flex;
            gap: 0.5rem;
        }

        .kanban-card-meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .kanban-card-assignees {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .kanban-add-card {
            width: 100%;
            background: none;
            border: 1px dashed #ced4da;
            padding: 0.5rem;
            border-radius: 0.375rem;
            color: #6c757d;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .kanban-add-card:hover {
            background-color: #e9ecef;
            color: #212529;
            border-color: #adb5bd;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid py-3">

    <!-- HEADER UTAMA -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Kanban Project Board</h2>
            <p class="text-muted small mb-0">Manage tasks, custom layout specifications, and workflow tracker.</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm rounded-2 px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="bi bi-plus-lg"></i> Create Task
        </button>
    </div>
    
    <!-- KANBAN BOARD WRAPPER -->
    <div class="kanban-board" id="kanbanBoard">
        
        @php
            // Mapping Data Kolom Dinamis Laravel Lu
            $columns = [
                ['title' => 'To Do', 'status' => 'todo', 'data' => $todo],
                ['title' => 'In Progress', 'status' => 'in-progress', 'data' => $inProgress],
                ['title' => 'Ready for QA', 'status' => 'review', 'data' => $readyQa],
                ['title' => 'Completed', 'status' => 'done', 'data' => $completed]
            ];
        @endphp

        @foreach($columns as $col)
        <!-- Kanban Column -->
        <div class="kanban-column" data-status="{{ $col['status'] }}">
            <div class="kanban-column-header">
                <div class="kanban-column-title">
                    {{ $col['title'] }}
                    <span class="kanban-column-count">{{ $col['data']->count() }}</span>
                </div>
                <div class="kanban-column-actions">
                    <button class="kanban-column-btn" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i class="bi bi-plus"></i></button>
                    <button class="kanban-column-btn"><i class="bi bi-three-dots"></i></button>
                </div>
            </div>

            <div class="kanban-column-body" data-status="{{ $col['status'] }}">
                
                @forelse($col['data'] as $task)
                    <!-- Kanban Card (Bisa Di-Drag) -->
                    <div class="kanban-card" draggable="true" data-id="{{ $task->id }}">
                        
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <!-- Label Sub Proses Interaktif -->
                            <div class="kanban-card-labels">
                                <span class="badge process-pill {{ $task->layout_status == 'Completed' ? 'sp-completed' : ($task->layout_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_layout">Layout</span>
                                <span class="badge process-pill {{ $task->baan_status == 'Completed' ? 'sp-completed' : ($task->baan_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_baan">Baan</span>
                                <span class="badge process-pill {{ $task->promp_status == 'Completed' ? 'sp-completed' : ($task->promp_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_promp">Prompt</span>
                                <span class="badge process-pill {{ $task->job_bag_status == 'Completed' ? 'sp-completed' : ($task->job_bag_status == 'In Progress' ? 'sp-progress' : 'sp-default') }}" data-bs-toggle="modal" data-bs-target="#subProcessModal{{ $task->id }}_jobbag">Job Bag</span>
                            </div>

                            <!-- Dropdown Menu Kebab Aksi -->
                            <div class="dropdown">
                                <button class="btn p-0 border-0 text-muted shadow-none" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots" style="font-size: 14px;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-1 py-1" style="font-size: 12px;">
                                    <li><a class="dropdown-item py-1.5" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Specification</a></li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li><a class="dropdown-item text-danger py-1.5" href="#" onclick="event.preventDefault(); if(confirm('Delete this task?')) document.getElementById('delete-task-{{ $task->id }}').submit();"><i class="bi bi-trash me-2"></i>Delete Project</a></li>
                                </ul>
                                <form id="delete-task-{{ $task->id }}" action="{{ route('admin.task.destroy', $task->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </div>

                        <!-- Data Konten Project -->
                        <div class="kanban-card-title">{{ $task->project_name }}</div>
                        
                        <div class="mb-2" style="font-size: 11.5px;">
                            <span class="fw-bold text-dark">{{ $task->item_code }}</span> 
                            <span class="text-muted">• {{ $task->sap_number ?? '000-000' }}</span>
                        </div>

                        <div class="kanban-card-description">
                            Client: <strong>{{ $task->customer }}</strong>, Brand: <strong>{{ $task->brand_family ?? '-' }}</strong>, Market: <span class="text-uppercase fw-bold text-primary">[{{ $task->market ?? 'INDO' }}]</span>.
                        </div>

                        <div class="kanban-due-date">
                            <i class="bi bi-calendar"></i> {{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('M d') : 'Jan 18' }}
                        </div>

                        <!-- Footer Meta Info -->
                        <div class="kanban-card-footer">
                            <div class="kanban-card-meta">
                                <span class="kanban-card-meta-item"><i class="bi bi-chat-dots"></i> 3</span>
                                <span class="kanban-card-meta-item"><i class="bi bi-paperclip"></i> 1</span>
                            </div>
                            <div class="kanban-card-assignees">
                                <i class="bi bi-pencil-square text-muted cursor-pointer me-1" style="font-size: 13px;" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" title="Quick Edit"></i>
                                <i class="bi bi-person-circle text-secondary" style="font-size: 14px;"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Panggil File Modals Parsial bawaan Laravel Lu -->
                    @include('admin.task.partials.modal-sub-process')
                    @include('admin.task.partials.modal-edit-specs')

                @empty
                    <div class="text-center py-4 px-2 text-muted border border-dashed rounded bg-white small mb-3" style="font-style: italic;">
                        No active tasks.
                    </div>
                @endforelse

                <button class="kanban-add-card" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bi bi-plus"></i> Add Card
                </button>
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
        const cards = document.querySelectorAll('.kanban-card');
        const columns = document.querySelectorAll('.kanban-column-body');

        cards.forEach(card => {
            card.addEventListener('dragstart', () => {
                card.classList.add('dragging');
            });

            card.addEventListener('dragend', () => {
                card.classList.remove('dragging');
            });
        });

        columns.forEach(column => {
            column.addEventListener('dragover', (e) => {
                e.preventDefault(); // Wajib agar drop aktif
                column.classList.add('drag-over');
                
                const draggingCard = document.querySelector('.dragging');
                const afterElement = getDragAfterElement(column, e.clientY);
                
                if (afterElement == null) {
                    const addCardBtn = column.querySelector('.kanban-add-card');
                    column.insertBefore(draggingCard, addCardBtn);
                } else {
                    column.insertBefore(draggingCard, afterElement);
                }
            });

            column.addEventListener('dragleave', () => {
                column.classList.remove('drag-over');
            });

            column.addEventListener('drop', () => {
                column.classList.remove('drag-over');
                const draggingCard = document.querySelector('.dragging');
                
                // Log untuk ngecek pergerakan di console log browser lu
                console.log(`Card ID: ${draggingCard.dataset.id} dipindah ke status: ${column.dataset.status}`);
                
                // TODO: Di sini lu tinggal pasang Fetch/Axios API jika ingin simpan perubahan status drop-nya secara permanen ke DB Laravel.
            });
        });

        function getDragAfterElement(column, y) {
            const draggableElements = [...column.querySelectorAll('.kanban-card:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }
    });
</script>
@endpush