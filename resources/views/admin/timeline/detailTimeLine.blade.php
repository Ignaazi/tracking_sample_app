@extends('layouts.admin')

@section('title', 'Detail Project Timeline - ' . ($task->item_code ?? $task->project_name))

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
            border-bottom: 1px solid #cbd5e1;
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
            background-color: #10b981;
        }

        .pill-ongoing-group {
            background-color: #f97316;
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
            font-size: 12.5px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-task-item:last-child {
            border-bottom: none;
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
            background-color: #0284c7;
            color: #ffffff;
            font-weight: 800;
        }

        /* TIMELINE ROWS & GRID LINES */
        .timeline-rows-container {
            display: flex;
            flex-direction: column;
            position: relative;
            background-size: calc(100% / 8) 100%;
            background-image: linear-gradient(to right, #cbd5e1 1px, transparent 1px);
        }

        .timeline-row {
            height: 55px;
            position: relative;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }

        /* BARIS WARNA PROGRESS GANTT */
        .gantt-bar-pill {
            position: absolute;
            height: 26px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            padding: 0 10px;
        }

        .bar-done {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .bar-ongoing {
            background: linear-gradient(135deg, #f97316, #ea580c);
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
        <a href="{{ route('admin.task.subProcess', $task->item_code ?? $task->id) }}" class="btn btn-sm btn-primary fw-bold">
            <i class="bi bi-pencil-square me-1"></i> Kelola Checklist Sub-Process
        </a>
    </div>

    <!-- PROJECT INFO HEADER CARD -->
    <div class="project-spec-card mb-4">
        <div class="row align-items-center">
            <div class="col-md-2 text-center border-end">
                @if(!empty($task->main_design_attachment))
                    <img src="{{ asset('storage/' . $task->main_design_attachment) }}" alt="Spec Image" class="img-fluid rounded shadow-sm" style="max-height: 80px; object-fit: cover;">
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
                    <div class="col-md-3"><i class="bi bi-calendar-check me-1"></i> Info Rec: <span class="text-dark">{{ $task->information_received ? date('Y-m-d', strtotime($task->information_received)) : '-' }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- DB TIMELINE PROCESSING & FILTERING -->
    @php
        // Ambil data timeline dari relasi database
        $allTimelines = $task->timelines ?? collect();

        // Pisahkan menjadi Done (is_completed = 1) dan On Going (is_completed = 0)
        $subTasksDone = $allTimelines->where('is_completed', 1);
        $subTasksOngoing = $allTimelines->where('is_completed', 0);

        // Cari tanggal paling awal dan paling akhir untuk skala waktu Gantt
        $minDate = $allTimelines->pluck('start_date')->filter()->min() ?? ($task->information_received ?? date('Y-m-d'));
        $maxDate = $allTimelines->pluck('end_date')->filter()->max() ?? ($task->plm_released ?? date('Y-m-d', strtotime($minDate . ' + 30 days')));

        $startTimestamp = strtotime($minDate);
        $endTimestamp = strtotime($maxDate);
        $totalDays = max(1, ($endTimestamp - $startTimestamp) / 86400);

        // Helper Function menghitung posisi persentase baris Gantt Chart
        $getBarPosition = function($start, $end) use ($startTimestamp, $totalDays) {
            if (!$start || !$end) {
                return ['left' => '10%', 'width' => '30%'];
            }
            $s = strtotime($start);
            $e = strtotime($end);
            
            $leftPercent = max(0, (($s - $startTimestamp) / 86400) / $totalDays) * 100;
            $widthPercent = max(5, (($e - $s) / 86400) / $totalDays) * 100;

            if (($leftPercent + $widthPercent) > 100) {
                $widthPercent = 100 - $leftPercent;
            }

            return [
                'left' => round($leftPercent, 1) . '%',
                'width' => round($widthPercent, 1) . '%'
            ];
        };
    @endphp

    <!-- MAIN GANTT GRAPH CARD -->
    <div class="gantt-card">
        
        <!-- HEADER GRAPH -->
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-2">
            <div>
                <div class="gantt-header-title">
                    Gantt Chart <span style="color: #f97316;">Graph</span>
                </div>
                <div class="text-muted small fw-bold mt-1">
                    <i class="bi bi-clock me-1"></i> Rentang Waktu: {{ date('d M Y', strtotime($minDate)) }} s/d {{ date('d M Y', strtotime($maxDate)) }}
                </div>
            </div>
            <div class="company-badge">
                {{ $task->customer ?? 'Enterprise Roadmap' }}
            </div>
        </div>

        @if($allTimelines->isEmpty())
            <!-- WARNING JIKA BELUM ADA DATA CHECKLIST -->
            <div class="alert alert-warning text-center my-4 py-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-2 d-block mb-2 text-warning"></i>
                <h6 class="fw-bold">Belum Ada Ketentuan Timeline yang Diisi!</h6>
                <p class="small mb-3">Silakan klik tombol di bawah untuk menambah poin sub-process & tanggal timeline project ini.</p>
                <a href="{{ route('admin.task.subProcess', $task->item_code ?? $task->id) }}" class="btn btn-sm btn-warning fw-bold text-dark">
                    <i class="bi bi-plus-circle me-1"></i> Isi Checklist Sub-Process
                </a>
            </div>
        @else
            <!-- GANTT MAIN CONTAINER -->
            <div class="gantt-main-container">

                <!-- SIDEBAR KIRI (TASK LIST + VERTICAL BADGES) -->
                <div class="gantt-sidebar">
                    <div class="gantt-sidebar-header">
                        Sub-Process Task Title
                    </div>

                    <!-- GROUP DONE -->
                    @if($subTasksDone->count() > 0)
                    <div class="sidebar-group-wrapper">
                        <div class="vertical-group-pill pill-done-group">
                            Done ({{ $subTasksDone->count() }})
                        </div>
                        <div class="sidebar-tasks-list">
                            @foreach($subTasksDone as $item)
                                <div class="sidebar-task-item" title="{{ $item->task_title }}">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> {{ $item->task_title }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- GROUP ON GOING -->
                    @if($subTasksOngoing->count() > 0)
                    <div class="sidebar-group-wrapper" style="border-bottom: none;">
                        <div class="vertical-group-pill pill-ongoing-group">
                            On Going ({{ $subTasksOngoing->count() }})
                        </div>
                        <div class="sidebar-tasks-list">
                            @foreach($subTasksOngoing as $item)
                                <div class="sidebar-task-item" title="{{ $item->task_title }}">
                                    <i class="bi bi-hourglass-split text-warning me-2"></i> {{ $item->task_title }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- TIMELINE AREA KANAN (SKALA WEEK 1 - WEEK 8 GRID) -->
                <div class="gantt-timeline-area">
                    
                    <!-- HEADER WEEKS -->
                    <div class="timeline-header-weeks">
                        <div class="week-col-header">Week 1</div>
                        <div class="week-col-header">Week 2</div>
                        <div class="week-col-header">Week 3</div>
                        <div class="week-col-header active-week">Week 4</div>
                        <div class="week-col-header">Week 5</div>
                        <div class="week-col-header">Week 6</div>
                        <div class="week-col-header">Week 7</div>
                        <div class="week-col-header" style="border-right: none;">Week 8</div>
                    </div>

                    <!-- TIMELINE ROWS GRID -->
                    <div class="timeline-rows-container">
                        
                        <!-- ROWS DONE -->
                        @foreach($subTasksDone as $item)
                        @php $pos = $getBarPosition($item->start_date, $item->end_date); @endphp
                        <div class="timeline-row">
                            <div class="gantt-bar-pill bar-done" style="left: {{ $pos['left'] }}; width: {{ $pos['width'] }};">
                                100% Complete
                            </div>
                        </div>
                        @endforeach

                        <!-- ROWS ON GOING -->
                        @foreach($subTasksOngoing as $item)
                        @php $pos = $getBarPosition($item->start_date, $item->end_date); @endphp
                        <div class="timeline-row">
                            <div class="gantt-bar-pill bar-ongoing" style="left: {{ $pos['left'] }}; width: {{ $pos['width'] }};">
                                {{ $item->progress_percent ?? 50 }}% Progress
                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>

            </div>
        @endif

        <!-- FOOTER URL BRAND -->
        <div class="text-center mt-4 pt-2 text-muted small font-monospace">
            Enterprise Interactive Project Roadmap System
        </div>

    </div>

</div>
@endsection