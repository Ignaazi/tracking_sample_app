@extends('layouts.admin')

@section('title', 'Multi-series Timeline Gantt Roadmap')

@push('styles')
    <!-- Frappe Gantt CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        .dev-analytics * {
            font-family: 'Nunito', sans-serif !important;
        }

        .chart-card {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .chart-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
        }

        /* STYLING BADGE STATUS LEGEND */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 14px;
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        .status-pill .count-circle {
            width: 15px;
            height: 15px;
            background-color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 800;
        }

        /* COLOR PALETTE ORIGINAL */
        .pill-todo { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .pill-todo .count-circle { color: #1d4ed8; }

        .pill-progress { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .pill-progress .count-circle { color: #b45309; }

        .pill-completed { background: linear-gradient(135deg, #10b981, #059669); }
        .pill-completed .count-circle { color: #047857; }

        /* STYLING BUTTON FILTER SKALA WAKTU BERGARIS */
        .btn-filter-group {
            border: 1.5px solid #10b981;
            border-radius: 8px;
            padding: 2px;
            background-color: #ffffff;
            display: inline-flex;
            gap: 2px;
        }

        .btn-filter-custom {
            background-color: transparent !important;
            color: #059669 !important;
            border: none !important;
            font-weight: 700 !important;
            font-size: 11.5px !important;
            padding: 5px 14px !important;
            border-radius: 6px !important;
            transition: all 0.2s ease-in-out;
        }

        .btn-filter-custom:hover {
            background-color: rgba(16, 185, 129, 0.12) !important;
            color: #047857 !important;
        }

        .btn-filter-custom.active {
            background: linear-gradient(135deg, #22c55e, #10b981) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.35) !important;
        }

        /* SCROLL HORIZONTAL PADA GANTT CHART */
        .gantt-target-wrapper {
            background: #ffffff;
            max-height: 420px;
            border-radius: 0 0 12px 12px;
            overflow-x: auto !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        #gantt-container {
            display: block;
            min-width: 1400px !important;
            height: auto;
        }

        /* POINTER / HAND-CURSOR PADA BARIS GANTT */
        .gantt .bar-wrapper {
            cursor: pointer !important;
        }

        .gantt .grid-row {
            fill: #ffffff !important;
            stroke: #f1f5f9 !important;
            stroke-width: 1px !important;
        }
        
        .gantt .grid-header { 
            fill: #f8fafc !important; 
            stroke: #e2e8f0 !important; 
        }

        .gantt .tick { 
            display: none !important; 
        }

        .gantt .upper-header { font-size: 11px; fill: #334155 !important; font-weight: 700; }
        .gantt .lower-header { font-size: 10px; fill: #64748b !important; }
        .gantt .bar-label { fill: #ffffff !important; font-size: 11px; font-weight: 700; }

        .gantt-container .gantt-to-do .bar, .gantt .gantt-to-do .bar, .gantt .gantt-todo .bar { fill: #3b82f6 !important; }
        .gantt-container .gantt-to-do .bar-progress, .gantt .gantt-to-do .bar-progress, .gantt .gantt-todo .bar-progress { fill: #1d4ed8 !important; }

        .gantt-container .gantt-in-progress .bar, .gantt .gantt-in-progress .bar, .gantt .gantt-progress .bar { fill: #f59e0b !important; }
        .gantt-container .gantt-in-progress .bar-progress, .gantt .gantt-in-progress .bar-progress, .gantt .gantt-progress .bar-progress { fill: #b45309 !important; }

        .gantt-container .gantt-completed .bar, .gantt .gantt-completed .bar, .gantt .gantt-done .bar { fill: #10b981 !important; }
        .gantt-container .gantt-completed .bar-progress, .gantt .gantt-completed .bar-progress, .gantt .gantt-done .bar-progress { fill: #047857 !important; }

        /* STYLING TABEL */
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        .table-custom {
            white-space: nowrap !important;
            min-width: 1350px !important;
            border-collapse: collapse !important;
        }

        .table-custom th {
            background: linear-gradient(135deg, #005596 0%, #0099c8 50%, #15e638 100%) !important;
            color: #ffffff !important;
            font-weight: 800;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #005596 !important;
            padding: 12px 14px;
            text-align: center !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.25);
        }

        .table-custom td {
            font-size: 12px;
            font-weight: 600;
            color: #000000 !important;
            padding: 11px 14px;
            vertical-align: middle;
            text-align: center !important;
            border: 1px solid #cbd5e1 !important;
        }

        .table-custom tbody tr:nth-child(odd) { background-color: #EBF5FF !important; }
        .table-custom tbody tr:nth-child(even) { background-color: #F0FDF4 !important; }

        .table-custom tbody tr:hover {
            background-color: #D1E9FF !important;
            cursor: pointer;
        }

        .badge-gradient-record {
            background: linear-gradient(135deg, #005596 0%, #0099c8 50%, #15e638 100%) !important;
            color: #ffffff !important;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.12);
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .badge-status-completed { background-color: #10B981; color: #ffffff !important; font-weight: 800; padding: 4px 10px; border-radius: 12px; font-size: 10px; }
        .badge-status-progress { background-color: #F59E0B; color: #ffffff !important; font-weight: 800; padding: 4px 10px; border-radius: 12px; font-size: 10px; }
        .badge-status-todo { background-color: #3B82F6; color: #ffffff !important; font-weight: 800; padding: 4px 10px; border-radius: 12px; font-size: 10px; }
        .badge-status-inactive { background-color: #64748B; color: #ffffff !important; font-weight: 800; padding: 4px 10px; border-radius: 12px; font-size: 10px; }
    </style>
@endpush

@section('content')
<div class="dev-analytics container-fluid py-4 px-4">

    <!-- HEADER TITLE PAGE -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1 fs-4">Project Development Roadmap</h3>
            <p class="text-muted small mb-0">Klik pada <b>garis baris Gantt Chart</b> atau <b>baris tabel</b> untuk mengelola detail timeline per project.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm" role="alert" style="background-color: #dcfce7; color: #15803d; font-size: 13px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 1. FRAPPE GANTT ROADMAP CHART -->
    <div class="card chart-card mb-4">
        <div class="chart-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h6 class="fw-bold text-dark mb-2.5" style="font-size: 16px;">
                    Enterprise Interactive Gantt
                </h6>

                <!-- PENYESUAIAN JUMLAH HITUNGAN STATUS DI SINI -->
                @php
                    $countToDo = $tasks->filter(function($t) {
                        return in_array(strtolower(trim($t->status ?? '')), ['todo', 'to do', '']);
                    })->count();

                    $countInProgress = $tasks->filter(function($t) {
                        return in_array(strtolower(trim($t->status ?? '')), ['in-progress', 'in progress', 'progress']);
                    })->count();

                    $countCompleted = $tasks->filter(function($t) {
                        return in_array(strtolower(trim($t->status ?? '')), ['completed', 'done']);
                    })->count();
                @endphp

                <div class="d-flex align-items-center gap-2">
                    <div class="status-pill pill-todo">
                        <span>To Do</span>
                        <div class="count-circle">{{ $countToDo }}</div>
                    </div>

                    <div class="status-pill pill-progress">
                        <span>In Progress</span>
                        <div class="count-circle">{{ $countInProgress }}</div>
                    </div>

                    <div class="status-pill pill-completed">
                        <span>Completed</span>
                        <div class="count-circle">{{ $countCompleted }}</div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL FILTER SKALA WAKTU BERGARIS -->
            <div class="btn-filter-group shadow-sm" role="group">
                <button type="button" class="btn btn-filter-custom active" onclick="changeGanttView('Day', this)">Day</button>
                <button type="button" class="btn btn-filter-custom" onclick="changeGanttView('Week', this)">Week</button>
                <button type="button" class="btn btn-filter-custom" onclick="changeGanttView('Month', this)">Month</button>
                <button type="button" class="btn btn-filter-custom" onclick="changeGanttView('Year', this)">Year</button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="gantt-target-wrapper p-3">
                <svg id="gantt-container"></svg>
            </div>
        </div>
    </div>

    <!-- 2. DATA TABLE RECORD -->
    <div class="card chart-card">
        <div class="chart-header d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color: #005596;">Task Master Registry</h6>
            <span class="badge badge-gradient-record font-monospace">{{ $tasks->count() }} Record(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Item Code</th>
                            <th>Project Name</th>
                            <th>Customer</th>
                            <th>Brand Family</th>
                            <th>Market</th>
                            <th>Info Received</th>
                            <th>PLM Released</th>
                            <th>SAP Number</th>
                            <th>Development</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $key => $task)
                        @php
                            $targetKey = $task->item_code ?? $task->id;
                            $normStatus = strtolower(trim($task->status ?? ''));
                        @endphp
                        <tr onclick="window.location='{{ route('admin.task.timeline.detail', $targetKey) }}'">
                            <td class="fw-bold">{{ sprintf('%02d', $key + 1) }}</td>
                            <td class="font-monospace fw-bold text-primary">{{ $task->item_code }}</td>
                            <td class="fw-bold">{{ $task->project_name ?? '-' }}</td>
                            <td>{{ $task->customer ?? '-' }}</td>
                            <td>{{ $task->brand_family ?? '-' }}</td>
                            <td>{{ $task->market ?? '-' }}</td>
                            <td>
                                @if($task->information_received)
                                    <span class="font-monospace fw-bold">{{ date('Y-m-d', strtotime($task->information_received)) }}</span>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>
                                @if($task->plm_released)
                                    <span class="font-monospace fw-bold">{{ date('Y-m-d', strtotime($task->plm_released)) }}</span>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td><code class="fw-bold" style="color: #000000;">{{ $task->sap_number ?? '-' }}</code></td>
                            
                            <!-- DEVELOPMENT STATUS BADGE -->
                            <td>
                                @php
                                    $devBadgeClass = match($task->development_status) {
                                        'Active' => 'badge-status-completed',
                                        'Pending' => 'badge-status-progress',
                                        default => 'badge-status-inactive'
                                    };
                                @endphp
                                <span class="badge {{ $devBadgeClass }}">
                                    {{ $task->development_status ?? 'Active' }}
                                </span>
                            </td>

                            <!-- TASK STATUS BADGE FLEXIBLE -->
                            <td>
                                @php
                                    if (in_array($normStatus, ['completed', 'done'])) {
                                        $badgeClass = 'badge-status-completed';
                                        $displayStatus = 'Completed';
                                    } elseif (in_array($normStatus, ['in-progress', 'in progress', 'progress'])) {
                                        $badgeClass = 'badge-status-progress';
                                        $displayStatus = 'In Progress';
                                    } else {
                                        $badgeClass = 'badge-status-todo';
                                        $displayStatus = 'To Do';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $displayStatus }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 fw-bold" style="color: #000000;">
                                Belum ada data project task yang tersimpan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Frappe Gantt JS -->
<script src="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const baseUrl = "{{ route('admin.task.timeline.detail', ':id') }}";

        const ganttTasks = [
            @foreach($tasks as $task)
                @php
                    $targetKey = $task->item_code ?? $task->id;
                    $normStatus = strtolower(trim($task->status ?? ''));
                    
                    if (in_array($normStatus, ['completed', 'done'])) {
                        $statusText = 'Completed';
                        $progressVal = 100;
                        $ganttClass = 'gantt-completed';
                    } elseif (in_array($normStatus, ['in-progress', 'in progress', 'progress'])) {
                        $statusText = 'In Progress';
                        $progressVal = 50;
                        $ganttClass = 'gantt-in-progress';
                    } else {
                        $statusText = 'To Do';
                        $progressVal = 0;
                        $ganttClass = 'gantt-to-do';
                    }

                    $startDate = !empty($task->information_received) ? date('Y-m-d', strtotime($task->information_received)) : date('Y-m-d', strtotime($task->created_at ?? now()));
                    $endDate = !empty($task->plm_released) ? date('Y-m-d', strtotime($task->plm_released)) : date('Y-m-d', strtotime($startDate . ' + 14 days'));
                @endphp
                {
                    id: '{{ $targetKey }}',
                    name: '[{{ $statusText }}] {{ $task->item_code }} - {{ addslashes($task->project_name ?? "Project") }}',
                    start: '{{ $startDate }}',
                    end: '{{ $endDate }}',
                    progress: {{ $progressVal }},
                    custom_class: '{{ $ganttClass }}'
                },
            @endforeach
        ];

        if (ganttTasks.length > 0) {
            window.gantt_chart = new Gantt("#gantt-container", ganttTasks, {
                header_height: 50,
                column_width: 38,
                step: 24,
                view_modes: ['Day', 'Week', 'Month', 'Year'],
                view_mode: 'Day',
                bar_height: 22,
                bar_corner_radius: 4,
                arrow_curve: 5,
                padding: 18,
                date_format: 'YYYY-MM-DD',

                on_click: function (task) {
                    const detailUrl = baseUrl.replace(':id', task.id);
                    window.location.href = detailUrl;
                },

                custom_popup_html: function(task) {
                    return `
                        <div class="p-2.5 text-white font-sans" style="background: #0f172a; border-radius: 6px; font-size: 11px; min-width: 190px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            <div class="fw-bold mb-1 border-bottom border-secondary pb-1 text-warning">${task.name}</div>
                            <div class="mt-1"><b>Start:</b> ${task.start}</div>
                            <div><b>End:</b> ${task.end}</div>
                            <div><b>Progress:</b> ${task.progress}% Complete</div>
                            <div class="mt-2 text-info fw-bold text-end"><i>Klik baris untuk detail &rarr;</i></div>
                        </div>
                    `;
                }
            });
        }
    });

    function changeGanttView(mode, btnElement) {
        if (window.gantt_chart) {
            window.gantt_chart.change_view_mode(mode);
            
            const buttons = document.querySelectorAll('.btn-filter-custom');
            buttons.forEach(b => b.classList.remove('active'));
            if (btnElement) btnElement.classList.add('active');
        }
    }
</script>
@endpush