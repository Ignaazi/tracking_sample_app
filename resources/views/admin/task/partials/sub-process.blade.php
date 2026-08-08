@extends('layouts.admin')

@section('title', 'Sub-Process Input - ' . $task->project_name)

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .sub-process-container, .sub-process-container * {
            font-family: 'Nunito', 'Segoe UI', sans-serif !important;
        }
        .sub-process-container {
            background-color: #f6f9ff;
            min-height: 100vh;
        }
        .type-pill {
            font-size: 13px;
            font-weight: 700;
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .type-pill.active {
            background-color: #4154f1;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(65, 84, 241, 0.3);
        }
        .type-pill.inactive {
            background-color: #e2e8f0;
            color: #475569 !important;
        }
        .type-pill.inactive:hover {
            background-color: #cbd5e1;
        }

        /* LOGO STYLING */
        .company-logo {
            max-height: 48px;
            width: auto;
            object-fit: contain;
        }

        /* --- STYLES KHUSUS PRINT DOKUMEN A4 --- */
        @media print {
            #header, #sidebar, .header, .sidebar, .no-print, .btn, nav, .type-pill {
                display: none !important;
            }
            body, .sub-process-container {
                background-color: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .card {
                border: 1px solid #1e293b !important;
                box-shadow: none !important;
                margin-bottom: 12px !important;
            }
            .print-header {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                border-bottom: 2px solid #0f172a;
                padding-bottom: 10px;
                margin-bottom: 15px;
            }
            .print-table {
                width: 100%;
                border-collapse: collapse;
            }
            .print-table th, .print-table td {
                border: 1px solid #94a3b8;
                padding: 6px 10px;
                font-size: 11px !important;
            }
            .print-table th {
                background-color: #f1f5f9 !important;
                color: #0f172a !important;
                font-weight: bold;
            }
            .sign-box {
                height: 55px;
                border-bottom: 1px dashed #64748b;
            }
            .company-logo-print {
                max-height: 50px;
                width: auto;
            }
        }
        .print-header { display: none; }
    </style>
@endpush

@section('content')
<div class="container-fluid py-4 sub-process-container">

    <!-- TOP NAV & ACTION BUTTONS -->
    <div class="d-flex align-items-center justify-content-between mb-3 no-print">
        <div>
            <a href="{{ route('admin.task.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3 fw-bold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Workspace
            </a>
        </div>
        <div class="d-flex gap-2">
            <!-- LINK MEMBUKA PREVIEW CETAK DOKUMEN A4 DI TAB BARU -->
            <a href="{{ route('admin.task.previewSubProcess', ['id' => $task->id, 'type' => $type]) }}" target="_blank" class="btn btn-sm btn-dark rounded-2 px-3 fw-bold shadow-sm">
                <i class="bi bi-printer-fill me-1.5"></i> Cetak Form A4
            </a>
        </div>
    </div>

    <!-- HEADER KHUSUS CETAK DOKUMEN FISIK (HANYA MUNCUL SAAT PRINT DIRECT) -->
    <div class="print-header">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('logo1.png') }}" alt="Logo PT" class="company-logo-print">
            <div>
                <h4 class="fw-bold mb-0 text-uppercase">LEMBAR INSTRUCTION JOB BAG</h4>
                <small class="text-muted">Tahap Sub-Proses: <strong>{{ strtoupper($currentTypeInfo['title']) }}</strong></small>
            </div>
        </div>
        <div class="text-end">
            <div class="fw-bold fs-6">ITEM: {{ $task->item_code }}</div>
            <small class="text-muted">Tgl Cetak: {{ date('d/m/Y H:i') }}</small>
        </div>
    </div>

    <!-- TAB NAVIGASI TIPE SUB-PROSES (WITH COMPANY LOGO) -->
    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-4 no-print">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <!-- LOGO PT DI TAMPILAN WEB -->
                <img src="{{ asset('logo1.png') }}" alt="Logo PT" class="company-logo me-2">
                <div>
                    <h4 class="fw-bold text-dark mb-1">
                        {{ $task->project_name }} 
                        <span class="badge bg-primary bg-opacity-10 text-primary ms-2 fs-6">
                            <i class="bi {{ $currentTypeInfo['icon'] }} me-1"></i> {{ $currentTypeInfo['short'] }} Mode
                        </span>
                    </h4>
                    <p class="text-muted small mb-0">
                        Item Code: <strong class="text-dark">{{ $task->item_code }}</strong> | Customer: <strong class="text-dark">{{ $task->customer }}</strong>
                    </p>
                </div>
            </div>

            <!-- BUTTON PINDAH MODUL SUB-PROSES -->
            <div class="d-flex flex-wrap gap-2">
                @foreach($subTypes as $key => $sub)
                    <a href="{{ route('admin.task.subProcess', ['id' => $task->id, 'type' => $key]) }}" 
                       class="type-pill {{ $type == $key ? 'active' : 'inactive' }}">
                        <i class="bi {{ $sub['icon'] }}"></i> {{ $sub['short'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- FORM UTAMA -->
    <form action="{{ route('admin.task.updateSubProcess', ['id' => $task->id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="row g-4">
            
            <!-- KOLOM KIRI: FORM PENGISIAN DEDIKASI PER TIPE SUB-PROSES -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                    
                    <!-- ==================== 1. FORM KHUSUS LAYOUT ==================== -->
                    @if($type == 'layout')
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-layers-half me-1"></i> FORM PENGISIAN SPECIFICATION LAYOUT
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Ukuran Dieline (PxL mm)</label>
                                <input type="text" class="form-control form-control-sm" name="layout_dieline" placeholder="Contoh: 120 x 250 mm">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Bleed Area (mm)</label>
                                <input type="text" class="form-control form-control-sm" name="layout_bleed" placeholder="Contoh: 3 mm">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Unwinding Direction / Arah Gulungan</label>
                                <select class="form-select form-select-sm" name="layout_unwinding">
                                    <option value="Head First">Head First (Top)</option>
                                    <option value="Foot First">Foot First (Bottom)</option>
                                    <option value="Left First">Left First</option>
                                    <option value="Right First">Right First</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Posisi Eye Mark / Sensor</label>
                                <input type="text" class="form-control form-control-sm" name="layout_eyemark" placeholder="Contoh: Kiri Bawah">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Catatan Desain & Posisi Barcode</label>
                                <textarea class="form-control form-control-sm" rows="3" name="layout_notes" placeholder="Catatan khusus mengenai layout teknis..."></textarea>
                            </div>
                        </div>

                    <!-- ==================== 2. FORM KHUSUS BAAN ERP ==================== -->
                    @elseif($type == 'baan')
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-cpu-fill me-1"></i> FORM INPUT MAPPING ERP BAAN / INFOR LN
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Kode BOM Master</label>
                                <input type="text" class="form-control form-control-sm" name="baan_bom" placeholder="Input Kode BOM BaaN">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Item Code Material Utama</label>
                                <input type="text" class="form-control form-control-sm" name="baan_material_code" value="{{ $task->board_u_code ?? '' }}" placeholder="Kode Bahan Baku">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Kode Routing Mesin Produksi</label>
                                <input type="text" class="form-control form-control-sm" name="baan_routing" value="{{ $task->machine ?? '' }}" placeholder="Contoh: ROT-01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">BaaN Ink Code Standard</label>
                                <input type="text" class="form-control form-control-sm" name="baan_ink" value="{{ $task->baan_ink_code ?? '' }}" placeholder="Kode Tinta ERP">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Status Verifikasi ERP</label>
                                <input type="text" class="form-control form-control-sm" name="baan_status_erp" placeholder="Status Rilis Sistem BaaN">
                            </div>
                        </div>

                    <!-- ==================== 3. FORM KHUSUS PROMPT ==================== -->
                    @elseif($type == 'promp')
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-terminal-fill me-1"></i> FORM VERIFIKASI PROMPT & QUALITY ASSURANCE
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Color Sequence (Urutan Warna Cetak)</label>
                                <input type="text" class="form-control form-control-sm" name="promp_color_seq" value="{{ $task->sequence_seq ?? '' }}" placeholder="Contoh: K-C-M-Y-White">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Standard Target Delta E (ΔE)</label>
                                <input type="text" class="form-control form-control-sm" name="promp_delta_e" placeholder="Contoh: < 2.0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Hasil Verifikasi Scan Barcode</label>
                                <select class="form-select form-select-sm" name="promp_barcode_check">
                                    <option value="Grade A">Grade A (Lolos Scan)</option>
                                    <option value="Grade B">Grade B (Perlu Penyesuaian)</option>
                                    <option value="Failed">Failed (Tidak Terbaca)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Uji Daya Rekat Ink / Lamination Test</label>
                                <input type="text" class="form-control form-control-sm" name="promp_adhesion" placeholder="Contoh: Tape Test Pass 100%">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Catatan Verifikasi QC Pre-press</label>
                                <textarea class="form-control form-control-sm" rows="3" name="promp_qc_notes" placeholder="Catatan hasil proofing warna & QC..."></textarea>
                            </div>
                        </div>

                    <!-- ==================== 4. FORM KHUSUS JOB BAG ==================== -->
                    @else
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-briefcase-fill me-1"></i> CHECKSHEET PELEPASAN DOKUMEN JOB BAG PRODUKSI
                        </h6>
                        <table class="print-table mb-3">
                            <thead>
                                <tr>
                                    <th style="width: 5%;" class="text-center">No</th>
                                    <th style="width: 65%;">Item Kelengkapan Berkas Fisik Job Bag</th>
                                    <th style="width: 30%;" class="text-center">Status Berkas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Dokumen Proofing / Color Chip Terakhir yang di-ACC Customer</td>
                                    <td class="text-center"><input type="checkbox" checked> Ada & Lolos ACC</td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Layout Dieline Teknis Pisau / Cylinder Set ID Registration</td>
                                    <td class="text-center"><input type="checkbox" checked> Ada & Lolos ACC</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>ERP BaaN Work Order & Master BOM Released</td>
                                    <td class="text-center"><input type="checkbox" checked> Ada & Lolos ACC</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Sampel Standard Warna Fisik / Color Target Master</td>
                                    <td class="text-center"><input type="checkbox"> Ada & Lolos ACC</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                </div>

                <!-- TABLE SPEK RINGKASAN PRODUCT (TETAP TAMPIL UNTUK ACUAN OPERATOR) -->
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-secondary mb-3 small text-uppercase">Ringkasan Data Teknis Proyek</h6>
                    <table class="print-table">
                        <tbody>
                            <tr>
                                <th style="width: 20%;">Project Name</th>
                                <td style="width: 30%;">{{ $task->project_name }}</td>
                                <th style="width: 20%;">Customer</th>
                                <td style="width: 30%;">{{ $task->customer }}</td>
                            </tr>
                            <tr>
                                <th>Item Code</th>
                                <td class="fw-bold text-primary">{{ $task->item_code }}</td>
                                <th>SAP Number</th>
                                <td>{{ $task->sap_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mesin Target</th>
                                <td>{{ $task->machine ?? '-' }}</td>
                                <th>Jenis Board/Bahan</th>
                                <td>{{ $task->board ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- KOLOM KANAN: STATUS SELECT, PIC & TANDA TANGAN -->
            <div class="col-lg-4">
                
                <!-- STATUS SUB-PROSES SELECT -->
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="bi bi-diagram-3-fill me-1"></i> STATUS SUB-PROSES
                    </h6>

                    <div class="no-print">
                        <label class="form-label small fw-bold text-muted">Update Status {{ $currentTypeInfo['short'] }}:</label>
                        <select name="status" class="form-select fw-bold text-dark mb-3" required>
                            <option value="To Do" {{ $currentStatus == 'To Do' ? 'selected' : '' }}>To Do (Draft)</option>
                            <option value="In Progress" {{ $currentStatus == 'In Progress' ? 'selected' : '' }}>In Progress (Pengerjaan)</option>
                            <option value="Completed" {{ $currentStatus == 'Completed' ? 'selected' : '' }}>Completed (ACC / Selesai)</option>
                        </select>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">PIC Pengisi / Designer:</label>
                            <div class="p-2 bg-light rounded text-dark fw-bold small">
                                <i class="bi bi-person-fill text-primary me-1"></i> {{ $task->ascis_pd ?? 'Belum Ditentukan' }}
                            </div>
                        </div>

                        <div class="d-grid gap-2 border-top pt-3">
                            <button type="submit" class="btn btn-primary fw-bold" style="background-color: #4154f1; border: none;">
                                <i class="bi bi-floppy me-1"></i> Simpan Data {{ $currentTypeInfo['short'] }}
                            </button>
                        </div>
                    </div>

                    <!-- Tampilan Status Saat Hasil Cetak Kertas -->
                    <div class="d-none d-print-block">
                        <p class="mb-1 small">Status Modul: <strong>{{ strtoupper($currentStatus) }}</strong></p>
                        <p class="mb-0 small">Operator/PIC: <strong>{{ $task->ascis_pd ?? '________________' }}</strong></p>
                    </div>
                </div>

                <!-- KOTAK TANDA TANGAN CETAK -->
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                    <h6 class="fw-bold text-primary mb-3 text-center">APPROVAL FISIK</h6>
                    <table class="print-table text-center" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 33%;">Dibuat</th>
                                <th style="width: 33%;">Diperiksa</th>
                                <th style="width: 34%;">Disetujui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="sign-box"></div>
                                    <small class="text-muted">( Operator )</small>
                                </td>
                                <td>
                                    <div class="sign-box"></div>
                                    <small class="text-muted">( Spv / QA )</small>
                                </td>
                                <td>
                                    <div class="sign-box"></div>
                                    <small class="text-muted">( Produksi )</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </form>

</div>
@endsection