@extends('layouts.admin')

@section('title', 'Sub-Process Dynamic Checklist')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        .subpanel-container, .subpanel-container * {
            font-family: 'Nunito', sans-serif !important;
        }

        .badge-itemcode-gold {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #b45309 !important;
            border: 1px solid #fcd34d !important;
            font-size: 13px !important;
            font-weight: 800 !important;
            padding: 5px 12px !important;
            border-radius: 6px !important;
        }

        .batik-header-card {
            background-color: #f1f5f9;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 0 C15 15, 15 45, 30 60 C45 45, 45 15, 30 0 Z M0 30 C15 15, 45 15, 60 30 C45 45, 15 45, 0 30 Z' fill='none' stroke='%23475569' stroke-width='1.2' stroke-opacity='0.12'/%3E%3Ccircle cx='30' cy='30' r='3' fill='%23475569' fill-opacity='0.18'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 36px 36px;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .text-customer-stabilo {
            color: #0284c7 !important;
            font-weight: 800 !important;
            letter-spacing: 0.2px;
            text-shadow: 0 0 1px rgba(2, 132, 199, 0.2);
        }

        .status-badge-active {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border: 1px solid #86efac !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            padding: 3px 10px !important;
            border-radius: 20px !important;
        }

        .status-badge-notyet {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            padding: 3px 10px !important;
            border-radius: 20px !important;
        }

        .btn-green-gradient {
            background: linear-gradient(135deg, #15803d 0%, #22c55e 100%) !important;
            color: #ffffff !important;
            border: none !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.25);
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .single-form-section {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 12px;
            margin-top: 28px;
        }

        .single-form-section:first-child {
            margin-top: 0;
        }

        .checklist-row-input {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 6px;
            border-bottom: 1px dashed #e2e8f0;
            transition: all 0.2s ease;
        }

        .checklist-row-input:hover {
            background-color: #f8fafc;
        }

        .checklist-row-input.checked-item .item-text {
            text-decoration: line-through;
            color: #16a34a;
            font-weight: 600;
        }

        .custom-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #15803d;
        }

        .btn-add-point-clean {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #15803d !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
        }

        .btn-gradient-save {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%) !important;
            color: #ffffff !important;
            border: none !important;
            font-weight: 700 !important;
            font-size: 13.5px !important;
            padding: 9px 26px !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .input-date-sm {
            font-size: 11px !important;
            padding: 2px 6px !important;
            border-radius: 6px !important;
            border: 1px solid #cbd5e1;
            width: 125px;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid p-4 subpanel-container" style="background-color: #f8fafc; min-height: 100vh;">

    <!-- TOP HEADER BAR -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1 fs-4" style="color: #0f172a !important;">Sub-Process Checklist Form</h3>
            <p class="text-secondary small mb-0">Atur dan isi poin ketentuan alur sub-proses secara terintegrasi.</p>
        </div>

        <div>
            <a href="{{ route('admin.task.index') }}" class="btn btn-green-gradient">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.task.updateSubStatus', $task->id) }}" method="POST">
        @csrf

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            
            <!-- HEADER INFO PROJECT -->
            <div class="p-3 mb-4 batik-header-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge badge-itemcode-gold font-monospace text-uppercase">{{ $task->item_code }}</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1" style="color: #0f172a !important;">{{ $task->project_name }}</h5>
                        <p class="small mb-0 text-customer-stabilo">
                            <i class="bi bi-building me-1"></i> Customer: {{ $task->customer ?? '-' }}
                        </p>
                    </div>

                    <div class="d-flex align-items-center pe-2">
                        <img src="{{ asset('logo1.png') }}" alt="Amcor Logo" style="height: 42px; object-fit: contain;">
                    </div>
                </div>
            </div>

            <hr class="my-2 opacity-25">

            @php
                $subSections = [
                    ['key' => 'layout', 'title' => '1. Layout Process', 'icon' => 'bi-aspect-ratio', 'color' => 'text-primary', 'default' => ['Layout Approved', 'Scale Check 1:1', 'Color Separation Done']],
                    ['key' => 'baan', 'title' => '2. BaaN System', 'icon' => 'bi-database', 'color' => 'text-info', 'default' => ['Master Data Created', 'BOM Release', 'Routing Complete']],
                    ['key' => 'promp', 'title' => '3. Prompt Status', 'icon' => 'bi-terminal', 'color' => 'text-warning', 'default' => ['Command Synced', 'Proof Verification']],
                    ['key' => 'job_bag', 'title' => '4. Job Bag Creation', 'icon' => 'bi-bag-check', 'color' => 'text-success', 'default' => ['Job Bag Number Issued', 'Physical Bag Printed']]
                ];
            @endphp

            @foreach($subSections as $sec)
            @php
                // Ambil data yang sudah pernah tersimpan di DB
                $dbItems = isset($existingChecklists[$sec['key']]) ? $existingChecklists[$sec['key']] : collect();
            @endphp

            <div class="mb-4">
                
                <div class="single-form-section d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi {{ $sec['icon'] }} {{ $sec['color'] }} fs-5"></i>
                        <h6 class="fw-bold text-dark mb-0 fs-6">{{ $sec['title'] }}</h6>
                        
                        <span id="badge-status-{{ $sec['key'] }}" class="status-badge-notyet ms-1">
                            <i class="bi bi-circle-fill me-1" style="font-size: 6px; vertical-align: middle;"></i> Not Yet
                        </span>
                    </div>

                    <button type="button" class="btn btn-link btn-add-point-clean d-flex align-items-center gap-1" onclick="addCustomPoint('{{ $sec['key'] }}')">
                        <i class="bi bi-plus-circle"></i> Tambah Poin
                    </button>
                </div>

                <div id="wrapper-{{ $sec['key'] }}">
                    @if($dbItems->count() > 0)
                        {{-- Jika sudah ada di DB --}}
                        @foreach($dbItems as $index => $item)
                        <div class="checklist-row-input {{ $item->is_completed ? 'checked-item' : '' }}">
                            <div class="d-flex align-items-center gap-3 w-100">
                                <input type="checkbox" 
                                       name="checklists[{{ $sec['key'] }}][{{ $index }}][done]" 
                                       value="1" 
                                       {{ $item->is_completed ? 'checked' : '' }}
                                       class="form-check-input custom-check-input mt-0"
                                       onchange="toggleRowStyle(this, '{{ $sec['key'] }}')">
                                
                                <input type="text" 
                                       name="checklists[{{ $sec['key'] }}][{{ $index }}][title]" 
                                       value="{{ $item->task_title }}" 
                                       class="form-control form-control-sm border-0 bg-transparent item-text p-0 shadow-none fw-semibold text-dark" 
                                       style="font-size: 13.5px;">

                                <!-- SETTING TANGGAL TIMELINE -->
                                <div class="d-flex align-items-center gap-1 ms-auto me-2">
                                    <input type="date" name="checklists[{{ $sec['key'] }}][{{ $index }}][start_date]" value="{{ $item->start_date }}" class="form-control input-date-sm" title="Start Date">
                                    <span class="text-muted small">-</span>
                                    <input type="date" name="checklists[{{ $sec['key'] }}][{{ $index }}][end_date]" value="{{ $item->end_date }}" class="form-control input-date-sm" title="End Date">
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-link text-secondary p-0 opacity-50 opacity-100-hover ms-2" onclick="removePoint(this, '{{ $sec['key'] }}')" title="Hapus">
                                <i class="bi bi-x-lg" style="font-size: 12px;"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                        {{-- Load Default jika belum pernah diisi --}}
                        @foreach($sec['default'] as $index => $point)
                        <div class="checklist-row-input">
                            <div class="d-flex align-items-center gap-3 w-100">
                                <input type="checkbox" 
                                       name="checklists[{{ $sec['key'] }}][{{ $index }}][done]" 
                                       value="1" 
                                       class="form-check-input custom-check-input mt-0"
                                       onchange="toggleRowStyle(this, '{{ $sec['key'] }}')">
                                
                                <input type="text" 
                                       name="checklists[{{ $sec['key'] }}][{{ $index }}][title]" 
                                       value="{{ $point }}" 
                                       class="form-control form-control-sm border-0 bg-transparent item-text p-0 shadow-none fw-semibold text-dark" 
                                       style="font-size: 13.5px;">

                                <div class="d-flex align-items-center gap-1 ms-auto me-2">
                                    <input type="date" name="checklists[{{ $sec['key'] }}][{{ $index }}][start_date]" class="form-control input-date-sm" title="Start Date">
                                    <span class="text-muted small">-</span>
                                    <input type="date" name="checklists[{{ $sec['key'] }}][{{ $index }}][end_date]" class="form-control input-date-sm" title="End Date">
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-link text-secondary p-0 opacity-50 opacity-100-hover ms-2" onclick="removePoint(this, '{{ $sec['key'] }}')" title="Hapus">
                                <i class="bi bi-x-lg" style="font-size: 12px;"></i>
                            </button>
                        </div>
                        @endforeach
                    @endif
                </div>

            </div>
            @endforeach

            <div class="pt-3 border-top mt-2 d-flex justify-content-end">
                <button type="submit" class="btn-gradient-save d-inline-flex align-items-center gap-2">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        ['layout', 'baan', 'promp', 'job_bag'].forEach(sectionKey => {
            updateSectionBadge(sectionKey);
        });
    });

    function addCustomPoint(sectionKey) {
        const wrapper = document.getElementById(`wrapper-${sectionKey}`);
        const newIndex = wrapper.children.length;

        const row = document.createElement('div');
        row.className = 'checklist-row-input';
        row.innerHTML = `
            <div class="d-flex align-items-center gap-3 w-100">
                <input type="checkbox" 
                       name="checklists[${sectionKey}][${newIndex}][done]" 
                       value="1" 
                       class="form-check-input custom-check-input mt-0"
                       onchange="toggleRowStyle(this, '${sectionKey}')">
                
                <input type="text" 
                       name="checklists[${sectionKey}][${newIndex}][title]" 
                       placeholder="Ketikkan ketentuan baru di sini..." 
                       class="form-control form-control-sm border-0 bg-transparent item-text p-0 shadow-none fw-semibold text-dark" 
                       style="font-size: 13.5px;" autofocus>

                <div class="d-flex align-items-center gap-1 ms-auto me-2">
                    <input type="date" name="checklists[${sectionKey}][${newIndex}][start_date]" class="form-control input-date-sm" title="Start Date">
                    <span class="text-muted small">-</span>
                    <input type="date" name="checklists[${sectionKey}][${newIndex}][end_date]" class="form-control input-date-sm" title="End Date">
                </div>
            </div>
            <button type="button" class="btn btn-link text-secondary p-0 opacity-50 opacity-100-hover ms-2" onclick="removePoint(this, '${sectionKey}')" title="Hapus">
                <i class="bi bi-x-lg" style="font-size: 12px;"></i>
            </button>
        `;

        wrapper.appendChild(row);
        updateSectionBadge(sectionKey);
    }

    function toggleRowStyle(checkbox, sectionKey) {
        const row = checkbox.closest('.checklist-row-input');
        if (checkbox.checked) {
            row.classList.add('checked-item');
        } else {
            row.classList.remove('checked-item');
        }
        updateSectionBadge(sectionKey);
    }

    function removePoint(button, sectionKey) {
        const row = button.closest('.checklist-row-input');
        row.remove();
        updateSectionBadge(sectionKey);
    }

    function updateSectionBadge(sectionKey) {
        const wrapper = document.getElementById(`wrapper-${sectionKey}`);
        const badge = document.getElementById(`badge-status-${sectionKey}`);
        
        if (!wrapper || !badge) return;

        const checkedBoxes = wrapper.querySelectorAll('.custom-check-input:checked');
        
        if (checkedBoxes.length > 0) {
            badge.className = 'status-badge-active ms-1';
            badge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Active';
        } else {
            badge.className = 'status-badge-notyet ms-1';
            badge.innerHTML = '<i class="bi bi-circle-fill me-1" style="font-size: 6px; vertical-align: middle;"></i> Not Yet';
        }
    }
</script>
@endsection