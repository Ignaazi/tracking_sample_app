<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOB_ASSIGNMENT_{{ $item->item_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* SETTING A4 MARGIN: ATAS-BAWAH RAPAT (8mm), KIRI-KANAN RANGGANG/TIDAK LEBAR (12mm) */
        @page {
            size: A4 portrait;
            margin: 8mm 12mm;
        }

        * {
            font-family: 'Nunito', sans-serif !important;
            color: #000000 !important;
            box-sizing: border-box;
        }
        body { 
            background-color: #ffffff; 
            padding: 0;
            margin: 0;
            font-size: 10px;
            line-height: 1.25;
        }
        .doc-border { 
            border: 1.5px solid #000000; 
            padding: 16px 20px; 
            margin: 0 auto; 
            position: relative;
            width: 100%;
        }

        /* HIGHLIGHT HEADER PROJECT PALING ATAS */
        .project-highlight-box {
            border: 1.2px solid #000000;
            background-color: #ffffff;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 12px;
        }

        .table-custom {
            font-size: 9.5px !important;
            margin-bottom: 12px;
            border-collapse: collapse !important;
            width: 100%;
        }
        .table-custom th {
            background-color: #f8fafc !important;
            font-weight: 800;
            width: 22%;
            padding: 4.5px 8px !important; /* Padding vertikal ditambah biar panjang ke bawah */
            border: 1px solid #000000 !important;
            vertical-align: middle;
        }
        .table-custom td {
            padding: 4.5px 8px !important; /* Padding vertikal ditambah biar panjang ke bawah */
            border: 1px solid #000000 !important;
            vertical-align: middle;
        }
        .section-header {
            background-color: #eeeeee !important;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.4px;
            border: 1px solid #000000 !important;
            padding: 4px 8px !important;
        }
        
        .sign-space { 
            height: 68px; /* Ditinggikan agar stempel mengisi ruang bawah halaman */
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* STEMPEL MERAH RESMI */
        .red-official-stamp {
            border: 2.5px double #dc2626 !important;
            background-color: #ffffff !important;
            color: #dc2626 !important;
            padding: 6px 10px;
            border-radius: 2px;
            text-align: center;
            width: 88%;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .red-official-stamp * {
            color: #dc2626 !important;
        }

        /* STEMPEL PENDING (DASHED GRAY) */
        .stamp-box-pending {
            border: 1.5px dashed #666666 !important;
            background-color: #ffffff !important;
            color: #666666 !important;
            padding: 8px;
            border-radius: 4px;
            text-align: center;
            width: 88%;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.4px;
        }

        .stamp-box-pending * {
            color: #666666 !important;
        }

        .stamp-text-bold {
            font-size: 11.5px;
            font-weight: 900;
            letter-spacing: 1px;
            border-bottom: 1px solid #dc2626;
            padding-bottom: 1.5px;
            margin-bottom: 1.5px;
            display: block;
        }

        .stamp-text-date {
            font-size: 8.5px;
            font-weight: 800;
            letter-spacing: 0.4px;
            display: block;
        }

        .qr-code-img {
            width: 56px;
            height: 56px;
            border: 1px solid #000000;
            padding: 1px;
            background: #ffffff;
        }

        @media print {
            .no-print { display: none !important; }
            html, body {
                width: 100%;
                height: 100%;
                background: #fff;
            }
            .container, .container-fluid {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .doc-border { 
                border: 1.5px solid #000 !important; 
                padding: 14px 18px !important; 
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- CONTROLLER TOMBOL CETAK MANUAL -->
    <div class="container-fluid my-1 no-print text-center">
        <div class="alert alert-dark d-inline-block shadow-sm py-1 px-3 mb-0" style="background-color: #f8fafc; font-size: 11px;">
            Kotak dialog cetak terbuka otomatis. Jika batal, klik tombol ini:
            <button onclick="window.print()" class="btn btn-dark btn-sm ms-2 fw-bold" style="font-size: 10.5px;">Cetak Dokumen</button>
        </div>
    </div>

    <div class="container my-0 px-2">
        <div class="doc-border">
            
            <!-- HEADER LOGO PT AMCOR, JUDUL DOKUMEN & GENERATED QR CODE -->
            <div class="row align-items-center mb-2 pb-2 border-bottom border-1.5 border-dark">
                <div class="col-2">
                    <img src="{{ asset('logo1.png') }}" alt="Amcor Logo" style="height: 40px; object-fit: contain;">
                </div>
                <div class="col-8 text-center">
                    <h4 class="m-0 style-title fw-black text-uppercase tracking-wide" style="font-size: 15px; font-weight: 900;">ENTERPRISE OPERATIONS DEPLOYMENT SHEET</h4>
                    <small class="font-monospace fw-bold" style="font-size: 9.5px;">
                        Document Ref: {{ $item->doc_number ?? 'REQ-ASSIGN/'.date('Y').'/'.sprintf('%04d', $item->id) }}
                    </small>
                </div>
                <!-- GENERATE QR CODE BERDASARKAN KODE DATABASE -->
                <div class="col-2 text-end">
                    @php
                        $qrValue = $item->qr_code ?? ('REQ-ASSIGN-'.$item->item_code.'-'.$item->id);
                        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($qrValue) . "&size=85&margin=1";
                    @endphp
                    <img src="{{ $qrUrl }}" alt="Doc Verification QR Code" class="qr-code-img" title="Scan to Verify: {{ $qrValue }}">
                </div>
            </div>

            <div class="text-center my-1.5">
                <h6 class="fw-black text-uppercase text-decoration-underline" style="letter-spacing: 0.4px; font-size: 11.5px; font-weight: 900; margin: 0;">PROJECT COMPONENT PRODUCTION ASSIGNMENT SHEET</h6>
            </div>

            <!-- HIGHLIGHT PROJECT PALING ATAS -->
            <div class="project-highlight-box">
                <div class="row align-items-center">
                    <div class="col-6 border-end border-dark">
                        <small class="text-uppercase fw-extrabold d-block" style="font-size: 8.5px;">PROJECT NAME / MODEL</small>
                        <h4 class="fw-black text-uppercase m-0" style="font-size: 15px; font-weight: 900;">{{ $item->project_name ?? '-' }}</h4>
                        <div class="font-monospace fw-black mt-0.5 d-block" style="font-size: 10.5px; font-weight: 900;">
                            ITEM CODE: {{ $item->item_code }}
                        </div>
                    </div>
                    <div class="col-6 ps-3">
                        <div class="row" style="font-size: 9.5px;">
                            <div class="col-6 mb-1">
                                <span class="d-block text-uppercase fw-bold" style="font-size: 8px;">CUSTOMER:</span>
                                <strong>{{ $item->customer ?? '-' }}</strong>
                            </div>
                            <div class="col-6 mb-1">
                                <span class="d-block text-uppercase fw-bold" style="font-size: 8px;">BRAND FAMILY:</span>
                                <strong>{{ $item->brand_family ?? '-' }}</strong>
                            </div>
                            <div class="col-6">
                                <span class="d-block text-uppercase fw-bold" style="font-size: 8px;">MARKET:</span>
                                <strong>{{ $item->market ?? '-' }}</strong>
                            </div>
                            <div class="col-6">
                                <span class="d-block text-uppercase fw-bold" style="font-size: 8px;">DEV STATUS:</span>
                                <strong class="text-uppercase">{{ $item->development_status ?? 'Active' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="mb-2" style="font-size: 9px; line-height: 1.3;">
                Diberitahukan kepada seluruh jajaran divisi terkait, bahwa seluruh aset spesifikasi teknik komponen project yang terdaftar di bawah ini telah diverifikasi penuh dan disetujui untuk didistribusikan ke workstation lapangan:
            </p>

            <!-- TABEL DATA LENGKAP TASK (ALL FIELDS) -->
            <table class="table table-bordered table-custom align-middle">
                <!-- SECTION 1: GENERAL PROJECT & CLIENT INFO -->
                <tr>
                    <td colspan="4" class="section-header">1. General Project & Client Information</td>
                </tr>
                <tr>
                    <th>Task No</th>
                    <td>{{ $item->no ?? '-' }}</td>
                    <th>Item Code</th>
                    <td class="fw-bold font-monospace">{{ $item->item_code }}</td>
                </tr>
                <tr>
                    <th>Project Name</th>
                    <td class="fw-bold">{{ $item->project_name ?? '-' }}</td>
                    <th>Customer</th>
                    <td>{{ $item->customer ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Brand Family</th>
                    <td>{{ $item->brand_family ?? '-' }}</td>
                    <th>Market</th>
                    <td>{{ $item->market ?? '-' }}</td>
                </tr>
                <tr>
                    <th>ASCIS PD</th>
                    <td>{{ $item->ascis_pd ?? '-' }}</td>
                    <th>CS Brand</th>
                    <td>{{ $item->cs_brand ?? '-' }}</td>
                </tr>
                <tr>
                    <th>CS HW / CPI HW</th>
                    <td>{{ $item->cs_hw ?? '-' }} / {{ $item->cpi_hw ?? '-' }}</td>
                    <th>GHW Set / S5 Internal</th>
                    <td>{{ $item->ghw_set ?? '-' }} / {{ $item->s5_internal_approval ?? '-' }}</td>
                </tr>

                <!-- SECTION 2: DATES & REFERENCE CODES -->
                <tr>
                    <td colspan="4" class="section-header">2. Timeline Dates & Reference Numbers</td>
                </tr>
                <tr>
                    <th>Info Received Date</th>
                    <td>{{ $item->information_received ? \Carbon\Carbon::parse($item->information_received)->format('d/m/Y') : '-' }}</td>
                    <th>PLM Released Date</th>
                    <td>{{ $item->plm_released ? \Carbon\Carbon::parse($item->plm_released)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Green Light Date</th>
                    <td>{{ $item->green_light ? \Carbon\Carbon::parse($item->green_light)->format('d/m/Y') : '-' }}</td>
                    <th>COI Number</th>
                    <td class="font-monospace">{{ $item->coi_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>SAP Number</th>
                    <td class="font-monospace fw-bold">{{ $item->sap_number ?? '-' }}</td>
                    <th>Technical Doc (TD)</th>
                    <td>{{ $item->td ?? '-' }}</td>
                </tr>

                <!-- SECTION 3: TECHNICAL & MACHINE SPECIFICATIONS -->
                <tr>
                    <td colspan="4" class="section-header">3. Technical & Machine Specifications</td>
                </tr>
                <tr>
                    <th>Machine Line</th>
                    <td>{{ $item->machine ?? '-' }}</td>
                    <th>Die Cut Number</th>
                    <td class="fw-bold">{{ $item->die_cut_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Board / Type CM</th>
                    <td>{{ $item->board ?? '-' }} / {{ $item->type_cm ?? '-' }}</td>
                    <th>Board Codes (U / A)</th>
                    <td>{{ $item->board_u_code ?? '-' }} / {{ $item->board_a_code ?? '-' }}</td>
                </tr>
                <tr>
                    <th>S10 / S11 / S12 Numbers</th>
                    <td colspan="3">
                        S10: <strong>{{ $item->s10_number ?? '-' }}</strong> | 
                        S11: <strong>{{ $item->s11_number ?? '-' }}</strong> | 
                        S12: <strong>{{ $item->s12_number ?? '-' }}</strong>
                    </td>
                </tr>

                <!-- SECTION 4: CYLINDER, REPRO & INK SYSTEM -->
                <tr>
                    <td colspan="4" class="section-header">4. Cylinder, Repro & Ink System</td>
                </tr>
                <tr>
                    <th>Cylinder Supplier</th>
                    <td>{{ $item->cylinder_supplier ?? '-' }}</td>
                    <th>Repro By</th>
                    <td>{{ $item->repro_by ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Sequence / Colour</th>
                    <td>{{ $item->sequence_seq ?? '-' }} / {{ $item->colour ?? '-' }}</td>
                    <th>Baan Cylinder</th>
                    <td>{{ $item->baan_cylinder ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Film Number</th>
                    <td>{{ $item->film_number ?? '-' }}</td>
                    <th>Ink System / Supplier</th>
                    <td>{{ $item->ink_system ?? '-' }} / {{ $item->supplier_ink ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Ink Code / Baan Ink Code</th>
                    <td>{{ $item->ink_code ?? '-' }} / {{ $item->baan_ink_code ?? '-' }}</td>
                    <th>Coverage / Usage</th>
                    <td>
                        Coverage: {{ $item->coverage_percent ? $item->coverage_percent.'%' : '-' }} | 
                        Usage: {{ $item->usage_kg_th ? $item->usage_kg_th.' kg' : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Angle Anilox</th>
                    <td>{{ $item->angle_anilox ?? '-' }}</td>
                    <th>Remark</th>
                    <td>{{ $item->remark ?? '-' }}</td>
                </tr>

                <!-- SECTION 5: PIPELINE STATUS & VERIFICATION -->
                <tr>
                    <td colspan="4" class="section-header">5. Operational Status Workflow & Verification</td>
                </tr>
                <tr>
                    <th>Development / Status</th>
                    <td><span class="fw-bold">{{ $item->development_status ?? 'Active' }}</span> ({{ strtoupper($item->status) }})</td>
                    <th>Layout / Baan Status</th>
                    <td>Layout: {{ $item->layout_status }} | Baan: {{ $item->baan_status }}</td>
                </tr>
                <tr>
                    <th>PROMP / Job Bag Status</th>
                    <td>PROMP: {{ $item->promp_status }} | Job Bag: {{ $item->job_bag_status }}</td>
                    <th>QR Digital Security Code</th>
                    <td class="font-monospace fw-bold" style="font-size: 9px;">{{ $item->qr_code ?? 'GEN-VERIFIED-'.$item->id }}</td>
                </tr>
            </table>

            <p class="my-1.5" style="font-size: 9px;">
                Demikian surat penugasan spesifikasi aset instrumen ini dicetak agar dapat dipergunakan sebagaimana mestinya untuk menunjang kelancaran operasional produksi PT Amcor.
            </p>

            <!-- 3-TIER RED STAMP BLOCK (PREPARED, CHECKED, APPROVED) -->
            <div class="row pt-1 text-center" style="font-size: 9.5px;">
                
                <!-- 1. PREPARED BY (PD) -->
                <div class="col-4">
                    <p class="mb-1 fw-bold">Prepared By (PD),</p>
                    <div class="sign-space my-1">
                        @if($item->pd_prepared_at)
                            <div class="red-official-stamp">
                                <span class="stamp-text-bold">PREPARED</span>
                                <span class="stamp-text-date">{{ \Carbon\Carbon::parse($item->pd_prepared_at)->format('d M Y') }}</span>
                            </div>
                        @else
                            <div class="stamp-box-pending">
                                PENDING SIGNATURE
                            </div>
                        @endif
                    </div>
                    <p class="mt-1.5 mb-0 fw-bold text-decoration-underline">{{ $item->pdUser->name ?? 'Project Development' }}</p>
                    <p class="font-monospace mb-0" style="font-size: 8.5px;">NIK: {{ $item->pdUser->nik ?? '-' }}</p>
                </div>

                <!-- 2. CHECKED BY (QA) -->
                <div class="col-4">
                    <p class="mb-1 fw-bold">Checked By (QA),</p>
                    <div class="sign-space my-1">
                        @if($item->qa_checked_at)
                            <div class="red-official-stamp">
                                <span class="stamp-text-bold">CHECKED</span>
                                <span class="stamp-text-date">{{ \Carbon\Carbon::parse($item->qa_checked_at)->format('d M Y') }}</span>
                            </div>
                        @else
                            <div class="stamp-box-pending">
                                PENDING SIGNATURE
                            </div>
                        @endif
                    </div>
                    <p class="mt-1.5 mb-0 fw-bold text-decoration-underline">{{ $item->qaUser->name ?? 'Quality Assurance' }}</p>
                    <p class="font-monospace mb-0" style="font-size: 8.5px;">NIK: {{ $item->qaUser->nik ?? '-' }}</p>
                </div>

                <!-- 3. APPROVED BY (PLANNER) -->
                <div class="col-4">
                    <p class="mb-1 fw-bold">Approved By (PLANNER),</p>
                    <div class="sign-space my-1">
                        @if($item->planner_approved_at)
                            <div class="red-official-stamp">
                                <span class="stamp-text-bold">APPROVED</span>
                                <span class="stamp-text-date">{{ \Carbon\Carbon::parse($item->planner_approved_at)->format('d M Y') }}</span>
                            </div>
                        @else
                            <div class="stamp-box-pending">
                                PENDING SIGNATURE
                            </div>
                        @endif
                    </div>
                    <p class="mt-1.5 mb-0 fw-bold text-decoration-underline">{{ $item->plannerUser->name ?? 'Production Planner' }}</p>
                    <p class="font-monospace mb-0" style="font-size: 8.5px;">NIK: {{ $item->plannerUser->nik ?? '-' }}</p>
                </div>

            </div>

        </div>
    </div>

</body>
</html>