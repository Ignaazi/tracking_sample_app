@extends('layouts.admin')

@section('title', 'Add Item Specification')

@push('styles')
    <!-- Bootstrap Icons & Google Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .workspace-container, .workspace-container * {
            font-family: 'Nunito', sans-serif !important;
        }
        
        /* WORKSPACE CONTAINER */
        .workspace-container { 
            background-color: transparent !important; 
            background: transparent !important;
            min-height: auto !important; 
            box-shadow: none !important;
            padding: 1.25rem 1.5rem !important;
        }

        /* TOMBOL BACK GRADIENT LIME */
        .btn-back-bright {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #ffffff !important;
            font-weight: 800;
            font-size: 13.5px;
            padding: 7px 20px;
            border-radius: 6px;
            border: none;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.4);
            transition: all 0.25s ease-in-out;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-back-bright:hover {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            transform: translateY(-2px);
            color: #ffffff !important;
            box-shadow: 0 6px 18px rgba(34, 197, 94, 0.55);
        }

        /* TOMBOL SAVE HIJAU */
        .btn-save-green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #ffffff !important;
            font-weight: 800;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.3);
        }
        .btn-save-green:hover {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            transform: translateY(-1px);
            color: #ffffff !important;
            box-shadow: 0 6px 14px rgba(34, 197, 94, 0.45);
        }

        /* TOMBOL BATAL MERAH */
        .btn-cancel-grad {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff !important;
            font-weight: 700;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
        }
        .btn-cancel-grad:hover {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: #ffffff !important;
            box-shadow: 0 6px 12px rgba(239, 68, 68, 0.35);
        }

        /* CARD FORM UTAMA */
        .form-card-wrapper {
            background-color: #ffffff;
            border: 1.5px solid #0369a1 !important;
            border-radius: 6px;
            box-shadow: 0 4px 15px rgba(3, 105, 161, 0.08);
            overflow: hidden;
            height: 100%;
        }
        .form-header-bar {
            background: linear-gradient(135deg, #0f172a 0%, #0369a1 45%, #0d9488 100%);
            color: #ffffff;
            padding: 0.65rem 1.25rem;
        }

        /* COMPACT FORM CONTROL */
        .form-compact .form-group-item {
            margin-bottom: 0.5rem;
        }
        .form-compact .form-label {
            font-size: 12px !important;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px !important;
            display: block;
        }
        .form-compact .form-control, .form-compact .form-select {
            font-size: 12.5px !important;
            padding: 5px 10px !important;
            border-radius: 5px !important;
            border-color: #cbd5e1;
        }
        .form-compact .form-control:focus, .form-compact .form-select:focus {
            border-color: #0284c7 !important;
            box-shadow: 0 0 0 0.2rem rgba(2, 132, 199, 0.2) !important;
        }

        /* PREVIEW CARD & DETAILS */
        .preview-card-wrapper {
            background-color: #ffffff;
            border: 1.5px solid #38bdf8;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.08);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .image-preview-box {
            width: 100%;
            height: 195px;
            border: 2px dashed #0284c7;
            border-radius: 6px;
            background-color: #f0f9ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .image-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: none;
        }

        /* ITEM MASTER DETAILS CARD */
        .master-details-card {
            border: 1.5px solid #0284c7;
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffffff;
        }
        .master-details-header {
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 50%, #059669 100%);
            color: #ffffff;
            padding: 7px 12px;
            font-size: 12.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .master-details-table {
            margin-bottom: 0 !important;
            font-size: 12px !important;
        }
        .master-details-table td {
            padding: 6px 8px !important;
            border-bottom: 1px solid #e2e8f0;
        }
        .master-details-table tr:last-child td {
            border-bottom: none;
        }

        /* TABEL HISTORY & HEADER GRADIENT BLUE */
        .history-card-wrapper {
            background-color: #ffffff;
            border: 1.5px solid #475569 !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .history-header-gray {
            background-color: #334155 !important;
        }
        .table-grid-bordered {
            border-collapse: collapse !important;
            font-size: 12.5px !important;
            font-family: 'Nunito', sans-serif !important;
        }
        .table-grid-bordered th {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            white-space: nowrap;
            border: 1px solid #cbd5e1 !important;
            padding: 8px 10px !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-family: 'Nunito', sans-serif !important;
        }

        /* ISIAN TABEL (TBODY) KONSISTEN BISA BACA DENGEN UKURAN SAMA */
        .table-grid-bordered tbody td {
            border: 1px solid #cbd5e1 !important;
            padding: 6px 8px !important;
            text-align: center !important;
            vertical-align: middle !important;
            color: #0f172a !important;
            font-weight: 600 !important;
            font-style: normal !important;
            font-size: 12.5px !important;
            font-family: 'Nunito', sans-serif !important;
            background-color: transparent !important;
        }
        .table-grid-bordered tbody tr:hover {
            background-color: #f0f9ff !important;
        }

        /* BADGE SEQUENCE HIJAU TUA DISESUAIKAN UKURAN TABLE */
        .badge-seq-green {
            background-color: #15803d !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border-radius: 4px !important;
            padding: 3px 8px !important;
            font-size: 11.5px !important;
            display: inline-block;
            font-family: 'Nunito', sans-serif !important;
        }

        /* BADGE STATUS PROPORSI PAS SAMA TEKS TABLE */
        .badge-status-sm {
            font-size: 11.5px !important;
            font-weight: 700 !important;
            padding: 3px 8px !important;
            border-radius: 4px !important;
            font-family: 'Nunito', sans-serif !important;
        }

        /* STYLES TOMBOL ACTION */
        .table-action-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-action-sm {
            width: 28px;
            height: 28px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            border: none;
            color: #ffffff !important;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-action-sm:hover {
            transform: translateY(-1px);
            opacity: 0.9;
        }
        .btn-preview-info {
            background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
        }
        .btn-edit-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .btn-delete-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
    </style>
@endpush

@section('content')
<div class="container-fluid workspace-container">

    <!-- HEADER & TOMBOL BACK -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="fw-bold text-dark mb-0 fs-4">Add Printing Specification</h3>
            <p class="text-muted small mb-0">Input spesifikasi warna & penggunaan tinta untuk Item Code: <strong class="text-primary">{{ $task->item_code }}</strong></p>
        </div>
        <a href="{{ route('admin.item-specs.index') }}" class="btn-back-bright">
            <i class="bi bi-arrow-left fs-6"></i> Back
        </a>
    </div>

    <!-- MAIN CONTENT 2 COLUMN LAYOUT -->
    <form action="{{ route('admin.item-specs.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <input type="hidden" name="item_code" value="{{ $task->item_code }}">

        <div class="row g-3 align-items-stretch">
            
            <!-- KOLOM KIRI: FORM ITEM SPECIFICATION -->
            <div class="col-lg-8">
                <div class="card form-card-wrapper border-0">
                    <div class="form-header-bar d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0" style="font-size: 13.5px;">
                            <i class="bi bi-sliders me-1.5"></i>Spec Sequence Form [{{ $task->item_code }}]
                        </h6>
                        <span class="badge bg-white text-dark fw-bold border px-2.5 py-1" style="font-size: 11px;">Item Specification</span>
                    </div>

                    <div class="card-body p-3 form-compact">

                        <div class="row g-2">
                            <!-- 6 INPUT KOLOM KIRI -->
                            <div class="col-md-6">
                                <div class="form-group-item">
                                    <label class="form-label">Sequence Order <span class="text-danger">*</span></label>
                                    <input type="number" name="sequence" class="form-control" min="1" max="12" placeholder="1-12" value="{{ ($task->itemSpecs->max('sequence') ?? 0) + 1 }}" required>
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Colour Name <span class="text-danger">*</span></label>
                                    <input type="text" name="colour" class="form-control" placeholder="e.g. White / Cyan" required>
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">BAAN Cylinder</label>
                                    <input type="text" name="baan_cylinder" class="form-control" placeholder="Cylinder ID Code">
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Film Number</label>
                                    <input type="text" name="film_number" class="form-control" placeholder="Film identification no.">
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Ink System</label>
                                    <input type="text" name="ink_system" class="form-control" placeholder="Ink specification">
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Ink Code</label>
                                    <input type="text" name="ink_code" class="form-control" placeholder="Ink Code">
                                </div>
                            </div>

                            <!-- 6 INPUT KOLOM KANAN -->
                            <div class="col-md-6">
                                <div class="form-group-item">
                                    <label class="form-label">Supplier Ink</label>
                                    <select name="supplier_ink" class="form-select">
                                        <option value="">-- Pilih Supplier --</option>
                                        <option value="SIEG">SIEG</option>
                                        <option value="DIC">DIC</option>
                                        <option value="HUBER">HUBER</option>
                                        <option value="SC">SC</option>
                                    </select>
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">BAAN Ink Code</label>
                                    <input type="text" name="baan_ink_code" class="form-control" placeholder="BAAN Ink Code">
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Coverage (%)</label>
                                    <input type="number" step="0.01" name="coverage" class="form-control" placeholder="e.g. 25.5">
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Usage (Kg/TH)</label>
                                    <input type="number" step="0.01" name="usage_kg_th" class="form-control" placeholder="Usage">
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Angle / Anilox</label>
                                    <input type="text" name="angle_anilox" class="form-control" placeholder="Angle / Anilox">
                                </div>
                                <div class="form-group-item">
                                    <label class="form-label">Project Status <span class="text-danger">*</span></label>
                                    <select name="project_status" class="form-select" required>
                                        <option value="To Do" {{ strtolower($task->status ?? '') == 'to do' ? 'selected' : '' }}>To Do</option>
                                        <option value="Progress" {{ strtolower($task->status ?? '') == 'in progress' ? 'selected' : '' }}>Progress</option>
                                        <option value="Completed" {{ strtolower($task->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ATTACHMENT FILE UTAMA (SINGLE ATTACHMENT PER ITEM CODE) -->
                        <div class="form-group-item mt-1">
                            <label class="form-label">Main Design / Attachment File (1 File Utama untuk {{ $task->item_code }})</label>
                            <input type="file" name="main_design_attachment" id="attachmentInput" class="form-control" accept="image/*,.pdf,.ai,.psd,.zip">
                        </div>

                        <!-- REMARKS -->
                        <div class="form-group-item">
                            <label class="form-label">Remarks / Special Notes</label>
                            <textarea name="remarks" class="form-control" rows="2" placeholder="Catatan opsional mengenai spesifikasi ini..."></textarea>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-2 mt-2">
                            <a href="{{ route('admin.item-specs.index') }}" class="btn btn-sm btn-cancel-grad px-4 py-1" style="border-radius: 5px;">Batal</a>
                            <button type="submit" class="btn btn-sm btn-save-green px-4 py-1" style="border-radius: 5px;">
                                <i class="bi bi-check-lg me-1"></i> Save
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: PREVIEW DESIGN & ITEM DETAILS SUMMARY -->
            <div class="col-lg-4">
                <div class="card preview-card-wrapper p-3">
                    <div>
                        <div class="fw-bold text-dark mb-2 pb-1 border-bottom d-flex align-items-center justify-content-between" style="font-size: 13px;">
                            <span><i class="bi bi-image me-1.5 text-primary"></i>Artwork Preview</span>
                            <span class="badge bg-light text-dark border" style="font-size: 10px;">Live View</span>
                        </div>

                        <!-- LIVE PREVIEW IMAGE BOX -->
                        <div class="image-preview-box mb-3" id="previewContainer">
                            @php
                                $existingAttachment = $task->itemSpecs->whereNotNull('main_design_attachment')->first()->main_design_attachment ?? null;
                            @endphp

                            @if($existingAttachment && file_exists(public_path($existingAttachment)))
                                <i class="bi bi-cloud-upload text-primary display-6 mb-1" id="placeholderIcon" style="display: none;"></i>
                                <span class="text-muted fw-bold" style="font-size: 11.5px; display: none;" id="placeholderText">Pilih foto untuk preview</span>
                                <img id="imagePreview" src="{{ asset($existingAttachment) }}" alt="Design Artwork Preview" style="display: block;">
                            @else
                                <i class="bi bi-cloud-upload text-primary display-6 mb-1" id="placeholderIcon"></i>
                                <span class="text-muted fw-bold" style="font-size: 11.5px;" id="placeholderText">Pilih foto untuk preview</span>
                                <img id="imagePreview" alt="Design Artwork Preview">
                            @endif
                        </div>
                    </div>

                    <!-- TASK SUMMARY INFO -->
                    <div class="master-details-card mt-auto">
                        <div class="master-details-header">
                            <i class="bi bi-info-circle-fill"></i> Item Master Details
                        </div>
                        
                        <table class="table table-borderless align-middle master-details-table">
                            <tbody>
                                <tr>
                                    <td class="text-muted ps-2" style="width: 100px;">Item Code</td>
                                    <td class="text-secondary text-center" style="width: 10px;">:</td>
                                    <td class="fw-bold text-dark pe-2 text-break">{{ $task->item_code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-2">Project Name</td>
                                    <td class="text-secondary text-center">:</td>
                                    <td class="fw-bold text-dark pe-2 text-break">{{ $task->project_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-2">Customer</td>
                                    <td class="text-secondary text-center">:</td>
                                    <td class="fw-bold text-dark pe-2 text-break">{{ $task->customer ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-2">Market</td>
                                    <td class="text-secondary text-center">:</td>
                                    <td class="fw-bold text-dark pe-2 text-break">{{ $task->market ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-2">Board</td>
                                    <td class="text-secondary text-center">:</td>
                                    <td class="fw-bold text-dark pe-2 text-break">{{ $task->board ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </form>

    <!-- BAGIAN BAWAH: TABEL DAFTAR SPESIFIKASI -->
    <div class="card history-card-wrapper border-0">
        <div class="card-header history-header-gray text-white py-2.5 px-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h6 class="fw-bold mb-0" style="font-size: 13.5px;">
                <i class="bi bi-list-check me-1.5"></i>PRINTING COLOUR & INK SPECIFICATIONS FOR [{{ $task->item_code }}]
            </h6>
            
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark fw-bold font-monospace px-2.5 py-1" style="font-size: 11px;">
                    {{ $task->itemSpecs->count() }} Sequences Recorded
                </span>

                <button type="button" onclick="exportTableToCSV('item-spec-{{ $task->item_code }}.csv')" class="btn btn-sm btn-light text-primary fw-bold px-3 py-1 shadow-sm" style="font-size: 11.5px; border-radius: 4px;">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-grid-bordered align-middle mb-0" id="specsTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 70px;">Sequence</th>
                            <th class="text-start ps-3">Colour Name</th>
                            <th>BAAN Cylinder</th>
                            <th>Film No.</th>
                            <th>Ink System</th>
                            <th>Ink Code</th>
                            <th>Supplier</th>
                            <th>BAAN Ink Code</th>
                            <th>Coverage (%)</th>
                            <th>Usage (Kg/TH)</th>
                            <th>Angle / Anilox</th>
                            <th>Remarks</th>
                            <th>Attachment</th>
                            <th>Status</th>
                            <th style="width: 110px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($task->itemSpecs->sortBy('sequence') as $index => $spec)
                        @php
                            // CEK KELENGKAPAN FIELD UNTUK MENENTUKAN STATUS OTOMATIS
                            $isComplete = !empty($spec->sequence) &&
                                          !empty($spec->colour) &&
                                          !empty($spec->baan_cylinder) &&
                                          !empty($spec->film_number) &&
                                          !empty($spec->ink_system) &&
                                          !empty($spec->ink_code) &&
                                          !empty($spec->supplier_ink) &&
                                          !empty($spec->baan_ink_code) &&
                                          !is_null($spec->coverage) &&
                                          !is_null($spec->usage_kg_th) &&
                                          !empty($spec->angle_anilox);
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{ sprintf('%02d', $index + 1) }}
                            </td>
                            <td><span class="badge-seq-green">Seq {{ $spec->sequence }}</span></td>
                            <td class="text-start ps-3">{{ $spec->colour }}</td>
                            <td>{{ $spec->baan_cylinder ?? '-' }}</td>
                            <td>{{ $spec->film_number ?? '-' }}</td>
                            <td>{{ $spec->ink_system ?? '-' }}</td>
                            <td>{{ $spec->ink_code ?? '-' }}</td>
                            <td>{{ $spec->supplier_ink ?? '-' }}</td>
                            <td>{{ $spec->baan_ink_code ?? '-' }}</td>
                            <td>{{ $spec->coverage ? $spec->coverage . '%' : '-' }}</td>
                            <td>{{ $spec->usage_kg_th ? number_format($spec->usage_kg_th, 2) : '-' }}</td>
                            <td>{{ $spec->angle_anilox ?? '-' }}</td>
                            <td>{{ $spec->remarks ?? '-' }}</td>
                            <td>
                                @if($spec->main_design_attachment)
                                    <a href="{{ asset($spec->main_design_attachment) }}" target="_blank" class="btn btn-xs btn-outline-primary p-0 px-2 py-0.5 fw-bold" style="font-size: 11.5px;">
                                        <i class="bi bi-paperclip me-1"></i>File
                                    </a>
                                @else
                                    <span class="text-muted" style="font-size: 11.5px;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($isComplete)
                                    <span class="badge bg-success badge-status-sm">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark badge-status-sm">Progress</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-action-btns">
                                    <!-- TOMBOL PREVIEW -->
                                    <a href="{{ route('admin.item-specs.show', $task->id) }}" 
                                       class="btn-action-sm btn-preview-info" 
                                       title="Preview Details">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <!-- TOMBOL EDIT MODAL -->
                                    <button type="button" 
                                            class="btn-action-sm btn-edit-warning" 
                                            title="Edit Spec" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editSpecModal{{ $spec->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- TOMBOL DELETE DENGAN SWEETALERT2 -->
                                    <form id="delete-form-{{ $spec->id }}" action="{{ route('admin.item-specs.destroy', $spec->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action-sm btn-delete-danger" title="Hapus Spec" onclick="confirmDelete({{ $spec->id }}, {{ $spec->sequence }})">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="16" class="text-center py-4 text-muted fw-semibold">
                                <i class="bi bi-info-circle me-1"></i> Belum ada spesifikasi warna yang tersimpan untuk item ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- LOOP MODAL EDIT PER SEQUENCE -->
@foreach($task->itemSpecs as $spec)
<div class="modal fade" id="editSpecModal{{ $spec->id }}" tabindex="-1" aria-labelledby="editSpecModalLabel{{ $spec->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-2.5">
                <h6 class="modal-title fw-bold" id="editSpecModalLabel{{ $spec->id }}">
                    <i class="bi bi-pencil-square me-1"></i> Edit Sequence #{{ $spec->sequence }} - {{ $spec->colour }}
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.item-specs.update', $spec->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="item_code" value="{{ $task->item_code }}">
                
                <div class="modal-body p-3 form-compact">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="form-group-item">
                                <label class="form-label">Sequence Order <span class="text-danger">*</span></label>
                                <input type="number" name="sequence" class="form-control" value="{{ $spec->sequence }}" min="1" max="12" required>
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Colour Name <span class="text-danger">*</span></label>
                                <input type="text" name="colour" class="form-control" value="{{ $spec->colour }}" required>
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">BAAN Cylinder</label>
                                <input type="text" name="baan_cylinder" class="form-control" value="{{ $spec->baan_cylinder }}">
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Film Number</label>
                                <input type="text" name="film_number" class="form-control" value="{{ $spec->film_number }}">
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Ink System</label>
                                <input type="text" name="ink_system" class="form-control" value="{{ $spec->ink_system }}">
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Ink Code</label>
                                <input type="text" name="ink_code" class="form-control" value="{{ $spec->ink_code }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-item">
                                <label class="form-label">Supplier Ink</label>
                                <select name="supplier_ink" class="form-select">
                                    <option value="">-- Pilih Supplier --</option>
                                    <option value="SIEG" {{ $spec->supplier_ink == 'SIEG' ? 'selected' : '' }}>SIEG</option>
                                    <option value="DIC" {{ $spec->supplier_ink == 'DIC' ? 'selected' : '' }}>DIC</option>
                                    <option value="HUBER" {{ $spec->supplier_ink == 'HUBER' ? 'selected' : '' }}>HUBER</option>
                                    <option value="SC" {{ $spec->supplier_ink == 'SC' ? 'selected' : '' }}>SC</option>
                                </select>
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">BAAN Ink Code</label>
                                <input type="text" name="baan_ink_code" class="form-control" value="{{ $spec->baan_ink_code }}">
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Coverage (%)</label>
                                <input type="number" step="0.01" name="coverage" class="form-control" value="{{ $spec->coverage }}">
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Usage (Kg/TH)</label>
                                <input type="number" step="0.01" name="usage_kg_th" class="form-control" value="{{ $spec->usage_kg_th }}">
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Angle / Anilox</label>
                                <input type="text" name="angle_anilox" class="form-control" value="{{ $spec->angle_anilox }}">
                            </div>
                            <div class="form-group-item">
                                <label class="form-label">Project Status <span class="text-danger">*</span></label>
                                <select name="project_status" class="form-select" required>
                                    <option value="To Do" {{ $spec->project_status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                    <option value="Progress" {{ $spec->project_status == 'Progress' ? 'selected' : '' }}>Progress</option>
                                    <option value="Completed" {{ $spec->project_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-item mt-2">
                        <label class="form-label">Update Attachment File (1 File Utama untuk {{ $task->item_code }})</label>
                        <input type="file" name="main_design_attachment" class="form-control" accept="image/*,.pdf,.ai,.psd,.zip">
                    </div>

                    <div class="form-group-item mt-2">
                        <label class="form-label">Remarks / Special Notes</label>
                        <textarea name="remarks" class="form-control" rows="2">{{ $spec->remarks }}</textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold">Update Spec</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. ALERT SUKSES DARI SESSION LARAVEL (EDIT, DELETE, STORE)
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2500,
            showConfirmButton: false,
            timerProgressBar: true
        });
    @endif

    // 2. KONFIRMASI DELETE SWEETALERT2
    function confirmDelete(id, sequence) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to delete Sequence #" + sequence + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // 3. LIVE IMAGE PREVIEW SCRIPT
    document.addEventListener('DOMContentLoaded', function() {
        const attachmentInput = document.getElementById('attachmentInput');
        if(attachmentInput) {
            attachmentInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const previewImage = document.getElementById('imagePreview');
                const placeholderIcon = document.getElementById('placeholderIcon');
                const placeholderText = document.getElementById('placeholderText');

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        if(placeholderIcon) placeholderIcon.style.display = 'none';
                        if(placeholderText) placeholderText.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.style.display = 'none';
                    if(placeholderIcon) placeholderIcon.style.display = 'block';
                    if(placeholderText) {
                        placeholderText.style.display = 'block';
                        if (file) {
                            placeholderText.innerText = "File (" + file.name.split('.').pop().toUpperCase() + ") dipilih";
                        } else {
                            placeholderText.innerText = "Pilih foto untuk preview";
                        }
                    }
                }
            });
        }
    });

    // 4. FUNCTION EXPORT TABLE TO CSV
    function exportTableToCSV(filename) {
        const table = document.getElementById("specsTable");
        const rows = table.querySelectorAll("tr");
        let csv = [];

        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll("td, th");

            for (let j = 0; j < cols.length - 1; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                data = '"' + data.replace(/"/g, '""') + '"';
                row.push(data);
            }

            csv.push(row.join(","));
        }

        const csvFile = new Blob(["\uFEFF" + csv.join("\n")], { type: "text/csv;charset=utf-8;" });
        const downloadLink = document.createElement("a");

        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endpush