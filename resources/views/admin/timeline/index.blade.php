@extends('layouts.admin')

@section('title', 'Project Timeline Gantt Roadmap')

@push('styles')
    <!-- Frappe Gantt CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .dev-analytics, .dev-analytics * {
            font-family: 'Nunito', sans-serif !important;
        }

        /* 1. METRIC CARDS (KOTAK MELENGKUNG TIPIS + COLOR SCHEME GRADIENT) */
        .metric-card-box {
            border-radius: 6px !important;
            background: #ffffff;
            padding: 1.1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            height: 100%;
        }

        .metric-card-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        .card-box-gold { 
            background: linear-gradient(180deg, #ffffff 0%, #fffbeb 60%, #fef3c7 100%); 
            border-bottom: 3px solid #f59e0b;
        }
        .card-box-gray { 
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 60%, #e2e8f0 100%); 
            border-bottom: 3px solid #94a3b8;
        }
        .card-box-orange { 
            background: linear-gradient(180deg, #ffffff 0%, #fff7ed 60%, #ffedd5 100%); 
            border-bottom: 3px solid #f97316;
        }
        .card-box-green { 
            background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 60%, #dcfce7 100%); 
            border-bottom: 3px solid #10b981;
        }

        .metric-icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }

        .icon-bg-gold   { background-color: #fef3c7; color: #b45309; }
        .icon-bg-gray   { background-color: #e2e8f0; color: #475569; }
        .icon-bg-orange { background-color: #ffedd5; color: #c2410c; }
        .icon-bg-green  { background-color: #dcfce7; color: #15803d; }

        .metric-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 2px;
        }

        .metric-number {
            font-size: 1.5rem;
            font-weight: 600 !important; 
            color: #1e293b;
            line-height: 1.1;
        }

        .metric-footer {
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 3px;
        }

        /* 2. CHART CONTAINER CARD BOARD */
        .chart-card {
            border-radius: 6px !important;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .filter-panel {
            background-color: #f8fafc;
            border-bottom: 1.5px solid #e2e8f0;
            padding: 0.85rem 1.25rem;
        }

        .btn-filter-group {
            border: 1.5px solid #059669;
            border-radius: 6px;
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
            font-size: 12px !important;
            padding: 4px 16px !important;
            border-radius: 4px !important;
            transition: all 0.15s ease-in-out;
        }

        .btn-filter-custom:hover {
            background-color: rgba(16, 185, 129, 0.1) !important;
        }

        .btn-filter-custom.active {
            background-color: #059669 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.25) !important;
        }

        /* 3. STYLING GANTT CHART & HEADER HIJAU DENGAN FONT PUTIH TERANG */
        .gantt-target-wrapper {
            background: #ffffff;
            min-height: 480px;
            overflow-x: auto !important;
            overflow-y: auto !important;
            width: 100%;
        }

        #gantt-container {
            display: block;
            min-width: 1400px !important;
        }

        /* Header Background Hijau Gradient */
        .gantt .grid-header { 
            fill: url(#green-header-gradient) #059669 !important; 
            stroke: #047857 !important;
            stroke-width: 1.5px !important;
        }

        /* FONT TEKS HEADER (BULAN & TANGGAL) PUTIH TERANG */
        .gantt text,
        .gantt text.upper-header,
        .gantt text.lower-header,
        .gantt .grid-header text,
        svg#gantt-container text {
            fill: #ffffff !important;
            color: #ffffff !important;
        }

        /* Upper Header (Bulan) */
        .gantt .upper-header { 
            font-size: 12px !important; 
            fill: #ffffff !important; 
            font-weight: 800 !important; 
            letter-spacing: 0.6px;
        }

        /* Lower Header (Angka Tanggal) */
        .gantt .lower-header { 
            font-size: 11px !important; 
            fill: #ffffff !important; 
            font-weight: 700 !important;
            opacity: 1 !important;
        }

        /* Garis Pemisah Horizontal Bulan & Tanggal */
        .gantt .header-line {
            stroke: #ffffff !important;
            stroke-width: 2px !important;
        }

        /* Garis Horizontal Row Area Chart */
        .gantt .grid-row {
            fill: #ffffff !important;
            stroke: #e2e8f0 !important;
            stroke-width: 1px !important;
        }

        .gantt .grid-row:nth-child(even) {
            fill: #f8fafc !important;
        }

        /* Garis Vertikal Pemisah Tanggal */
        .gantt .tick { 
            stroke: #cbd5e1 !important;
            stroke-width: 1px !important;
            stroke-dasharray: none !important;
        }

        /* BAR TIMELINE CLICKABLE STYLE */
        .gantt .bar-wrapper {
            cursor: pointer !important;
        }

        .gantt .bar-wrapper:hover .bar {
            filter: brightness(0.9);
        }

        .gantt .bar-label { 
            fill: #ffffff !important; 
            font-size: 11px !important; 
            font-weight: 700 !important; 
            cursor: pointer !important;
        }

        /* Warna Bar Project */
        .gantt-container .gantt-to-do .bar, .gantt .gantt-to-do .bar { fill: #64748b !important; }
        .gantt-container .gantt-in-progress .bar, .gantt .gantt-in-progress .bar { fill: #f97316 !important; }
        .gantt-container .gantt-completed .bar, .gantt .gantt-completed .bar { fill: #10b981 !important; }
    </style>
@endpush

@section('content')
<div class="dev-analytics container-fluid py-4 px-4">

    <!-- PAGE HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1 fs-4">Project Development Roadmap Timeline</h3>
            <p class="text-muted small mb-0">Visualisasi Gantt Chart timeline project. Klik pada garis baris timeline untuk membuka detail <code>detailTimeLine.blade.php</code>.</p>
        </div>
        <div>
            <span class="badge bg-white text-dark border px-3 py-2 fw-semibold rounded-2 shadow-sm" style="font-size: 12px;">
                <i class="bi bi-layers-half me-1 text-success"></i> Total: {{ $tasks->count() }} Projects
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm" role="alert" style="background-color: #dcfce7; color: #15803d; font-size: 13px;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 1. METRIC CARDS GRID 4 -->
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

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card-box card-box-gold">
                <div class="metric-icon-circle icon-bg-gold">
                    <i class="bi bi-boxes"></i>
                </div>
                <div>
                    <div class="metric-title">Total Development</div>
                    <div class="metric-number">{{ $tasks->count() }}</div>
                    <div class="metric-footer text-warning">
                        <i class="bi bi-graph-up-arrow"></i> Active Master Registry
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card-box card-box-gray">
                <div class="metric-icon-circle icon-bg-gray">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="metric-title">Pending Tasks (To Do)</div>
                    <div class="metric-number">{{ $countToDo }}</div>
                    <div class="metric-footer text-secondary">
                        <i class="bi bi-clock-history"></i> Awaiting Review
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card-box card-box-orange">
                <div class="metric-icon-circle icon-bg-orange">
                    <i class="bi bi-diagram-2"></i>
                </div>
                <div>
                    <div class="metric-title">Active (In Progress)</div>
                    <div class="metric-number">{{ $countInProgress }}</div>
                    <div class="metric-footer" style="color: #c2410c;">
                        <i class="bi bi-gear-wide-connected"></i> Under Development
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card-box card-box-green">
                <div class="metric-icon-circle icon-bg-green">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <div class="metric-title">Completed Projects</div>
                    <div class="metric-number">{{ $countCompleted }}</div>
                    <div class="metric-footer text-success">
                        <i class="bi bi-check2-all"></i> 100% Deployed
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. GANTT BOARD CARD -->
    <div class="card chart-card">
        
        <!-- FILTER TOOLBAR -->
        <div class="filter-panel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                
                <!-- Search Box -->
                <div style="max-width: 380px; width: 100%;">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" id="ganttSearchInput" class="form-control border-start-0 shadow-none" placeholder="Search item code / project name / customer...">
                    </div>
                </div>

                <!-- View Mode Filter Buttons -->
                <div>
                    <div class="btn-filter-group shadow-sm" role="group">
                        <button type="button" class="btn btn-filter-custom active" onclick="changeGanttView('Day', this)">Day</button>
                        <button type="button" class="btn btn-filter-custom" onclick="changeGanttView('Week', this)">Week</button>
                        <button type="button" class="btn btn-filter-custom" onclick="changeGanttView('Month', this)">Month</button>
                        <button type="button" class="btn btn-filter-custom" onclick="changeGanttView('Year', this)">Year</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- GANTT CONTAINER BOARD -->
        <div class="card-body p-0">
            <div class="gantt-target-wrapper p-3">
                <div id="ganttEmptyState" class="text-center py-5 d-none">
                    <i class="bi bi-calendar-x text-muted opacity-50" style="font-size: 2.5rem;"></i>
                    <p class="text-muted fw-semibold mt-2 mb-0" style="font-size: 13px;">No project timelines match your search criteria.</p>
                </div>
                <svg id="gantt-container"></svg>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<!-- Frappe Gantt JS -->
<script src="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js"></script>

<script>
    // SESUAI DENGAN web.php: Route::get('/timeline/{id}', ...)->name('task.timeline.detail')
    // Hasil URL akan berupa: http://127.0.0.1:8000/admin/timeline/1
    const baseUrl = "{{ route('admin.task.timeline.detail', ':id') }}";

    // MASTER DATA RAW
    const rawGanttTasks = [
        @foreach($tasks as $index => $task)
            @php
                // MENGGUNAKAN $task->id AGAR URL MASUK PAS KE ROUTE CONTROLLER
                $targetId = $task->id; 
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
                $endDate = !empty($task->plm_released) ? date('Y-m-d', strtotime($task->plm_released)) : date('Y-m-d', strtotime($startDate . ' + 20 days'));
                
                $barLabel = ($index + 1) . '. ' . $task->item_code . ' - ' . addslashes($task->project_name ?? "Project Task");
                $customerName = addslashes($task->customer ?? $task->customer_name ?? $task->client_name ?? '-');
            @endphp
            {
                number: {{ $index + 1 }},
                id: '{{ $targetId }}',
                item_code: '{{ $task->item_code }}',
                project_name: '{{ addslashes($task->project_name ?? "Project Task") }}',
                customer: '{{ $customerName }}',
                name: '{{ $barLabel }}',
                start: '{{ $startDate }}',
                end: '{{ $endDate }}',
                progress: {{ $progressVal }},
                status_text: '{{ $statusText }}',
                custom_class: '{{ $ganttClass }}'
            },
        @endforeach
    ];

    let currentViewMode = 'Day';

    document.addEventListener('DOMContentLoaded', function () {
        injectSVGGradient();
        renderGanttChart(rawGanttTasks);

        // SEARCH EVENT
        document.getElementById('ganttSearchInput').addEventListener('input', filterGanttChart);
    });

    // INJECT SVG GRADIENT HIJAU UNTUK HEADER TABLE GANTT
    function injectSVGGradient() {
        const svg = document.getElementById('gantt-container');
        if (!svg) return;
        
        let defs = svg.querySelector('defs');
        if (!defs) {
            defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
            svg.appendChild(defs);
        }
        defs.innerHTML = `
            <linearGradient id="green-header-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#059669" />
                <stop offset="100%" stop-color="#10b981" />
            </linearGradient>
        `;
    }

    function renderGanttChart(tasks) {
        const svgContainer = document.getElementById('gantt-container');
        const emptyState = document.getElementById('ganttEmptyState');

        if (!tasks || tasks.length === 0) {
            svgContainer.innerHTML = '';
            emptyState.classList.remove('d-none');
            return;
        }

        emptyState.classList.add('d-none');

        window.gantt_chart = new Gantt("#gantt-container", tasks, {
            header_height: 52,
            column_width: 42,
            step: 24,
            view_modes: ['Day', 'Week', 'Month', 'Year'],
            view_mode: currentViewMode,
            bar_height: 24,
            bar_corner_radius: 4,
            arrow_curve: 5,
            padding: 18,
            date_format: 'YYYY-MM-DD',

            /* SAAT GARIS/BAR DIKLIK -> PINDAH KE DETAIL (detailTimeLine.blade.php) */
            on_click: function (task) {
                if (task && task.id) {
                    const redirectUrl = baseUrl.replace(':id', task.id);
                    window.location.href = redirectUrl;
                }
            },

            /* POPUP HOVER */
            custom_popup_html: function(task) {
                return `
                    <div class="p-2.5 text-white font-sans" style="background: #0f172a; border-radius: 6px; font-size: 11px; min-width: 220px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                        <div class="mb-1"><b>Item Code:</b> <span class="text-warning">${task.item_code}</span></div>
                        <div class="mb-1"><b>Project Name:</b> ${task.project_name}</div>
                        <div><b>Customer:</b> ${task.customer}</div>
                        <div class="mt-2 text-info text-end fw-bold" style="font-size: 10px;"><i>Klik baris untuk lihat detail &rarr;</i></div>
                    </div>
                `;
            }
        });

        injectSVGGradient();
    }

    function filterGanttChart() {
        const searchValue = document.getElementById('ganttSearchInput').value.toLowerCase().trim();

        const filtered = rawGanttTasks.filter(task => {
            return task.item_code.toLowerCase().includes(searchValue) || 
                   task.project_name.toLowerCase().includes(searchValue) ||
                   task.customer.toLowerCase().includes(searchValue);
        });

        renderGanttChart(filtered);
    }

    function changeGanttView(mode, btnElement) {
        currentViewMode = mode;
        if (window.gantt_chart) {
            window.gantt_chart.change_view_mode(mode);
        }
        
        const buttons = document.querySelectorAll('.btn-filter-custom');
        buttons.forEach(b => b.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');
    }
</script>
@endpush