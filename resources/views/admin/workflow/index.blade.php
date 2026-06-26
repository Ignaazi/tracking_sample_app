@extends('layouts.admin')

@section('title', 'Workflow Engine Assignment')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="fw-bold text-dark mb-1" style="font-size: 24px;">Workflow Engine</h1>
    <p class="text-muted mb-0" style="font-size: 13px;">Finalized architecture specs asset mapping and enterprise assignment distribution sheets.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="card-title m-0 fw-bold" style="color: #012970; font-size: 16px;">
            <i class="fa-solid fa-square-poll-horizontal me-2 text-primary"></i>Ready to Assign Components
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                <thead class="table-light text-muted" style="font-size: 12px; text-transform: uppercase;">
                    <tr>
                        <th class="ps-3 py-3">Component Info</th>
                        <th>SAP Identity</th>
                        <th>Brand & Line Model</th>
                        <th>Technical Spec Status</th>
                        <th class="pe-3 text-end">Action Document</th>
                    </tr>
                </thead>
                <tbody>
                    @if($completedItems->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-ban fs-3 d-block mb-2 text-secondary"></i>
                                Belum ada data komponen berstatus final yang siap di-assign, bor!
                            </td>
                        </tr>
                    @endif
                    @foreach($completedItems as $item)
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($item->image_path)
                                    <img src="{{ asset($item->image_path) }}" class="rounded border" style="width: 45px; height: 45px; object-fit: cover;">
                                @else
                                    <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px; font-size: 9px;">No Pic</div>
                                @endif
                                <div>
                                    <span class="d-block fw-bold text-dark">{{ $item->item_name }}</span>
                                    <small class="text-muted" style="font-size: 11px;">Verified Asset</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge font-monospace px-2 py-1.5 rounded" style="background-color: #e0f2fe; color: #0369a1; font-size: 12px; border: 1px solid #bae6fd;">
                                {{ $item->sap_code }}
                            </span>
                        </td>
                        <td>
                            <span class="d-block fw-bold text-dark">{{ $item->brand }}</span>
                            <small class="text-muted" style="font-size: 11px;">{{ $item->model_type }}</small>
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                                <i class="fa-solid fa-circle-check me-1"></i> Ready / Production Approved
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('admin.workflow.printPdf', $item->id) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" style="font-size: 11.5px;">
                                <i class="fa-solid fa-file-pdf me-1"></i> Print Assignment Sheet
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection