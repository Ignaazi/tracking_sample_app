@extends('layouts.admin')

@section('title', 'Item Specifications & Requirements')

@section('content')
<div class="pagetitle mb-4">
    <h1 class="fw-bold text-dark mb-1" style="font-size: 24px;">Item Specifications & Requirements</h1>
    <p class="text-muted mb-0" style="font-size: 13px;">Manage blueprint components registration, technical dimensions, and images mapping.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="background-color: #e1fcef; color: #0f5132;">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0 fw-bold" style="color: #012970; font-size: 16px;">
            <i class="fa-solid fa-file-shield me-2 text-primary"></i>Registered Component List
        </h5>
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addItemModal" style="font-size: 12px;">
            <i class="fa-solid fa-plus me-1"></i> Register New Spec
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                <thead class="table-light text-muted" style="font-size: 12px; text-transform: uppercase;">
                    <tr>
                        <th class="ps-3 py-3" style="width: 80px;">Photo</th>
                        <th>Item Name</th>
                        <th>SAP Code</th>
                        <th>Brand / Model</th>
                        <th>Dimensions Spec</th>
                        <th>Technical Req</th>
                        <th class="pe-3 text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($itemSpecs->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-images fs-3 d-block mb-2 text-secondary"></i>
                                Belum ada data spesifikasi item di database, bor!
                            </td>
                        </tr>
                    @endif
                    @foreach($itemSpecs as $item)
                    <tr>
                        <td class="ps-3">
                            @if($item->image_path)
                                <a href="{{ asset($item->image_path) }}" target="_blank">
                                    <img src="{{ asset($item->image_path) }}" alt="item-photo" class="rounded border object-cover" style="width: 50px; height: 50px; object-fit: cover;">
                                </a>
                            @else
                                <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px; font-size: 10px;">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold text-dark">{{ $item->item_name }}</td>
                        <td>
                            <span class="badge font-monospace px-2 py-1.5 rounded" style="background-color: #f0f5ff; color: #1d4ed8; font-size: 12px; border: 1px solid #ddbbef;">
                                {{ $item->sap_code }}
                            </span>
                        </td>
                        <td>
                            <span class="d-block text-dark fw-semibold">{{ $item->brand }}</span>
                            <small class="text-muted" style="font-size: 11px;">{{ $item->model_type }}</small>
                        </td>
                        <td class="text-secondary text-truncate" style="max-width: 150px;">{{ $item->dimensions ?? '-' }}</td>
                        <td class="text-secondary text-truncate" style="max-width: 180px;">{{ $item->requirements ?? '-' }}</td>
                        <td class="pe-3 text-end">
                            <button class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-warning"></i>
                            </button>
                            <form action="{{ route('admin.item-specs.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus item spesifikasi ini, bor?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border" title="Delete">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editItemModal{{ $item->id }}" transatlantic="true" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form action="{{ route('admin.item-specs.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" style="color: #012970;"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Item Specification</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="font-size: 13px;">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Item Name</label>
                                            <input type="text" name="item_name" class="form-control" value="{{ $item->item_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">SAP Code Format</label>
                                            <input type="text" name="sap_code" class="form-control" value="{{ $item->sap_code }}" required>
                                        </div>
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Brand</label>
                                                <input type="text" name="brand" class="form-control" value="{{ $item->brand }}" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Model/Customer Type</label>
                                                <input type="text" name="model_type" class="form-control" value="{{ $item->model_type }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dimensions Spec (P x L x T)</label>
                                            <input type="text" name="dimensions" class="form-control" value="{{ $item->dimensions }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Technical Requirements</label>
                                            <textarea name="requirements" class="form-control" rows="2">{{ $item->requirements }}</textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label fw-bold">Replace Component Photo <small class="text-muted">(Max 2MB)</small></label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light border btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">Update Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.item-specs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color: #012970;"><i class="fa-solid fa-file-shield me-2"></i>Register New Specification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 13px;">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Item Name</label>
                        <input type="text" name="item_name" class="form-control" placeholder="E.g. Nozzle Spray Scanner A" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">SAP Code Format</label>
                        <input type="text" name="sap_code" class="form-control" placeholder="E.g. SAP-NX-2026" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Brand</label>
                            <input type="text" name="brand" class="form-control" placeholder="E.g. Omron" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Model/Customer Type</label>
                            <input type="text" name="model_type" class="form-control" placeholder="E.g. Standard Model Y" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dimensions Spec (P x L x T)</label>
                        <input type="text" name="dimensions" class="form-control" placeholder="E.g. 120mm x 45mm x 30mm">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Technical Requirements</label>
                        <textarea name="requirements" class="form-control" rows="2" placeholder="E.g. Anti-static material, high precision sensor tolerance."></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Component Photo <small class="text-muted">(Max 2MB)</small></label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">Save Specification</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection