@extends('layouts.admin')

@section('title', 'Detail Project Timeline - ' . $task->item_code)

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        .custom-gantt-wrapper, .custom-gantt-wrapper * {
            font-family: 'Nunito', sans-serif !important;
        }

        .gantt-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            padding: 24px;
        }

        /* HEADER BRANDING */
        .gantt-header-title {
            font-size: 26px;
            font-weight: 800;
            color: #1e293b;
        }

        .company-badge {
            background-color: #f97316;
            color: #ffffff;
            font-weight: 800;
            padding: 8px 24px;
            border-radius: 10px;
            font-size: 14px;
        }

        /* GANTT MAIN GRID CONTAINER */
        .gantt-main-container {
            display: flex;
            margin-top: 25px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        /* LEFT SIDEBAR (TASK LIST & GROUP BADGES) */
        .gantt-sidebar {
            width: 320px;
            flex-shrink: 0;
            border-right: 1.5px solid #cbd5e1;
            background-color: #fcfbf9;
            display: flex;
            flex-direction: column;
        }

        .gantt-sidebar-header {
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
            color: #0f172a;
            border-bottom: 1.5px solid #cbd5e1;
        }

        .sidebar-group-wrapper {
            display: flex;
            border-bottom: 1px solid #f1f5f9;
        }

        .vertical-group-pill {
            width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            color: #ffffff;
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            letter-spacing: 1px;
            padding: 12px 0;
            margin: 8px 6px;
            border-radius: 20px;
        }

        .pill-done-group {
            background-color: #f97316;
        }

        .pill-ongoing-group {
            background-color: #a855f7;
        }

        .sidebar-tasks-list {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .sidebar-task-item {
            height: 55px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            font-weight: 700;
            font-size: 13.5px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        /* RIGHT TIMELINE GRID */
        .gantt-timeline-area {
            flex-grow: 1;
            overflow-x: auto;
            display: flex;
            flex-direction: column;
        }

        .timeline-header-weeks {
            display: flex;
            height: 50px;
            border-bottom: 1.5px solid #cbd5e1;
            background-color: #ffffff;
        }

        .week-col-header {
            flex: 1;
            min-width: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            border-right: 1px solid #cbd5e1;
        }

        .week-col-header.active-week {
            background-color: #2dd4bf;
            color: #ffffff;
            font-weight: 800;
        }

        /* TIMELINE ROWS & GRID LINES */
        .timeline-rows-container {
            display: flex;
            flex-direction: column;
            position: relative;
            background-size: calc(100% / 9) 100%;
            background-image: linear-gradient(to right, #cbd5e1 1px, transparent 1px);
        }

        .timeline-row {
            height: 55px;
            position: relative;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #fed7aa;
        }

        /* BARIS WARNA PROGRESS GANTT */
        .gantt-bar-pill {
            position: absolute;
            height: 24px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .bar-done {
            background-color: #f97316;
        }

        .bar-ongoing {
            background-color: #c084fc;
        }

        /* PRODUCT SPEC & PHOTO HEADER CARD */
        .project-spec-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
        }
    </style>
@endpush

@section('content')
<div class="custom-gantt-wrapper container-fluid py-4 px-4">

    <!-- TOP NAVIGATION -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ route('admin.timelines.index') }}" class="btn btn-sm btn-outline-secondary fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Master Roadmap
        </a>
        <button class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#editDatesModal">
            <i class="bi bi-pencil-square me-1"></i> Edit Schedule & Dates
        </button>
    </div>

    <!-- PROJECT INFO HEADER CARD WITH SPEC & IMAGE -->
    <div class="project-spec-card mb-4">
        <div class="row align-items-center">
            <div class="col-md-2 text-center border-end">
                @if(!empty($task->image))
                    <img src="{{ asset('storage/' . $task->image) }}" alt="Spec Image" class="img-fluid rounded shadow-sm" style="max-height: 80px; object-fit: cover;">
                @else
                    <div class="bg-light border rounded py-3 text-muted small">
                        <i class="bi bi-image fs-3 d-block mb-1 opacity-50"></i>
                        No Image
                    </div>
                @endif
            </div>
            <div class="col-md-10 ps-md-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold text-dark mb-1">{{ $task->item_code }} - {{ $task->project_name ?? 'Project Title' }}</h4>
                    <span class="badge bg-dark font-monospace">SAP: {{ $task->sap_number ?? '-' }}</span>
                </div>
                <div class="row mt-2 text-secondary small fw-bold">
                    <div class="col-md-3"><i class="bi bi-building me-1"></i> Customer: <span class="text-dark">{{ $task->customer ?? '-' }}</span></div>
                    <div class="col-md-3"><i class="bi bi-tags me-1"></i> Brand: <span class="text-dark">{{ $task->brand_family ?? '-' }}</span></div>
                    <div class="col-md-3"><i class="bi bi-globe me-1"></i> Market: <span class="text-dark">{{ $task->market ?? '-' }}</span></div>
                    <div class="col-md-3"><i class="bi bi-calendar-check me-1"></i> Info Rec: <span class="text-dark">{{ $task->information_received ?? '-' }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN GANTT GRAPH CARD (SAMA SEPERTI GAMBAR) -->
    <div class="gantt-card">
        
        <!-- HEADER GRAPH -->
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-2">
            <div class="gantt-header-title">
                Gantt Chart <span style="color: #f97316;">Graph</span>
            </div>
            <div class="company-badge">
                {{ $task->customer ?? 'Enterprise Roadmap' }}
            </div>
        </div>

        @php
            // MAPPING SUB-TASKS & TANGGAL
            $subTasksDone = [
                [
                    'name' => 'Layout Management',
                    'progress' => $task->layout_status == 'Completed' ? '100%' : '50%',
                    'left_pos' => '5%',
                    'width_pos' => '20%',
                ],
                [
                    'name' => 'BaaN ERP System Mapping',
                    'progress' => $task->baan_status == 'Completed' ? '100%' : '60%',
                    'left_pos' => '18%',
                    'width_pos' => '25%',
                ],
                [
                    'name' => 'Prompt Quality Verification',
                    'progress' => $task->promp_status == 'Completed' ? '100%' : '40%',
                    'left_pos' => '38%',
                    'width_pos' => '18%',
                ],
            ];

            $subTasksOngoing = [
                [
                    'name' => 'Job Bag Production Release',
                    'progress' => '90%',
                    'left_pos' => '52%',
                    'width_pos' => '38%',
                ],
                [
                    'name' => 'Optimization & Trial Run',
                    'progress' => '70%',
                    'left_pos' => '52%',
                    'width_pos' => '22%',
                ],
                [
                    'name' => 'Final PLM Results',
                    'progress' => '40%',
                    'left_pos' => '68%',
                    'width_pos' => '18%',
                ],
            ];
        @endphp

        <!-- GANTT MAIN CONTAINER -->
        <div class="gantt-main-container">

            <!-- SIDEBAR KIRI (TASK LIST + VERTICAL BADGES) -->
            <div class="gantt-sidebar">
                <div class="gantt-sidebar-header">
                    Task List
                </div>

                <!-- GROUP DONE -->
                <div class="sidebar-group-wrapper">
                    <div class="vertical-group-pill pill-done-group">
                        Done
                    </div>
                    <div class="sidebar-tasks-list">
                        @foreach($subTasksDone as $sub)
                            <div class="sidebar-task-item">{{ $sub['name'] }}</div>
                        @endforeach
                    </div>
                </div>

                <!-- GROUP ON GOING -->
                <div class="sidebar-group-wrapper" style="border-bottom: none;">
                    <div class="vertical-group-pill pill-ongoing-group">
                        On Going
                    </div>
                    <div class="sidebar-tasks-list">
                        @foreach($subTasksOngoing as $sub)
                            <div class="sidebar-task-item">{{ $sub['name'] }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- TIMELINE AREA KANAN (WEEK 1 - WEEK 9 GRID) -->
            <div class="gantt-timeline-area">
                
                <!-- HEADER WEEKS -->
                <div class="timeline-header-weeks">
                    <div class="week-col-header">Week 1</div>
                    <div class="week-col-header">Week 2</div>
                    <div class="week-col-header">Week 3</div>
                    <div class="week-col-header">Week 4</div>
                    <div class="week-col-header">Week 5</div>
                    <div class="week-col-header">Week 6</div>
                    <div class="week-col-header active-week">Week 7</div>
                    <div class="week-col-header">Week 8</div>
                    <div class="week-col-header" style="border-right: none;">Week 9</div>
                </div>

                <!-- TIMELINE ROWS GRID -->
                <div class="timeline-rows-container">
                    
                    <!-- ROWS DONE -->
                    @foreach($subTasksDone as $sub)
                    <div class="timeline-row">
                        <div class="gantt-bar-pill bar-done" style="left: {{ $sub['left_pos'] }}; width: {{ $sub['width_pos'] }};">
                            {{ $sub['progress'] }}
                        </div>
                    </div>
                    @endforeach

                    <!-- ROWS ON GOING -->
                    @foreach($subTasksOngoing as $sub)
                    <div class="timeline-row">
                        <div class="gantt-bar-pill bar-ongoing" style="left: {{ $sub['left_pos'] }}; width: {{ $sub['width_pos'] }};">
                            {{ $sub['progress'] }}
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>

        </div>

        <!-- FOOTER URL BRAND -->
        <div class="text-center mt-4 pt-2 text-muted small font-monospace">
            www.company-development-roadmap.com
        </div>

    </div>

</div>

<!-- MODAL EDIT DATES & SCHEDULE -->
<div class="modal fade" id="editDatesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Custom Sub-Process Timeline Dates</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.timelines.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Information Received</label>
                            <input type="date" name="information_received" class="form-control" value="{{ $task->information_received }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">PLM Released</label>
                            <input type="date" name="plm_released" class="form-control" value="{{ $task->plm_released }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Layout Status</label>
                            <select name="layout_status" class="form-select">
                                <option value="Pending" {{ ($task->layout_status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ ($task->layout_status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ ($task->layout_status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">BaaN Status</label>
                            <select name="baan_status" class="form-select">
                                <option value="Pending" {{ ($task->baan_status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ ($task->baan_status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ ($task->baan_status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary fw-bold">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection