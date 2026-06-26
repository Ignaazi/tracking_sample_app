<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOB_ASSIGNMENT_{{ $item->sap_code }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #ffffff; color: #000000; }
        .doc-border { border: 3px double #000000; padding: 30px; margin-top: 20px; }
        .kop-title { text-transform: uppercase; font-weight: 800; letter-spacing: 1px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .meta-table th { width: 30%; background-color: #f8fafc !important; font-weight: bold; }
        .sign-space { height: 80px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
            .doc-border { border: none; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container my-3 no-print text-center">
        <div class="alert alert-info d-inline-block shadow-sm">
            <i class="fa-solid fa-print me-2"></i> Kotak dialog cetak otomatis terbuka. Jika batal, klik tombol ini untuk cetak ulang: 
            <button onclick="window.print()" class="btn btn-primary btn-sm ms-3">Cetak Dokumen</button>
        </div>
    </div>

    <div class="container">
        <div class="doc-border">
            <div class="row align-items-center mb-4 pb-2 border-bottom border-2">
                <div class="col-8">
                    <h4 class="m-0 fw-bold tracking-wide text-dark">ENTERPRISE OPERATIONS DEPLOYMENT SHEET</h4>
                    <small class="text-muted font-monospace">Document Ref: REQ-ASSIGN/{{ date('Y') }}/{{ $item->id }}</small>
                </div>
                <div class="col-4 text-end">
                    <span class="badge border border-dark text-dark px-3 py-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 1px;">
                        ISO 9001:2015 Approved
                    </span>
                </div>
            </div>

            <div class="text-center my-4">
                <h5 class="fw-bold text-decoration-underline" style="letter-spacing: 0.5px;">COMPONENT PRODUCTION ASSIGNMENT LETTER</h5>
            </div>

            <p class="mb-4 text-dark" style="font-size: 14px; leading-relaxed: 1.6;">
                Diberitahukan kepada seluruh jajaran divisi terkait (Engineering, Costing, dan Jalur Produksi Line), bahwa aset spesifikasi teknik komponen yang terdaftar di bawah ini telah diverifikasi penuh dan siap untuk didistribusikan ke workstation lapangan:
            </p>

            <table class="table table-bordered border-dark align-middle my-4" style="font-size: 13.5px;">
                <tr>
                    <th class="table-light py-2.5 px-3" style="width: 30%;">Item Code Name</th>
                    <td class="px-3 fw-bold">{{ $item->item_name }}</td>
                </tr>
                <tr>
                    <th class="table-light py-2.5 px-3">SAP Identification Code</th>
                    <td class="px-3 font-monospace fw-bold text-primary">{{ $item->sap_code }}</td>
                </tr>
                <tr>
                    <th class="table-light py-2.5 px-3">Manufacturer Brand</th>
                    <td class="px-3">{{ $item->brand }}</td>
                </tr>
                <tr>
                    <th class="table-light py-2.5 px-3">Model Type Registration</th>
                    <td class="px-3">{{ $item->model_type }}</td>
                </tr>
                <tr>
                    <th class="table-light py-2.5 px-3">Physical Dimensions Spec</th>
                    <td class="px-3 text-secondary">{{ $item->dimensions ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="table-light py-2.5 px-3">Technical Requirements</th>
                    <td class="px-3 text-secondary">{{ $item->requirements ?? 'No special constraints recorded.' }}</td>
                </tr>
                <tr>
                    <th class="table-light py-2.5 px-3">Visual Asset Blueprint</th>
                    <td class="px-3 py-3 text-center">
                        @if($item->image_path)
                            <img src="{{ asset($item->image_path) }}" class="img-thumbnail" style="max-height: 180px; object-fit: contain;">
                            <small class="d-block text-muted mt-1 font-monospace" style="font-size: 11px;">Attached Ref Image: {{ basename($item->image_path) }}</small>
                        @else
                            <span class="text-muted italic" style="font-size: 12px;">No blueprint attachment provided.</span>
                        @endif
                    </td>
                </tr>
            </table>

            <p class="mt-4 mb-5 text-dark" style="font-size: 13.5px;">
                Demikian surat penugasan spesifikasi aset instrumen ini dicetak agar dapat dipergunakan sebagaimana mestinya untuk menunjang kelancaran operasional produksi mesin scanner terintegrasi.
            </p>

            <div class="row pt-4 text-center" style="font-size: 13px;">
                <div class="col-4">
                    <p class="mb-1 text-muted">Issued By,</p>
                    <p class="fw-bold text-dark">System Administrator</p>
                    <div class="sign-space border-bottom border-secondary border-dashed mx-4"></div>
                    <p class="mt-2 text-muted font-monospace" style="font-size: 11px;">Date: {{ date('d-m-Y') }}</p>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                    <p class="mb-1 text-muted">Acknowledge & Approved,</p>
                    <p class="fw-bold text-dark">Executive Head Operations</p>
                    <div class="sign-space border-bottom border-secondary border-dashed mx-4"></div>
                    <p class="mt-2 text-muted font-monospace" style="font-size: 11px;">Operational Stamp Here</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>