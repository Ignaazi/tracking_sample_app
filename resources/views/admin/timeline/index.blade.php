@extends('layouts.admin')

@section('title', 'Module Timeline Tracking')

@section('content')

    <!-- Include Frappe Gantt CSS & JS via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.css">
    <script src="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js"></script>

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark mb-1" style="font-size: 24px;">Module Timeline</h1>
        <p class="text-muted mb-0" style="font-size: 13px;">Advanced product development roadmap with interactive gantt grid scaling.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert" style="background-color: #e1fcef; color: #0f5132; font-size: 13px;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ================================================================ -->
    <!-- 🌟 ADVANCED INTERACTIVE TIMELINE ROADMAP (LIBRARY DRIVEN)       -->
    <!-- ================================================================ -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-3">
                <h5 class="card-title m-0 fw-bold" style="color: #012970; font-size: 16px;">
                    <i class="fa-solid fa-network-wired me-2 text-primary"></i>Enterprise Gantt Interactive
                </h5>
                <!-- Pengatur Skala Waktu Gunting Grid -->
                <div class="btn-group btn-group-sm shadow-sm" role="group">
                    <button type="button" class="btn btn-outline-primary active" onclick="changeView('Day')">Day</button>
                    <button type="button" class="btn btn-outline-primary" onclick="changeView('Week')">Week</button>
                    <button type="button" class="btn btn-outline-primary" onclick="changeView('Month')">Month</button>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm rounded px-3 fw-bold" style="font-size: 12px; background-color: #4154f1;" data-bs-toggle="modal" data-bs-target="#addTimelineModal">
                <i class="fa-solid fa-plus me-1"></i> Add Schedule Task
            </button>
        </div>

        <div class="card-body p-0 bg-light">
            <!-- Tempat Rander Canvas Gantt Chart Utama -->
            <div class="gantt-target-wrapper overflow-auto" style="background: #ffffff; max-height: 500px;">
                <svg id="gantt-container"></svg>
            </div>
        </div>
    </div>

    <!-- ================================================================ -->
    <!-- TABEL LOG MANAGEMENT DATA (CRUD RECORD)                           -->
    <!-- ================================================================ -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="m-0 fw-bold text-secondary" style="font-size: 14px;"><i class="fa-solid fa-list-check me-2"></i>Timeline Tasks Registry</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="ps-3 py-3">Project / Task</th>
                            <th>Phase Tier</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Progress</th>
                            <th class="pe-3 text-end" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($timelines as $task)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold text-dark">{{ $task->project_name }}</div>
                                <small class="text-muted">{{ $task->task_title }}</small>
                            </td>
                            <td>
                                @php
                                    $badgeColor = match($task->phase) {
                                        'Plan' => '#3b82f6',
                                        'Test' => '#f59e0b',
                                        'Develop' => '#10b981',
                                        'Launch' => '#6b7280',
                                        default => '#6c757d'
                                    };
                                @endphp
                                <span class="badge text-white" style="background-color: {{ $badgeColor }}; font-size: 11px;">
                                    {{ $task->phase }}
                                </span>
                            </td>
                            <td><span class="badge bg-light text-dark border font-monospace">{{ date('Y-m-d', strtotime($task->start_date)) }}</span></td>
                            <td><span class="badge bg-light text-dark border font-monospace">{{ date('Y-m-d', strtotime($task->end_date)) }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-primary">{{ $task->progress_percent }}%</span>
                                </div>
                            </td>
                            <td class="pe-3 text-end">
                                <div class="d-inline-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary border-0 p-1 px-2" data-bs-toggle="modal" data-bs-target="#editTimelineModal{{ $task->id }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.timelines.destroy', $task->id) }}" method="POST" class="m-0" onsubmit="return confirm('Delete this timeline task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1 px-2">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL EDIT TIMELINE -->
                        <div class="modal fade" id="editTimelineModal{{ $task->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-0 bg-light py-3">
                                        <h5 class="modal-title fw-bold" style="font-size: 16px; color:#012970;"><i class="fa-solid fa-pen-to-square me-2"></i>Modify Task Schedule</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.timelines.update', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4" style="font-size: 13px;">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">Project Name</label>
                                                <input type="text" name="project_name" class="form-control form-control-sm rounded" value="{{ $task->project_name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">Phase Group</label>
                                                <select name="phase" class="form-select form-select-sm rounded" required>
                                                    <option value="Plan" {{ $task->phase == 'Plan' ? 'selected' : '' }}>Plan</option>
                                                    <option value="Test" {{ $task->phase == 'Test' ? 'selected' : '' }}>Test</option>
                                                    <option value="Develop" {{ $task->phase == 'Develop' ? 'selected' : '' }}>Develop</option>
                                                    <option value="Launch" {{ $task->phase == 'Launch' ? 'selected' : '' }}>Launch</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary">Task Title</label>
                                                <input type="text" name="task_title" class="form-control form-control-sm rounded" value="{{ $task->task_title }}" required>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label fw-bold text-secondary">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control form-control-sm rounded" value="{{ $task->start_date }}" required>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label fw-bold text-secondary">End Date</label>
                                                    <input type="date" name="end_date" class="form-control form-control-sm rounded" value="{{ $task->end_date }}" required>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-bold text-secondary">Progress Percent (0 - 100%)</label>
                                                <input type="number" name="progress_percent" class="form-control form-control-sm rounded" min="0" max="100" value="{{ $task->progress_percent }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-light py-2">
                                            <button type="button" class="btn btn-sm btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-primary rounded" style="background-color: #4154f1;">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No timeline log records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH TIMELINE -->
    <div class="modal fade" id="addTimelineModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light py-3">
                    <h5 class="modal-title fw-bold" style="font-size: 16px; color:#012970;"><i class="fa-solid fa-calendar-plus me-2"></i>New Task Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.timelines.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4" style="font-size: 13px;">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Project Name</label>
                            <input type="text" name="project_name" class="form-control form-control-sm rounded" placeholder="Contoh: AMCOR Scan Scanner System" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Timeline Phase</label>
                            <select name="phase" class="form-select form-select-sm rounded" required>
                                <option value="" selected disabled>-- Pilih Fase Kategori --</option>
                                <option value="Plan">Plan</option>
                                <option value="Test">Test</option>
                                <option value="Develop">Develop</option>
                                <option value="Launch">Launch</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Task Title</label>
                            <input type="text" name="task_title" class="form-control form-control-sm rounded" placeholder="Contoh: Subcontractor Selection" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label fw-bold text-secondary">Start Date</label>
                                <input type="date" name="start_date" class="form-control form-control-sm rounded" required>
                            </div>
                            <div class="col">
                                <label class="form-label fw-bold text-secondary">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-sm rounded" required>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold text-secondary">Initial Progress (%)</label>
                            <input type="number" name="progress_percent" class="form-control form-control-sm rounded" min="0" max="100" value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light py-2">
                        <button type="button" class="btn btn-sm btn-secondary rounded" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary rounded" style="background-color: #4154f1;">Submit Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================================================================ -->
    <!-- JAVASCRIPT LOGIC UNTUK FRAEPPE GANTT ENGINE                      -->
    <!-- ================================================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Passing data dari database Laravel Eloquent ke format Array JavaScript Object
            const tasksData = [
                @foreach($timelines as $task)
                {
                    id: 'Task-{{ $task->id }}',
                    name: '[{{ $task->phase }}] {{ $task->project_name }}',
                    start: '{{ date("Y-m-d", strtotime($task->start_date)) }}',
                    end: '{{ date("Y-m-d", strtotime($task->end_date)) }}',
                    progress: {{ $task->progress_percent }},
                    custom_class: 'gantt-{{ strtolower($task->phase) }}'
                },
                @endforeach
            ];

            // Jika database kosong, berikan data sampel placeholder agar diagram tidak crash kosong
            if(tasksData.length === 0) {
                tasksData.push({
                    id: 'Sample-1', name: '[Plan] No Active System Tasks Found',
                    start: '2026-06-01', end: '2026-06-15', progress: 30, custom_class: 'gantt-plan'
                });
            }

            // Inisialisasi Instance Frappe Gantt Chart
            window.gantt_chart = new Gantt("#gantt-container", tasksData, {
                header_height: 50,
                column_width: 30,
                step: 24,
                view_modes: ['Day', 'Week', 'Month'],
                view_mode: 'Day',
                bar_height: 25,
                bar_corner_radius: 4,
                arrow_curve: 5,
                padding: 18,
                date_format: 'YYYY-MM-DD',
                custom_popup_html: function(task) {
                    return `
                        <div class="p-2 text-white font-sans" style="background: #212529; border-radius: 5px; font-size:11px; min-width:160px;">
                            <div class="fw-bold mb-1 border-bottom pb-1 text-warning">${task.name}</div>
                            <div><b>Start:</b> ${task.start}</div>
                            <div><b>End:</b> ${task.end}</div>
                            <div><b>Progress:</b> ${task.progress}% Complete</div>
                        </div>
                    `;
                }
            });
        });

        // Fungsi Tombol Switch View Mode (Day, Week, Month Grid Lines)
        function changeView(mode) {
            if(window.gantt_chart) {
                window.gantt_chart.change_view_mode(mode);
                
                // Atur status active class tombol bootstrap nya
                const buttons = document.querySelectorAll('.btn-group button');
                buttons.forEach(btn => btn.classList.remove('active'));
                event.target.classList.add('active');
            }
        }
    </script>

    <!-- Custom CSS untuk Menyesuaikan Tema NiceAdmin dengan Warna Phase Kategori -->
    <style>
        /* Mengubah warna bar gantt chart berdasarkan class kategori */
        .gantt-container .gantt-plan .bar { fill: #3b82f6 !important; }
        .gantt-container .gantt-plan .bar-progress { fill: #1d4ed8 !important; }

        .gantt-container .gantt-test .bar { fill: #f59e0b !important; }
        .gantt-container .gantt-test .bar-progress { fill: #b45309 !important; }

        .gantt-container .gantt-develop .bar { fill: #10b981 !important; }
        .gantt-container .gantt-develop .bar-progress { fill: #047857 !important; }

        .gantt-container .gantt-launch .bar { fill: #6b7280 !important; }
        .gantt-container .gantt-launch .bar-progress { fill: #374151 !important; }

        /* Styling tambahan agar teks di dalam grid SVG terbaca jelas */
        .gantt .grid-header { fill: #f8f9fa !important; stroke: #e9ecef !important; }
        .gantt .upper-header { font-size: 11px; fill: #495057 !important; font-weight: bold; }
        .gantt .lower-header { font-size: 10px; fill: #6c757d !important; }
        .gantt .bar-label { fill: #ffffff !important; font-size: 11px; font-weight: 600; }
    </style>

@endsection