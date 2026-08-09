<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Specification - {{ $task->item_code }}</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif !important;
            background-color: #f1f5f9;
            color: #1e293b;
        }

        /* A4 Page Setup */
        .page-a4 {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 20px auto;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            position: relative;
        }

        .preview-header-bar {
            border-bottom: 3px double #1e293b;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .table-custom-bordered {
            border-collapse: collapse !important;
            width: 100%;
        }

        .table-custom-bordered th, 
        .table-custom-bordered td {
            border: 1px solid #64748b !important;
            padding: 6px 8px !important;
            font-size: 11.5px !important;
            vertical-align: middle !important;
            text-align: center !important;
        }

        .table-custom-bordered th {
            background-color: #f8fafc !important;
            color: #0f172a !important;
            font-weight: 800 !important;
            text-transform: uppercase;
        }

        .meta-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
        }

        .meta-value {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
        }

        .section-title {
            font-size: 12px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #e2e8f0;
            padding: 4px 10px;
            border-left: 4px solid #0284c7;
            margin-bottom: 10px;
        }

        /* Signatures Section */
        .signature-box {
            border: 1px solid #cbd5e1;
            height: 75px;
            border-radius: 4px;
        }

        /* Floating Action Bar (Hidden on Print) */
        .no-print-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            gap: 10px;
        }

        /* PRINT MEDIA STYLES */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }

            .page-a4 {
                width: 100% !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
            }

            .no-print-bar {
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

    <!-- FLOATING ACTION BUTTONS (CETAK & KEMBALI) -->
    <div class="no-print-bar">
        <a href="{{ route('admin.item-specs.index') }}" class="btn btn-secondary btn-sm shadow fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary btn-sm shadow fw-bold">
            <i class="bi bi-printer-fill me-1"></i> Print / Save PDF
        </button>
    </div>

    <!-- MAIN A4 DOCUMENT CONTAINER -->
    <div class="page-a4">
        
        <!-- HEADER SPECIFICATION -->
        <div class="preview-header-bar d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px; color: #0f172a;">Item Specification Sheet</h4>
                <p class="text-muted small m-0">Printing Ink & Technical Color Sequence Specification</p>
            </div>
            <div class="text-end">
                <span class="badge bg-dark fs-6 px-3 py-2">{{ $task->item_code }}</span>
            </div>
        </div>

        <!-- METADATA INFORMATION GRID -->
        <div class="row g-3 mb-4">
            <div class="col-3">
                <div class="meta-label">Project Name</div>
                <div class="meta-value">{{ $task->project_name ?? '-' }}</div>
            </div>
            <div class="col-3">
                <div class="meta-label">Customer</div>
                <div class="meta-value">{{ $task->customer ?? '-' }}</div>
            </div>
            <div class="col-2">
                <div class="meta-label">Market</div>
                <div class="meta-value">{{ $task->market ?? '-' }}</div>
            </div>
            <div class="col-2">
                <div class="meta-label">TD Reference</div>
                <div class="meta-value">{{ $task->td ?? '-' }}</div>
            </div>
            <div class="col-2">
                <div class="meta-label">Board / Material</div>
                <div class="meta-value">{{ $task->board ?? '-' }}</div>
            </div>
        </div>

        <!-- ITEM SPECIFICATION TABLE -->
        <div class="section-title">Color Sequence & Ink Technical Specifications</div>
        <table class="table-custom-bordered mb-4">
            <thead>
                <tr>
                    <th style="width: 35px;">Seq</th>
                    <th>Color / Name</th>
                    <th>BaaN Cylinder</th>
                    <th>Film No</th>
                    <th>Ink System</th>
                    <th>Ink Code</th>
                    <th>Supplier</th>
                    <th>BaaN Ink</th>
                    <th>Cov (%)</th>
                    <th>Usage (kg)</th>
                    <th>Anilox/Angle</th>
                </tr>
            </thead>
            <tbody>
                @forelse($task->itemSpecs->sortBy('sequence') as $spec)
                <tr>
                    <td class="fw-bold">{{ $spec->sequence }}</td>
                    <td class="fw-bold text-start">{{ $spec->colour }}</td>
                    <td>{{ $spec->baan_cylinder ?? '-' }}</td>
                    <td>{{ $spec->film_number ?? '-' }}</td>
                    <td>{{ $spec->ink_system ?? '-' }}</td>
                    <td>{{ $spec->ink_code ?? '-' }}</td>
                    <td>{{ $spec->supplier_ink ?? '-' }}</td>
                    <td>{{ $spec->baan_ink_code ?? '-' }}</td>
                    <td>{{ $spec->coverage ? $spec->coverage.'%' : '-' }}</td>
                    <td>{{ $spec->usage_kg_th ?? '-' }}</td>
                    <td>{{ $spec->angle_anilox ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="py-3 text-muted">Belum ada sequence spesifikasi warna yang didaftarkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- REMARKS & ATTACHMENT INFO -->
        @php
            $firstSpec = $task->itemSpecs->first();
        @endphp
        @if($firstSpec && $firstSpec->remarks)
        <div class="mb-4">
            <div class="section-title">Remarks / Special Notes</div>
            <div class="p-2 border rounded bg-light" style="font-size: 11.5px; line-height: 1.5;">
                {{ $firstSpec->remarks }}
            </div>
        </div>
        @endif

        <!-- APPROVAL & SIGNATURE AREA -->
        <div class="mt-5">
            <div class="row text-center" style="font-size: 11px; font-weight: 700;">
                <div class="col-3">
                    <p class="mb-1">PREPARED BY</p>
                    <div class="signature-box mb-1"></div>
                    <p class="m-0 text-muted">( Prepress Staff )</p>
                </div>
                <div class="col-3">
                    <p class="mb-1">CHECKED BY</p>
                    <div class="signature-box mb-1"></div>
                    <p class="m-0 text-muted">( QC / QA )</p>
                </div>
                <div class="col-3">
                    <p class="mb-1">APPROVED BY</p>
                    <div class="signature-box mb-1"></div>
                    <p class="m-0 text-muted">( Production Manager )</p>
                </div>
                <div class="col-3">
                    <p class="mb-1">CUSTOMER ACKNOWLEDGEMENT</p>
                    <div class="signature-box mb-1"></div>
                    <p class="m-0 text-muted">( Stamp & Sign )</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>