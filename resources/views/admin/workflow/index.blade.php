@extends('layouts.admin')

@section('title', 'Workflow Engine Assignment')

@push('styles')
    <!-- CDN Bootstrap Icons & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* CSS DIBATASI KHUSUS UNTUK WORKFLOW CONTAINER AGAR SIDEBAR ICON TIDAK HILANG */
        .workflow-container, 
        .workflow-container div, 
        .workflow-container p, 
        .workflow-container span, 
        .workflow-container h1, 
        .workflow-container h5, 
        .workflow-container th, 
        .workflow-container td, 
        .workflow-container button, 
        .workflow-container a {
            font-family: 'Nunito', sans-serif !important;
        }

        /* HEADER TABEL BIRU & TEKS PUTIH */
        .table-blue-header th {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            font-size: 11.5px;
            letter-spacing: 0.5px;
            border: 1px solid #2563eb !important;
            vertical-align: middle !important;
            text-align: center !important;
            padding: 11px 8px !important;
        }

        /* GARIS KOTAK TEGAS UNTUK SETIAP SEL */
        .table-bordered-custom td {
            border: 1px solid #cbd5e1 !important;
            vertical-align: middle !important;
            text-align: center !important;
            padding: 10px 8px !important;
            font-size: 12.5px;
        }

        /* PIPELINE STEPPER INTEGRATED */
        .pipeline-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 4px 6px;
            gap: 6px;
        }

        .step-badge-node {
            font-size: 11px;
            padding: 5px 8px;
            border-radius: 4px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            line-height: 1;
            white-space: nowrap;
        }

        .step-node-pending { 
            background-color: #ffffff; 
            color: #64748b; 
            border: 1px solid #cbd5e1; 
        }

        .step-node-done { 
            background-color: #dcfce7; 
            color: #15803d; 
            border: 1px solid #86efac; 
        }

        /* TOMBOL ACTION KOTAK PRESISI */
        .btn-action-square {
            width: 34px;
            height: 34px;
            padding: 0;
            border-radius: 8px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            border: none !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            color: #ffffff !important;
            text-decoration: none;
        }

        .btn-action-square:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* VIBRANT GRADIENT COLORS */
        .btn-square-preview {
            background: linear-gradient(135deg, #00b4db, #0083b0) !important;
        }

        .btn-square-print {
            background: linear-gradient(135deg, #f89b29, #ff0e00) !important;
        }

        .btn-square-download {
            background: linear-gradient(135deg, #11998e, #38ef7d) !important;
        }

        /* BOX QR CODE DI TABEL (BARCODE CANVAS ASLI) */
        .qr-table-preview-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-block;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .qr-table-preview-btn:hover {
            border-color: #3b82f6;
            transform: scale(1.05);
            box-shadow: 0 3px 6px rgba(0,0,0,0.12);
        }

        .table-qr-canvas {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-qr-canvas canvas, .table-qr-canvas img {
            width: 100% !important;
            height: 100% !important;
        }

        /* POP-UP MODAL QR BERUKURAN BESAR & JELAS */
        .modal-qr-box {
            width: 260px;
            height: 260px;
            margin: 0 auto;
            padding: 12px;
            background: #ffffff;
            border: 2px solid #0f172a;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-qr-box canvas, .modal-qr-box img {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid p-4 workflow-container" style="background-color: #f8fafc; min-height: 100vh;">

    <!-- PAGETITLE -->
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark mb-1" style="font-size: 24px; color: #0f172a !important;">Job Bag Verifications</h1>
        <p class="text-secondary mb-0" style="font-size: 13px;">Finalized architecture specs asset mapping and enterprise assignment distribution sheets.</p>
    </div>

    <!-- NOTIFIKASI SUCCESS / ERROR -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- TABLE CARD -->
    <div class="card border-0 shadow-sm rounded-3 bg-white">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <h5 class="card-title m-0 fw-bold d-flex align-items-center gap-2" style="color: #012970; font-size: 15px;">
                <i class="bi bi-grid-3x3-gap-fill text-primary"></i>Ready to Assign Components
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-bordered-custom align-middle mb-0">
                    <thead class="table-blue-header">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Item Code</th>
                            <th>Project Name</th>
                            <th>Customer</th>
                            <th>Brand Family</th>
                            <th>Verification QR</th>
                            <th>Approval Pipeline (PD &rarr; QA &rarr; PLANNER)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($completedItems as $index => $item)
                        <tr>
                            <!-- 1. NOMOR URUT -->
                            <td class="fw-bold text-muted" style="font-size: 13px;">
                                {{ sprintf('%02d', $index + 1) }}
                            </td>

                            <!-- 2. ITEM CODE -->
                            <td>
                                <span class="badge bg-dark font-monospace px-2 py-1" style="font-size: 11px; border-radius: 4px;">{{ $item->item_code }}</span>
                            </td>

                            <!-- 3. PROJECT NAME -->
                            <td>
                                <span class="fw-black text-dark d-block" style="font-weight: 900;">{{ $item->project_name }}</span>
                            </td>

                            <!-- 4. CUSTOMER -->
                            <td>
                                <span class="fw-bold text-dark">{{ $item->customer ?? '-' }}</span>
                            </td>

                            <!-- 5. BRAND FAMILY -->
                            <td>
                                <span class="text-muted font-monospace" style="font-size: 11px;">{{ $item->brand_family ?? '-' }}</span>
                            </td>

                            <!-- 6. VERIFICATION QR CODE MINI (OTOMATIS SESUAI APP_URL / NGROK DI .ENV) -->
                            <td>
                                @php
                                    // Menggunakan config('app.url') agar otomatis ikut NGROK / Domain Publik
                                    $baseUrl = rtrim(config('app.url'), '/');
                                    $routePath = route('admin.workflow.printPdf', $item->id, false);

                                    // URL QR Code hasil gabungan Ngrok + Path
                                    $qrPreviewUrl = "{$baseUrl}{$routePath}";
                                    $docNum = $item->doc_number ?? 'REQ-ASSIGN/'.date('Y').'/'.sprintf('%04d', $item->id);
                                @endphp
                                
                                <div class="qr-table-preview-btn" data-bs-toggle="modal" data-bs-target="#qrModal-{{ $item->id }}" title="Klik untuk memperbesar QR Verifikasi">
                                    <div class="table-qr-canvas" id="qr-table-mini-{{ $item->id }}" data-qr-value="{{ $qrPreviewUrl }}">
                                        <!-- JS RENDER MINI QR -->
                                    </div>
                                </div>

                                <!-- MODAL POPUP PREVIEW BESAR -->
                                <div class="modal fade" id="qrModal-{{ $item->id }}" tabindex="-1" aria-labelledby="qrModalLabel-{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content rounded-4 border-0 shadow-lg">
                                            <div class="modal-header border-bottom pb-3">
                                                <h5 class="modal-title fw-extrabold text-dark d-flex align-items-center gap-2" id="qrModalLabel-{{ $item->id }}" style="font-weight: 900;">
                                                    <i class="bi bi-shield-check text-success fs-4"></i> Asset Verification QR Code
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 font-monospace mb-2" style="font-size: 12px; border-radius: 6px;">
                                                    Doc Ref: {{ $docNum }}
                                                </span>
                                                <p class="text-muted mb-3" style="font-size: 12px;">Scan QR Code ini menggunakan HP untuk melihat preview dokumen dan mengunduh PDF.</p>
                                                
                                                <!-- BOX QR CANVAS BESAR -->
                                                <div class="modal-qr-box shadow-sm mb-3" id="qrcode-modal-{{ $item->id }}" data-qr-value="{{ $qrPreviewUrl }}">
                                                    <!-- JS RENDER QR BESAR HERE -->
                                                </div>

                                                <div class="bg-light p-2 rounded-3 border font-monospace text-dark d-inline-block px-3 mb-3 text-break" style="font-size: 10px; max-width: 90%;">
                                                    <i class="bi bi-link-45deg me-1"></i> {{ $qrPreviewUrl }}
                                                </div>

                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <button type="button" onclick="downloadQR('qrcode-modal-{{ $item->id }}', '{{ $item->item_code }}')" class="btn btn-primary fw-bold px-4 rounded-3">
                                                        <i class="bi bi-download me-1"></i> Download QR Image (.PNG)
                                                    </button>
                                                    <button type="button" class="btn btn-light border fw-bold px-3 rounded-3" data-bs-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- 7. PIPELINE STEPPER INTEGRATED -->
                            <td>
                                <div class="pipeline-wrapper">
                                    
                                    <!-- STAGE 1: PD (PREPARED) -->
                                    @if($item->pd_prepared_at)
                                        <span class="step-badge-node step-node-done" title="Prepared by {{ $item->pdUser->name ?? 'PD' }}">
                                            <i class="bi bi-check-circle-fill"></i> Prepared (PD)
                                        </span>
                                    @else
                                        @if(in_array(Auth::user()->role, ['PD', 'Administrator']))
                                            <form action="{{ route('admin.workflow.approve', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="stage" value="pd">
                                                <button type="submit" class="btn btn-warning px-2 py-1 fw-bold" style="font-size: 11px; border-radius: 4px;" title="Sign PD">
                                                    <i class="bi bi-pen-fill me-1"></i> Sign PD
                                                </button>
                                            </form>
                                        @else
                                            <span class="step-badge-node step-node-pending"><i class="bi bi-hourglass-split"></i> Prepared</span>
                                        @endif
                                    @endif

                                    <i class="bi bi-chevron-right text-muted opacity-50" style="font-size: 10px;"></i>

                                    <!-- STAGE 2: QA (CHECKED) -->
                                    @if($item->qa_checked_at)
                                        <span class="step-badge-node step-node-done" title="Checked by {{ $item->qaUser->name ?? 'QA' }}">
                                            <i class="bi bi-check-circle-fill"></i> Checked (QA)
                                        </span>
                                    @else
                                        @if(in_array(Auth::user()->role, ['QA', 'Administrator']) && $item->pd_prepared_at)
                                            <div class="d-inline-flex gap-1">
                                                <form action="{{ route('admin.workflow.approve', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="stage" value="qa">
                                                    <button type="submit" class="btn btn-info text-white px-2 py-1 fw-bold" style="font-size: 11px; border-radius: 4px;">
                                                        <i class="bi bi-patch-check-fill me-1"></i> Check QA
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.workflow.reject', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak dan reset Sign PD?')">
                                                    @csrf
                                                    <input type="hidden" name="stage" value="qa">
                                                    <button type="submit" class="btn btn-outline-danger p-1" style="border-radius: 4px;" title="Reject">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="step-badge-node step-node-pending"><i class="bi bi-hourglass-split"></i> Checked</span>
                                        @endif
                                    @endif

                                    <i class="bi bi-chevron-right text-muted opacity-50" style="font-size: 10px;"></i>

                                    <!-- STAGE 3: PLANNER (APPROVED) -->
                                    @if($item->planner_approved_at)
                                        <span class="step-badge-node step-node-done" title="Approved by {{ $item->plannerUser->name ?? 'PLANNER' }}">
                                            <i class="bi bi-check-circle-fill"></i> Approved (PLANNER)
                                        </span>
                                    @else
                                        @if(in_array(Auth::user()->role, ['PLANNER', 'Administrator']) && $item->qa_checked_at)
                                            <div class="d-inline-flex gap-1">
                                                <form action="{{ route('admin.workflow.approve', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="stage" value="planner">
                                                    <button type="submit" class="btn btn-success px-2 py-1 fw-bold" style="font-size: 11px; border-radius: 4px;">
                                                        <i class="bi bi-check-all me-1"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.workflow.reject', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak dan reset Check QA?')">
                                                    @csrf
                                                    <input type="hidden" name="stage" value="planner">
                                                    <button type="submit" class="btn btn-outline-danger p-1" style="border-radius: 4px;" title="Reject">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="step-badge-node step-node-pending"><i class="bi bi-hourglass-split"></i> Approved</span>
                                        @endif
                                    @endif

                                </div>
                            </td>

                            <!-- 8. ACTIONS (PREVIEW, PRINT, DOWNLOAD PDF) -->
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-1.5">
                                    @if($item->planner_approved_at || Auth::user()->role === 'Administrator')
                                        <!-- PREVIEW BUTTON -->
                                        <a href="{{ route('admin.workflow.printPdf', $item->id) }}" target="_blank" class="btn-action-square btn-square-preview" title="Preview Document Sheet">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <!-- PRINT BUTTON -->
                                        <a href="{{ route('admin.workflow.printPdf', $item->id) }}" target="_blank" class="btn-action-square btn-square-print" title="Print Document Sheet">
                                            <i class="bi bi-printer-fill"></i>
                                        </a>

                                        <!-- DOWNLOAD PDF BUTTON -->
                                        <a href="{{ route('admin.workflow.printPdf', $item->id) }}?download=pdf" class="btn-action-square btn-square-download" title="Download Document Sheet (PDF)">
                                            <i class="bi bi-file-earmark-arrow-down-fill"></i>
                                        </a>
                                    @else
                                        <button class="btn-action-square bg-secondary text-white opacity-50" disabled title="Locked (Menunggu Approval)">
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2 opacity-50"></i>
                                Belum ada data project berstatus <strong>Completed</strong> yang siap di-assign, bor!
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
    <!-- SCRIPT GENERATOR QR CODE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // RENDER MINI QR TABEL
            document.querySelectorAll(".table-qr-canvas").forEach(function(element) {
                var value = element.getAttribute("data-qr-value");
                if (value) {
                    new QRCode(element, {
                        text: value,
                        width: 32,
                        height: 32,
                        colorDark : "#000000",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.M
                    });
                }
            });

            // RENDER QR BESAR DI MODAL
            document.querySelectorAll(".modal-qr-box").forEach(function(element) {
                var value = element.getAttribute("data-qr-value");
                if (value) {
                    new QRCode(element, {
                        text: value,
                        width: 236,
                        height: 236,
                        colorDark : "#000000",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });
                }
            });
        });

        // FUNCTION DOWNLOAD QR CODE IMAGE (.PNG)
        function downloadQR(boxId, itemCode) {
            var container = document.getElementById(boxId);
            var img = container.querySelector("img");
            var canvas = container.querySelector("canvas");

            var imageSrc = "";
            if (img && img.src) {
                imageSrc = img.src;
            } else if (canvas) {
                imageSrc = canvas.toDataURL("image/png");
            }

            if (imageSrc) {
                var link = document.createElement("a");
                link.href = imageSrc;
                link.download = "QR_VERIFICATION_" + itemCode + ".png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    </script>
@endpush