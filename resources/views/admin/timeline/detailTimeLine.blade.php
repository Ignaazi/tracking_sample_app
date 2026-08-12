@extends('layouts.admin')

@section('title', 'Executive Project Roadmap & Gantt Chart - ' . ($task->item_code ?? $task->project_name))

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .roadmap-app, .roadmap-app * {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        /* CARD CONTAINER UTAMA */
        .exec-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            padding: 24px;
        }

        /* HEADER EFEK 3D WARNA HIJAU */
        .hero-3d-green {
            background: linear-gradient(145deg, #10b981 0%, #047857 100%);
            border-radius: 8px;
            padding: 20px 24px;
            color: #ffffff;
            box-shadow: 0 8px 16px -4px rgba(4, 120, 87, 0.3), 
                        inset 0 1px 1px rgba(255, 255, 255, 0.3);
            border: 1px solid #059669;
        }

        /* PROGRESS BOX GRID WARNA EMAS */
        .progress-gold-card {
            background: linear-gradient(145deg, #b45309 0%, #78350f 100%);
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 14px 18px;
            color: #ffffff;
            box-shadow: 0 4px 12px -2px rgba(180, 83, 9, 0.3);
        }

        .gold-progress-bar {
            background-color: rgba(255, 255, 255, 0.25);
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }

        .gold-progress-fill {
            background: linear-gradient(90deg, #fef08a 0%, #fde047 100%);
            height: 100%;
            border-radius: 4px;
        }

        /* TOMBOL KOTAK PRESISI */
        .btn-kotak {
            border-radius: 6px !important;
            padding: 8px 16px;
            font-weight: 700;
            font-size: 13px;
            transition: all 0.2s ease;
        }

        /* TAB SWITCHER */
        .nav-pills-exec {
            background-color: #f1f5f9;
            padding: 4px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        .nav-pills-exec .nav-link {
            color: #64748b;
            font-weight: 700;
            font-size: 13px;
            border-radius: 4px;
            padding: 8px 18px;
            transition: all 0.2s ease;
        }

        .nav-pills-exec .nav-link.active {
            background-color: #0284c7;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.3);
        }

        /* TABEL CONTAINER KOTAK SCROLLABLE */
        .grid-box-wrapper {
            border: 2px solid #0284c7;
            border-radius: 8px;
            overflow-x: auto;
            background: #ffffff;
        }

        /* TABEL GRID KOTAK */
        .table-sky-grid {
            width: 100%;
            border-collapse: collapse;
            min-width: 1250px;
        }

        .table-sky-grid th {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 12px 16px;
            border: 1px solid #0284c7;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .table-sky-grid td {
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
            font-size: 13px;
            white-space: nowrap;
        }

        .table-sky-grid tbody tr:hover {
            background-color: #f8fafc;
        }

        /* BAR GRAPH PROGRESS */
        .gantt-bar-container {
            height: 30px;
            background-color: #e2e8f0;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
            width: 100%;
            border: 1px solid #cbd5e1;
        }

        .gantt-bar-active {
            height: 100%;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10px;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
        }

        .bar-day { background: linear-gradient(90deg, #0284c7, #0369a1); }
        .bar-week { background: linear-gradient(90deg, #6366f1, #4f46e5); }
        .bar-month { background: linear-gradient(90deg, #f97316, #ea580c); }
        .bar-year { background: linear-gradient(90deg, #10b981, #047857); }

        /* INPUT CONTROLS */
        .form-control-exec, .form-select-exec {
            font-size: 12px !important;
            font-weight: 600;
            color: #1e293b;
            border: 1px solid #94a3b8;
            border-radius: 4px !important;
            padding: 7px 12px;
            transition: all 0.2s ease;
        }

        .form-control-exec:focus, .form-select-exec:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        .badge-unit {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        /* BADGE STATUS */
        .badge-status-complete {
            background-color: #10b981;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 4px;
            display: inline-block;
        }

        .badge-status-notyet {
            background-color: #64748b;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 4px;
            display: inline-block;
        }

        /* BASE STYLE BADGE PROCESS */
        .badge-process {
            font-size: 11px;
            font-weight: 800;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        /* 1. LAYOUT PROCESS (MERAH ROSE) */
        .proc-layout {
            background-color: #ffe4e6 !important;
            color: #be123c !important;
            border: 1px solid #fecdd3 !important;
        }

        /* 2. BAAN PROCESS (KUNING AMBER) */
        .proc-baan {
            background-color: #fef3c7 !important;
            color: #b45309 !important;
            border: 1px solid #fcd34d !important;
        }

        /* 3. PROMP PROCESS (HIJAU EMERALD) */
        .proc-promp {
            background-color: #d1fae5 !important;
            color: #047857 !important;
            border: 1px solid #a7f3d0 !important;
        }

        /* 4. JOB BAG PROCESS (UNGU PURPLE) */
        .proc-jobbag {
            background-color: #f3e8ff !important;
            color: #6b21a8 !important;
            border: 1px solid #e9d5ff !important;
        }

        /* DEFAULT JIKA ADA PROCESS LAIN (BIRU CYAN) */
        .proc-default {
            background-color: #e0f2fe !important;
            color: #0369a1 !important;
            border: 1px solid #bae6fd !important;
        }
    </style>
@endpush

@section('content')
<div class="roadmap-app container-fluid py-4 px-4">

    <!-- TOP NAVIGATION DI KANAN -->
    <div class="d-flex align-items-center justify-content-end gap-2 mb-3">
        <a href="{{ route('admin.task.subProcess', $task->item_code ?? $task->id) }}" class="btn btn-success btn-kotak shadow-sm" style="background-color: #047857; border-color: #047857;">
            <i class="bi bi-kanban me-1"></i> Review Kanban
        </a>
        <a href="{{ route('admin.timelines.index') }}" class="btn btn-outline-secondary btn-kotak bg-white shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- HEADER INFO PROJECT (3D GREEN CARD UTAMA) -->
    <div class="hero-3d-green mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-800 text-white mb-3">{{ $task->item_code }} &mdash; {{ $task->project_name ?? 'Untitled Project' }}</h3>
                
                <!-- ROW INFORMASI SEJAJAR -->
                <div class="d-flex flex-wrap gap-4 text-white-50 small fw-semibold">
                    <div>
                        <i class="bi bi-building me-1 text-warning fs-6"></i> Customer: 
                        <strong class="text-white">{{ $task->customer ?? '-' }}</strong>
                    </div>
                    <div>
                        <i class="bi bi-tag-fill me-1 text-info fs-6"></i> Brand: 
                        <strong class="text-white">{{ $task->brand_family ?? '-' }}</strong>
                    </div>
                    <div>
                        <i class="bi bi-globe2 me-1 text-light fs-6"></i> Market: 
                        <strong class="text-white">{{ $task->market ?? 'Domestic' }}</strong>
                    </div>
                    <div>
                        <i class="bi bi-calendar-check-fill me-1 text-warning fs-6"></i> Info Rec: 
                        <strong class="text-white">{{ $task->information_received ? date('d M Y', strtotime($task->information_received)) : '-' }}</strong>
                    </div>
                </div>
            </div>

            @php
                $allTimelines = $task->timelines ?? collect();
                $completedCount = $allTimelines->where('is_completed', 1)->count();
                $totalCount = $allTimelines->count();
                $overallPct = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
            @endphp

            <!-- GRID PROJECT PROGRESS KOTAK EMAS -->
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="progress-gold-card d-inline-block text-start w-100" style="max-width: 260px;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small fw-bold text-amber-100"><i class="bi bi-pie-chart-fill me-1"></i> PROJECT PROGRESS</span>
                        <span class="fs-4 fw-800 text-warning" id="overall-progress-text">{{ $overallPct }}%</span>
                    </div>
                    <div class="gold-progress-bar">
                        <div class="gold-progress-fill" id="overall-progress-bar" style="width: {{ $overallPct }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT CARD WITH FILTER TABS -->
    <div class="exec-card mb-4">
        
        <!-- HEADER & FILTER TABS SWITCHER -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 border-bottom gap-3">
            <div>
                <h5 class="fw-bold text-dark mb-0">Roadmap Execution & Schedule Settings</h5>
                <p class="text-muted small mb-0 mt-1">Gunakan filter tab di kanan untuk berganti antara Tampilan Grafik dan Form Pengisian Schedule.</p>
            </div>

            <!-- TABS SWITCHER -->
            <ul class="nav nav-pills nav-pills-exec" id="roadmapTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="gantt-tab" data-bs-toggle="pill" data-bs-target="#gantt-view" type="button" role="tab">
                        <i class="bi bi-bar-chart-steps me-1"></i> Slide 1: Gantt Visual
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="pill" data-bs-target="#settings-view" type="button" role="tab">
                        <i class="bi bi-sliders me-1"></i> Slide 2: Schedule & Remarks
                    </button>
                </li>
            </ul>
        </div>

        @if($allTimelines->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-diagram-3 fs-1 text-muted d-block mb-3 opacity-50"></i>
                <h6 class="fw-bold text-dark">Belum Ada Item Timeline</h6>
                <p class="text-muted small mb-3">Silakan kelola checklist sub-process untuk mengaktifkan grafik roadmap ini.</p>
                <a href="{{ route('admin.task.subProcess', $task->item_code ?? $task->id) }}" class="btn btn-sm btn-success btn-kotak">Buat Schedule Timeline</a>
            </div>
        @else
            <div class="tab-content pt-3" id="roadmapTabContent">

                <!-- SLIDE 1: GANTT CHART VISUAL GRAPH -->
                <div class="tab-pane fade show active" id="gantt-view" role="tabpanel">
                    <div class="grid-box-wrapper">
                        <table class="table-sky-grid align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th style="width: 240px;">Task</th>
                                    <th style="width: 170px;">Process</th>
                                    <th style="width: 150px;" class="text-center">Status</th>
                                    <th style="width: 100px;" class="text-center">Time Unit</th>
                                    <th style="width: 130px;" class="text-center">Start Date</th>
                                    <th style="width: 150px;" class="text-center">End Date</th>
                                    <th style="width: 260px;">Gantt Timeline Progress</th>
                                    <th>Catatan / Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allTimelines as $index => $item)
                                    @php
                                        $unit = strtolower($item->time_unit ?? 'days');
                                        $barClass = 'bar-day';
                                        if(str_contains($unit, 'week')) $barClass = 'bar-week';
                                        if(str_contains($unit, 'month')) $barClass = 'bar-month';
                                        if(str_contains($unit, 'year')) $barClass = 'bar-year';

                                        $pct = $item->is_completed ? 100 : ($item->progress_percent ?? 50);

                                        // LOGIKA WARNA PERSIS SESUAI TEKS DI GAMBAR
                                        $secKey = strtolower($item->section_key ?? '');
                                        $procClass = 'proc-default';

                                        if(str_contains($secKey, 'layout')) {
                                            $procClass = 'proc-layout';
                                        } elseif(str_contains($secKey, 'baan')) {
                                            $procClass = 'proc-baan';
                                        } elseif(str_contains($secKey, 'promp') || str_contains($secKey, 'prom')) {
                                            $procClass = 'proc-promp';
                                        } elseif(str_contains($secKey, 'job') || str_contains($secKey, 'bag')) {
                                            $procClass = 'proc-jobbag';
                                        }
                                    @endphp
                                    <tr id="gantt-row-{{ $item->id }}">
                                        <!-- NO -->
                                        <td class="text-center fw-bold text-secondary">{{ $index + 1 }}</td>

                                        <!-- TASK NAME -->
                                        <td>
                                            <strong class="d-block text-dark">
                                                {{ $item->task_title }}
                                            </strong>
                                        </td>

                                        <!-- PROCESS BADGE DENGAN WARNA SPESIFIK -->
                                        <td>
                                            <span class="badge-process {{ $procClass }}">
                                                <i class="bi bi-diagram-3 me-1"></i>{{ str_replace('_', ' ', strtoupper($item->section_key)) }}
                                            </span>
                                        </td>

                                        <!-- STATUS BADGE -->
                                        <td class="text-center" style="padding-left: 20px; padding-right: 20px;">
                                            @if($item->is_completed)
                                                <span class="badge-status-complete status-pill"><i class="bi bi-check-lg me-1"></i>COMPLETE</span>
                                            @else
                                                <span class="badge-status-notyet status-pill"><i class="bi bi-clock-history me-1"></i>NOT YET</span>
                                            @endif
                                        </td>

                                        <!-- TIME UNIT BADGE -->
                                        <td class="text-center">
                                            <span class="badge bg-dark text-white badge-unit unit-pill">{{ $item->time_unit ?? 'Days' }}</span>
                                        </td>

                                        <!-- DATES -->
                                        <td class="text-center text-muted small fw-bold start-date-text">
                                            {{ $item->start_date ? date('d M Y', strtotime($item->start_date)) : '-' }}
                                        </td>
                                        
                                        <!-- END DATE -->
                                        <td class="text-center text-muted small fw-bold end-date-text" style="padding-left: 20px; padding-right: 20px;">
                                            {{ $item->end_date ? date('d M Y', strtotime($item->end_date)) : '-' }}
                                        </td>

                                        <!-- GANTT BAR VISUAL -->
                                        <td>
                                            <div class="gantt-bar-container">
                                                <div class="gantt-bar-active {{ $barClass }} bar-fill" style="width: {{ $pct }}%;">
                                                    <span class="pct-text">{{ $pct }}%</span>
                                                    <span class="opacity-75 unit-subtext" style="font-size: 9px;">{{ $item->time_unit ?? 'Days' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- REMARKS DISPLAY -->
                                        <td>
                                            <span class="text-dark fw-medium small remarks-text">
                                                {{ $item->remarks ? $item->remarks : '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SLIDE 2: SCHEDULE & REMARKS EDITABLE TABLE -->
                <div class="tab-pane fade" id="settings-view" role="tabpanel">
                    <form id="schedule-remarks-form">
                        <div class="grid-box-wrapper mb-3">
                            <table class="table-sky-grid align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;" class="text-center">No</th>
                                        <th style="width: 60px;" class="text-center">Done</th>
                                        <th style="width: 240px;">Task</th>
                                        <th style="width: 170px;">Process</th>
                                        <th style="width: 130px;">Time Unit</th>
                                        <th style="width: 150px;">Start Date</th>
                                        <th style="width: 160px;">End Date</th>
                                        <th>Catatan / Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allTimelines as $index => $item)
                                    @php
                                        // LOGIKA WARNA PERSIS SESUAI TEKS FOR SLIDE 2
                                        $secKey = strtolower($item->section_key ?? '');
                                        $procClass = 'proc-default';

                                        if(str_contains($secKey, 'layout')) {
                                            $procClass = 'proc-layout';
                                        } elseif(str_contains($secKey, 'baan')) {
                                            $procClass = 'proc-baan';
                                        } elseif(str_contains($secKey, 'promp') || str_contains($secKey, 'prom')) {
                                            $procClass = 'proc-promp';
                                        } elseif(str_contains($secKey, 'job') || str_contains($secKey, 'bag')) {
                                            $procClass = 'proc-jobbag';
                                        }
                                    @endphp
                                    <tr class="setting-row" data-id="{{ $item->id }}">
                                        <!-- NO -->
                                        <td class="text-center fw-bold text-secondary">{{ $index + 1 }}</td>

                                        <!-- CHECKBOX DONE -->
                                        <td class="text-center">
                                            <input type="checkbox" 
                                                   class="form-check-input input-is-completed shadow-none" 
                                                   name="items[{{ $item->id }}][is_completed]"
                                                   value="1" 
                                                   {{ $item->is_completed ? 'checked' : '' }}
                                                   style="width: 18px; height: 18px; cursor: pointer; border-radius: 4px;">
                                        </td>

                                        <!-- TASK -->
                                        <td>
                                            <strong class="d-block text-dark">{{ $item->task_title }}</strong>
                                        </td>

                                        <!-- PROCESS BADGE -->
                                        <td>
                                            <span class="badge-process {{ $procClass }}">
                                                {{ str_replace('_', ' ', strtoupper($item->section_key)) }}
                                            </span>
                                        </td>

                                        <!-- SELECT TIME UNIT -->
                                        <td>
                                            <select class="form-select form-select-exec input-time-unit" 
                                                    name="items[{{ $item->id }}][time_unit]">
                                                <option value="Days" {{ ($item->time_unit ?? 'Days') == 'Days' ? 'selected' : '' }}>Day (Hari)</option>
                                                <option value="Weeks" {{ ($item->time_unit ?? '') == 'Weeks' ? 'selected' : '' }}>Week (Minggu)</option>
                                                <option value="Months" {{ ($item->time_unit ?? '') == 'Months' ? 'selected' : '' }}>Month (Bulan)</option>
                                                <option value="Years" {{ ($item->time_unit ?? '') == 'Years' ? 'selected' : '' }}>Year (Tahun)</option>
                                            </select>
                                        </td>

                                        <!-- START DATE -->
                                        <td>
                                            <input type="date" 
                                                   class="form-control form-control-exec input-start-date" 
                                                   name="items[{{ $item->id }}][start_date]"
                                                   value="{{ $item->start_date ? date('Y-m-d', strtotime($item->start_date)) : '' }}">
                                        </td>

                                        <!-- END DATE -->
                                        <td style="padding-left: 15px; padding-right: 15px;">
                                            <input type="date" 
                                                   class="form-control form-control-exec input-end-date" 
                                                   name="items[{{ $item->id }}][end_date]"
                                                   value="{{ $item->end_date ? date('Y-m-d', strtotime($item->end_date)) : '' }}">
                                        </td>

                                        <!-- REMARKS INPUT FIELD -->
                                        <td>
                                            <input type="text" 
                                                   class="form-control form-control-exec input-remarks w-100" 
                                                   name="items[{{ $item->id }}][remarks]"
                                                   value="{{ $item->remarks }}" 
                                                   placeholder="Tulis catatan/remarks khusus di sini...">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- FOOTER TOMBOL SAVE -->
                        <div class="d-flex align-items-center justify-content-between pt-2">
                            <span class="text-muted small">
                                <i class="bi bi-info-circle me-1 text-primary"></i> Klik simpan untuk memperbarui data dan visualisasi Gantt Chart pada Slide 1.
                            </span>
                            <button type="button" id="btn-save-schedule" class="btn btn-primary btn-kotak shadow-sm" style="background-color: #0284c7; border-color: #0284c7;">
                                <i class="bi bi-floppy-fill me-1"></i> Simpan Semua Perubahan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        @endif

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const saveBtn = document.getElementById('btn-save-schedule');

    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            const rows = document.querySelectorAll('.setting-row');
            let completedCount = 0;
            let totalCount = rows.length;
            
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...';

            const promises = [];

            rows.forEach(row => {
                const id = row.getAttribute('data-id');
                const isCompleted = row.querySelector('.input-is-completed').checked ? 1 : 0;
                const timeUnit = row.querySelector('.input-time-unit').value;
                const startDate = row.querySelector('.input-start-date').value;
                const endDate = row.querySelector('.input-end-date').value;
                const remarks = row.querySelector('.input-remarks').value;

                if (isCompleted) completedCount++;

                const payload = {
                    is_completed: isCompleted,
                    time_unit: timeUnit,
                    start_date: startDate,
                    end_date: endDate,
                    remarks: remarks
                };

                const request = fetch(`/admin/timeline/${id}/update`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const ganttRow = document.getElementById(`gantt-row-${id}`);
                        if (ganttRow) {
                            // Update Status Badge
                            const statusPill = ganttRow.querySelector('.status-pill');
                            if (isCompleted) {
                                statusPill.className = 'badge-status-complete status-pill';
                                statusPill.innerHTML = '<i class="bi bi-check-lg me-1"></i>COMPLETE';
                            } else {
                                statusPill.className = 'badge-status-notyet status-pill';
                                statusPill.innerHTML = '<i class="bi bi-clock-history me-1"></i>NOT YET';
                            }

                            // Update Time Unit
                            const unitPill = ganttRow.querySelector('.unit-pill');
                            if (unitPill) unitPill.innerText = timeUnit;

                            // Update Start & End Date
                            const startDateText = ganttRow.querySelector('.start-date-text');
                            const endDateText = ganttRow.querySelector('.end-date-text');
                            if (startDateText) startDateText.innerText = startDate ? formatDate(startDate) : '-';
                            if (endDateText) endDateText.innerText = endDate ? formatDate(endDate) : '-';

                            // Update Gantt Bar Progress
                            const pct = isCompleted ? 100 : 50;
                            const barFill = ganttRow.querySelector('.bar-fill');
                            const pctText = ganttRow.querySelector('.pct-text');
                            const unitSubtext = ganttRow.querySelector('.unit-subtext');

                            if (barFill) {
                                barFill.style.width = pct + '%';
                                barFill.className = 'gantt-bar-active bar-fill ' + getBarClass(timeUnit);
                            }
                            if (pctText) pctText.innerText = pct + '%';
                            if (unitSubtext) unitSubtext.innerText = timeUnit;

                            // Update Remarks Text
                            const remarksText = ganttRow.querySelector('.remarks-text');
                            if (remarksText) remarksText.innerText = remarks ? remarks : '-';
                        }
                    }
                });

                promises.push(request);
            });

            Promise.all(promises).then(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="bi bi-check2-circle me-1"></i> Tersimpan!';
                
                const overallPct = totalCount > 0 ? Math.round((completedCount / totalCount) * 100) : 0;
                const progressText = document.getElementById('overall-progress-text');
                const progressBar = document.getElementById('overall-progress-bar');
                if (progressText) progressText.innerText = overallPct + '%';
                if (progressBar) progressBar.style.width = overallPct + '%';

                setTimeout(() => {
                    saveBtn.innerHTML = '<i class="bi bi-floppy-fill me-1"></i> Simpan Semua Perubahan';
                }, 2000);
            }).catch(err => {
                console.error(err);
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i> Gagal Menyimpan';
            });
        });
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return `${String(d.getDate()).padStart(2, '0')} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }

    function getBarClass(unit) {
        const u = unit.toLowerCase();
        if (u.includes('week')) return 'bar-week';
        if (u.includes('month')) return 'bar-month';
        if (u.includes('year')) return 'bar-year';
        return 'bar-day';
    }
});
</script>
@endpush