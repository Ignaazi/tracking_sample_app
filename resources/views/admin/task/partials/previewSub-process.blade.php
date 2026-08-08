<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Job Sheet - {{ $task->item_code }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            font-size: 12px;
        }

        .paper-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 20px auto;
            background: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .company-logo {
            max-height: 55px;
            width: auto;
            object-fit: contain;
        }

        .table-print {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .table-print th, .table-print td {
            border: 1px solid #64748b;
            padding: 6px 10px;
            font-size: 11px;
        }

        .table-print th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10.5px;
        }

        .sign-box {
            height: 65px;
            border-bottom: 1px dashed #94a3b8;
        }

        /* STYLING UNTUK MODE PRINTER / PDF */
        @media print {
            body {
                background: #ffffff !important;
            }
            .paper-a4 {
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4 portrait;
                margin: 12mm;
            }
        }
    </style>
</head>
<body>

    <!-- BAR NAVIGASI CETAK (TIDAK TAMPIL SAAT DI-PRINT) -->
    <div class="container no-print mt-3 mb-1" style="max-width: 210mm;">
        <div class="d-flex align-items-center justify-content-between p-3 bg-white rounded shadow-sm border">
            <div>
                <a href="{{ route('admin.task.subProcess', ['id' => $task->id, 'type' => $type]) }}" class="btn btn-sm btn-outline-secondary fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Form Sub-Process
                </a>
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-sm btn-dark fw-bold px-3">
                    <i class="bi bi-printer-fill me-1.5"></i> Cetak Dokumen (A4)
                </button>
            </div>
        </div>
    </div>

    <!-- Halaman Kertas A4 Fisik -->
    <div class="paper-a4">
        
        <!-- HEADER FORMULARIS PERUSAHAAN -->
        <div class="d-flex align-items-center justify-content-between border-bottom border-2 border-dark pb-3 mb-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('logo1.png') }}" alt="Logo PT" class="company-logo">
                <div>
                    <h4 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 0.5px;">JOB BAG INSTRUCTION SHEET</h4>
                    <span class="badge bg-dark text-white font-monospace">SUB-PROCESS: {{ strtoupper($currentTypeInfo['title']) }}</span>
                </div>
            </div>
            <div class="text-end">
                <div class="fw-bold fs-6 text-primary">{{ $task->item_code }}</div>
                <div class="text-muted small">Tgl Cetak: {{ date('d/m/Y H:i') }}</div>
            </div>
        </div>

        <!-- SPEK UMUM PRODUCT -->
        <div class="mb-3">
            <h6 class="fw-bold text-uppercase small mb-2 text-secondary"><i class="bi bi-info-circle-fill me-1"></i> General Product Specifications</h6>
            <table class="table-print">
                <tbody>
                    <tr>
                        <th style="width: 18%;">Project Name</th>
                        <td style="width: 32%;">{{ $task->project_name }}</td>
                        <th style="width: 18%;">Customer</th>
                        <td style="width: 32%;">{{ $task->customer }}</td>
                    </tr>
                    <tr>
                        <th>Item Code</th>
                        <td class="fw-bold text-primary">{{ $task->item_code }}</td>
                        <th>SAP Number</th>
                        <td>{{ $task->sap_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Market / Region</th>
                        <td>{{ $task->market ?? 'INDO' }}</td>
                        <th>Brand / Family</th>
                        <td>{{ $task->brand_family ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Target Mesin</th>
                        <td>{{ $task->machine ?? '-' }}</td>
                        <th>Jenis Material / Board</th>
                        <td>{{ $task->board ?? '-' }} ({{ $task->board_u_code ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th>Cylinder Supplier</th>
                        <td>{{ $task->cylinder_supplier ?? '-' }}</td>
                        <th>Ink Code / System</th>
                        <td>{{ $task->ink_code ?? '-' }} ({{ $task->ink_system ?? '-' }})</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- DETAIL SPESIFIK TAHAP SUB-PROSES -->
        <div class="mb-3">
            <h6 class="fw-bold text-uppercase small mb-2 text-secondary"><i class="bi bi-sliders me-1"></i> Technical Detail Parameter ({{ $currentTypeInfo['short'] }})</h6>
            
            <table class="table-print">
                @if($type == 'layout')
                    <tr>
                        <th style="width: 25%;">Ukuran Dieline</th>
                        <td style="width: 25%;">{{ $task->dieline_size ?? '120 x 250 mm' }}</td>
                        <th style="width: 25%;">Bleed Area</th>
                        <td style="width: 25%;">{{ $task->bleed ?? '3 mm' }}</td>
                    </tr>
                    <tr>
                        <th>Unwinding Direction</th>
                        <td>Head First (Top)</td>
                        <th>Posisi Sensor/Eyemark</th>
                        <td>Kiri Bawah</td>
                    </tr>
                @elseif($type == 'baan')
                    <tr>
                        <th style="width: 25%;">Kode Master BOM</th>
                        <td style="width: 25%;">BOM-{{ $task->item_code }}</td>
                        <th style="width: 25%;">Material Item Code</th>
                        <td style="width: 25%;">{{ $task->board_u_code ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Routing Mesin</th>
                        <td>{{ $task->machine ?? 'ROT-01' }}</td>
                        <th>ERP Ink Code Standard</th>
                        <td>{{ $task->baan_ink_code ?? '-' }}</td>
                    </tr>
                @elseif($type == 'promp')
                    <tr>
                        <th style="width: 25%;">Color Sequence</th>
                        <td style="width: 25%;">{{ $task->sequence_seq ?? 'K-C-M-Y-White' }}</td>
                        <th style="width: 25%;">Standard Target ΔE</th>
                        <td style="width: 25%;">< 2.0</td>
                    </tr>
                    <tr>
                        <th>Scan Barcode Grade</th>
                        <td>Grade A (Pass)</td>
                        <th>Tape Test Adhesion</th>
                        <td>100% Pass</td>
                    </tr>
                @else
                    <tr>
                        <th style="width: 25%;">No. COI / Greenlight</th>
                        <td style="width: 25%;">{{ $task->coi_number ?? '-' }}</td>
                        <th style="width: 25%;">Die Cut Number</th>
                        <td style="width: 25%;">{{ $task->die_cut_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Proofing Release</th>
                        <td>Approved & Ready</td>
                        <th>ERP Work Order</th>
                        <td>Released</td>
                    </tr>
                @endif
            </table>
        </div>

        <!-- CHECKSHEET PELEPASAN FISIK -->
        <div class="mb-3">
            <h6 class="fw-bold text-uppercase small mb-2 text-secondary"><i class="bi bi-check2-square me-1"></i> Quality & Pre-Press Physical Checksheet</h6>
            <table class="table-print">
                <thead>
                    <tr>
                        <th style="width: 6%; text-align: center;">No</th>
                        <th style="width: 64%;">Parameters Standard Verification</th>
                        <th style="width: 15%; text-align: center;">Status</th>
                        <th style="width: 15%; text-align: center;">Sign</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Dieline, Bleed & Unwinding Direction Match Approved Layout</td>
                        <td class="text-center">[ OK ]</td>
                        <td class="text-center">_______</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Color Sequence & Barcode Scan Quality Pass Standard</td>
                        <td class="text-center">[ OK ]</td>
                        <td class="text-center">_______</td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Master BOM, ERP Item Code & Work Order Registered</td>
                        <td class="text-center">[ OK ]</td>
                        <td class="text-center">_______</td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>Physical Color Sample / Target Master Included in Job Bag Envelope</td>
                        <td class="text-center">[ OK ]</td>
                        <td class="text-center">_______</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-2 border rounded bg-light mb-4">
            <strong class="small text-uppercase">Technical Remark / Catatan Khusus:</strong>
            <p class="mb-0 small text-muted">{{ $task->remark ?? 'Pastikan seluruh parameter warna dan posisi die-cut telah sesuai dengan acuan cetak sebelum produksi jalan.' }}</p>
        </div>

        <!-- MATRIKS TANDA TANGAN APPROVAL -->
        <div>
            <h6 class="fw-bold text-uppercase small mb-2 text-center text-secondary">Physical Sign-Off Approval</h6>
            <table class="table-print text-center">
                <thead>
                    <tr>
                        <th style="width: 25%;">Dibuat Oleh</th>
                        <th style="width: 25%;">Verifikasi Pre-press</th>
                        <th style="width: 25%;">Diperiksa QA</th>
                        <th style="width: 25%;">ACC Produksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="sign-box"></div>
                            <small class="text-muted">( {{ $task->ascis_pd ?? 'Operator/Designer' }} )</small>
                        </td>
                        <td>
                            <div class="sign-box"></div>
                            <small class="text-muted">( Pre-press Spv )</small>
                        </td>
                        <td>
                            <div class="sign-box"></div>
                            <small class="text-muted">( QA Inspector )</small>
                        </td>
                        <td>
                            <div class="sign-box"></div>
                            <small class="text-muted">( Spv Produksi )</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>