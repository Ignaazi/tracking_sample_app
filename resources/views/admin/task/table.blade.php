@extends('layouts.admin')

@section('title', 'Data Project Status - NiceAdmin')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@section('content')
<main id="main" class="main" style="font-family: 'Nunito', sans-serif; background-color: #f6f9ff; min-height: 100vh;">

    <!-- Top Bar / Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: #212529; margin: 0 0 4px 0;">Data Project Status</h1>
            <p class="text-muted m-0" style="font-size: 13.5px;">Track and manage customer database records individually per entity</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white bg-white border rounded-3 btn-sm fw-semibold px-3 py-2 d-flex align-items-center gap-2" style="font-size: 13px; color: #212529; font-family: 'Nunito', sans-serif;">
                <i class="bi bi-download"></i> Export
            </button>
            <a href="{{ route('admin.task.index') }}" class="btn btn-primary rounded-3 btn-sm fw-semibold px-3 py-2 d-flex align-items-center gap-2" style="font-size: 13px; background-color: #4154f1; border-color: #4154f1; font-family: 'Nunito', sans-serif;">
                <i class="bi bi-grid-3x3-gap-fill"></i> Switch to Kanban
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm rounded-3" role="alert" style="background-color: #e8f5e9; color: #1b5e20; font-size: 13.5px; font-family: 'Nunito', sans-serif;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-5">
        
        <!-- Filter and Search -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2" style="font-size: 14px; color: #212529;">
                <select class="form-select border rounded-3 shadow-none text-center" style="width: 80px; height: 38px; font-size: 14px; font-family: 'Nunito', sans-serif; color: #212529;">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-secondary">entries </span>
            </div>
            
            <div style="width: 260px;">
                <input type="text" class="form-control border rounded-3 shadow-none" placeholder="Search orders..." style="height: 38px; font-size: 14px; padding-left: 15px; font-family: 'Nunito', sans-serif; color: #212529;">
            </div>
        </div>

        <!-- Table Responsive dengan Custom Wrap Text Layout -->
        <div class="table-responsive shadow-sm rounded-3 border">
            <table class="table align-middle mb-0" style="font-size: 13px; table-layout: fixed; width: 100%; min-width: 4200px; --bs-table-hover-bg: #f8fafc; font-family: 'Nunito', sans-serif;">
                <thead style="background-color: #f3f6f9; color: #212529; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <tr>
                        <!-- Header Tanpa Nomor & Dilengkapi Width Controller -->
                        <th class="py-3 ps-3" style="border-bottom: 2px solid #cbd5e1; width: 60px;">No</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Item Code</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 150px;">Brand / Family</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 110px;">Market</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 220px;">Project Name</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">PD ASCIS</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Customer</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">CS Brand</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">CS HW</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">CPI HW</th>

                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 160px;">S5 Internal Approval</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">GHW Set</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 150px;">Information Received</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">PLM Released</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">COI Number</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Green Light</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 100px;">TD</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">Machine</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Board</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Board U Code</th>

                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Board A Code</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 110px;">Type CM</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Die Cut Number</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">S10 Number</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">S11 Number</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">S12 Number</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 160px;">Cylinder Supplier</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Repro By</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Sequence (Seq)</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Colour</th>

                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">BAAN Cylinder</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Film Number</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Ink System</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Ink Code</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Supplier Ink</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">BAAN Ink Code</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 110px;">Coverage (%)</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">Usage (Kg/TH)</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Angle / Anilox</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 260px;">Remarks</th>

                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 240px;">Main Design / Attachment</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Project Status</th>
                        
                        <!-- Internal Tracking Bawaan -->
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 120px;">Dev Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Layout Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Baan Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 130px;">Promp Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Job Bag Status</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1; width: 130px;">SAP Number</th>
                        
                        <!-- Actions Button -->
                        <th class="py-3 text-end pe-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $index => $task)
                    <tr style="border-bottom: 1px solid #e9ecef; color: #212529;">
                        
                        <!-- No -->
                        <td class="py-3 ps-3 fw-semibold text-dark text-wrap">
                            {{ str_pad($task->no ?? ($index + 1), 2, '0', STR_PAD_LEFT) }}
                        </td>
                        
                        <!-- Item Code -->
                        <td class="py-3 fw-bold font-monospace text-primary text-wrap word-break" style="word-break: break-all;">{{ $task->item_code }}</td>

                        <!-- Brand Family -->
                        <td class="py-3 fw-semibold text-wrap">{{ $task->brand_family ?? '-' }}</td>

                        <!-- Market -->
                        <td class="py-3 fw-semibold text-wrap">{{ $task->market ?? '-' }}</td>

                        <!-- Project Name (Dilengkapi fitur auto wrap text) -->
                        <td class="py-3 fw-semibold text-wrap text-break" style="color: #012970; line-height: 1.4;">{{ $task->project_name }}</td>
                        
                        <!-- PD ASCIS -->
                        <td class="py-3 text-wrap">{{ $task->ascis_pd ?? '-' }}</td>

                        <!-- Customer ID -->
                        <td class="py-3 fw-semibold text-wrap">{{ $task->customer }}</td>

                        <!-- CS Brand -->
                        <td class="py-3 text-wrap">{{ $task->cs_brand ?? '-' }}</td>

                        <!-- CS HW -->
                        <td class="py-3 text-wrap">{{ $task->cs_hw ?? '-' }}</td>

                        <!-- CPI HW -->
                        <td class="py-3 text-wrap">{{ $task->cpi_hw ?? '-' }}</td>

                        <!-- S5 Internal Approval -->
                        <td class="py-3 text-wrap text-break">{{ $task->s5_internal_approval ?? '-' }}</td>

                        <!-- GHW Set -->
                        <td class="py-3 text-wrap">{{ $task->ghw_set ?? '-' }}</td>

                        <!-- Information Received -->
                        <td class="py-3 font-monospace text-wrap">
                            {{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('d-m-Y') : '-' }}
                        </td>

                        <!-- PLM Released -->
                        <td class="py-3 font-monospace text-wrap">
                            {{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('d-m-Y') : '-' }}
                        </td>

                        <!-- COI Number -->
                        <td class="py-3 text-wrap text-break">{{ $task->coi_number ?? '-' }}</td>

                        <!-- Green Light -->
                        <td class="py-3 text-wrap">{{ $task->green_light ?? '-' }}</td>

                        <!-- TD -->
                        <td class="py-3 text-wrap">{{ $task->td ?? '-' }}</td>

                        <!-- Machine -->
                        <td class="py-3 text-wrap">{{ $task->machine ?? '-' }}</td>

                        <!-- Board -->
                        <td class="py-3 text-wrap text-break">{{ $task->board ?? '-' }}</td>

                        <!-- Board U Code -->
                        <td class="py-3 font-monospace text-wrap text-break">{{ $task->board_u_code ?? '-' }}</td>

                        <!-- Board A Code -->
                        <td class="py-3 font-monospace text-wrap text-break">{{ $task->board_a_code ?? '-' }}</td>

                        <!-- Type CM -->
                        <td class="py-3 text-wrap">{{ $task->type_cm ?? '-' }}</td>

                        <!-- Die Cut Number -->
                        <td class="py-3 text-wrap text-break">{{ $task->die_cut_number ?? '-' }}</td>

                        <!-- S10 Number -->
                        <td class="py-3 font-monospace text-wrap">{{ $task->s10_number ?? '-' }}</td>

                        <!-- S11 Number -->
                        <td class="py-3 font-monospace text-wrap">{{ $task->s11_number ?? '-' }}</td>

                        <!-- S12 Number -->
                        <td class="py-3 font-monospace text-wrap">{{ $task->s12_number ?? '-' }}</td>

                        <!-- Cylinder Supplier -->
                        <td class="py-3 text-wrap text-break" style="line-height: 1.3;">{{ $task->cylinder_supplier ?? '-' }}</td>

                        <!-- Repro By -->
                        <td class="py-3 text-wrap">{{ $task->repro_by ?? '-' }}</td>

                        <!-- Sequence (Seq) -->
                        <td class="py-3 text-wrap">{{ $task->sequence_seq ?? '-' }}</td>

                        <!-- Colour -->
                        <td class="py-3 text-wrap text-break" style="line-height: 1.3;">{{ $task->colour ?? '-' }}</td>

                        <!-- BAAN Cylinder -->
                        <td class="py-3 font-monospace text-wrap text-break">{{ $task->baan_cylinder ?? '-' }}</td>

                        <!-- Film Number -->
                        <td class="py-3 font-monospace text-wrap text-break">{{ $task->film_number ?? '-' }}</td>

                        <!-- Ink System -->
                        <td class="py-3 text-wrap text-break">{{ $task->ink_system ?? '-' }}</td>

                        <!-- Ink Code -->
                        <td class="py-3 font-monospace text-wrap text-break">{{ $task->ink_code ?? '-' }}</td>

                        <!-- Supplier Ink -->
                        <td class="py-3 text-wrap text-break">{{ $task->supplier_ink ?? '-' }}</td>

                        <!-- BAAN Ink Code -->
                        <td class="py-3 font-monospace text-wrap text-break">{{ $task->baan_ink_code ?? '-' }}</td>

                        <!-- Coverage (%) -->
                        <td class="py-3 text-wrap">{{ $task->coverage_percent ? $task->coverage_percent . '%' : '-' }}</td>

                        <!-- Usage (Kg/TH) -->
                        <td class="py-3 text-wrap">{{ $task->usage_kg_th ? $task->usage_kg_th . ' Kg/TH' : '-' }}</td>

                        <!-- Angle / Anilox -->
                        <td class="py-3 text-wrap text-break">{{ $task->angle_anilox ?? '-' }}</td>

                        <!-- Remarks (Wrap Text Optimized) -->
                        <td class="py-3 text-wrap text-break" style="line-height: 1.4; font-size: 12.5px; white-space: normal;">
                            {{ $task->remark ?? '-' }}
                        </td>

                        <!-- Main Design / Attachment (Wrap Text Optimized) -->
                        <td class="py-3 text-wrap text-break" style="white-space: normal; line-height: 1.3;">
                            @if($task->main_design_attachment)
                                <a href="#" class="text-decoration-none text-primary fw-semibold">
                                    <i class="bi bi-file-earmark-arrow-down-fill me-1"></i>{{ $task->main_design_attachment }}
                                </a>
                            @else
                                <span class="text-muted italic">-</span>
                            @endif
                        </td>

                        <!-- Project Status -->
                        <td class="text-center py-3">
                            @php
                                $statusStyle = [
                                    'To Do'        => ['bg' => '#f1f5f9', 'text' => '#475569'],
                                    'In Progress' => ['bg' => '#fff7ed', 'text' => '#ea580c'],
                                    'Ready for QA'=> ['bg' => '#eff6ff', 'text' => '#2563eb'],
                                    'Completed'   => ['bg' => '#e8f5e9', 'text' => '#2e7d32']
                                ];
                                $style = $statusStyle[$task->status] ?? ['bg' => '#f8fafc', 'text' => '#64748b'];
                            @endphp
                            <span class="badge rounded-pill px-2.5 py-1" style="background-color: {{ $style['bg'] }}; color: {{ $style['text'] }}; font-size: 12px; letter-spacing: 0.3px; font-family: 'Nunito', sans-serif;">
                                {{ $task->status }}
                            </span>
                        </td>

                        <!-- Dev Status -->
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1 text-dark" style="font-size: 11.5px; background-color: #f1f5f9;">
                                {{ $task->development_status ?? 'Active' }}
                            </span>
                        </td>

                        <!-- Layout Status -->
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px;
                                {{ $task->layout_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->layout_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->layout_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- Baan Status -->
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px;
                                {{ $task->baan_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->baan_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->baan_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- Promp Status -->
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px;
                                {{ $task->promp_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->promp_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->promp_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- Job Bag Status -->
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px;
                                {{ $task->job_bag_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->job_bag_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->job_bag_status ?? 'Pending' }}
                            </span>
                        </td>

                        <!-- SAP Number -->
                        <td class="py-3 fw-semibold font-monospace text-wrap" style="font-size: 13px; word-break: break-all;">
                            {{ $task->sap_number ?? '-' }}
                        </td>

                        <!-- Actions Buttons -->
                        <td class="text-end py-3 pe-3">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editTaskModalTable{{ $task->item_code }}" class="btn btn-sm text-dark d-flex align-items-center justify-content-center shadow-none border-0" style="width: 32px; height: 32px; border-radius: 6px; background-color: #ffc107;" title="Edit Record">
                                    <i class="bi bi-pencil-square" style="font-size: 14px; display: inline-block;"></i>
                                </button>
                                <button type="button" onclick="event.preventDefault(); if(confirm('Delete project data permanently?')) document.getElementById('delete-table-task-{{ $task->item_code }}').submit();" class="btn btn-sm text-white d-flex align-items-center justify-content-center shadow-none border-0" style="width: 32px; height: 32px; border-radius: 6px; background-color: #dc3545;" title="Delete Record">
                                    <i class="bi bi-trash3-fill" style="font-size: 14px; display: inline-block;"></i>
                                </button>
                            </div>
                            <form id="delete-table-task-{{ $task->item_code }}" action="{{ route('admin.task.destroy', $task->item_code) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="49" class="text-center py-5 text-muted" style="font-style: italic; font-family: 'Nunito', sans-serif;">
                            <i class="bi bi-inbox d-block mb-2 opacity-40" style="font-size: 28px;"></i>
                            No individual project data entries stored inside database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3" style="font-size: 14px; color: #212529; font-family: 'Nunito', sans-serif;">
            <div class="fw-semibold">
                Showing 1 to {{ min($tasks->count(), 25) }} of {{ $tasks->count() }} entries
            </div>
            
            <nav>
                <ul class="pagination pagination-sm m-0 gap-2">
                    <li class="page-item disabled">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14); opacity: 0.6;" href="#">
                            <i class="bi bi-chevron-left" style="font-size: 14px; display: inline-block;"></i>
                        </a>
                    </li>

                    <li class="page-item active">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            1
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            2
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            3
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            <i class="bi bi-chevron-right" style="font-size: 14px; display: inline-block;"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>

</main>

<!-- Loop Modal Edit Specs -->
@foreach($tasks as $task)
    @include('admin.task.partials.modal-edit-table-specs')
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection