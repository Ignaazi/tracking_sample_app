<div class="modal fade" id="editSpecModal{{ $spec->id }}" tabindex="-1" aria-hidden="true" style="font-family: 'Nunito', sans-serif;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.item-specs.update', $spec->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-header text-white" style="background-color: #0f5132;">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Printing & Ink Specification</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body text-start" style="font-size: 13px;">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark">Sequence</label>
                            <input type="number" name="sequence" class="form-control" min="1" max="12" value="{{ $spec->sequence }}" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-dark">Colour</label>
                            <input type="text" name="colour" class="form-control" value="{{ $spec->colour }}" placeholder="e.g. White / Cyan / Magenta" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Project Status</label>
                            <select name="project_status" class="form-select border-success" required>
                                <option value="To Do" {{ $spec->project_status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                <option value="Progress" {{ $spec->project_status == 'Progress' ? 'selected' : '' }}>Progress</option>
                                <option value="Completed" {{ $spec->project_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">BAAN Cylinder</label>
                            <input type="text" name="baan_cylinder" class="form-control" value="{{ $spec->baan_cylinder }}" placeholder="Cylinder ID Code">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark">Film Number</label>
                            <input type="text" name="film_number" class="form-control" value="{{ $spec->film_number }}" placeholder="Film identification no.">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Ink System</label>
                            <input type="text" name="ink_system" class="form-control" value="{{ $spec->ink_system }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Ink Code</label>
                            <input type="text" name="ink_code" class="form-control" value="{{ $spec->ink_code }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark">Supplier Ink</label>
                            <select name="supplier_ink" class="form-select">
                                <option value="">-- Select Supplier --</option>
                                <option value="SIEG" {{ $spec->supplier_ink == 'SIEG' ? 'selected' : '' }}>SIEG</option>
                                <option value="DIC" {{ $spec->supplier_ink == 'DIC' ? 'selected' : '' }}>DIC</option>
                                <option value="HUBER" {{ $spec->supplier_ink == 'HUBER' ? 'selected' : '' }}>HUBER</option>
                                <option value="SC" {{ $spec->supplier_ink == 'SC' ? 'selected' : '' }}>SC (Sun Chemical)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark">BAAN Ink Code</label>
                            <input type="text" name="baan_ink_code" class="form-control" value="{{ $spec->baan_ink_code }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark">Coverage (%)</label>
                            <input type="number" step="0.01" name="coverage" class="form-control" value="{{ $spec->coverage }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark">Usage (Kg/TH)</label>
                            <input type="number" step="0.01" name="usage_kg_th" class="form-control" value="{{ $spec->usage_kg_th }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark">Angle / Anilox</label>
                            <input type="text" name="angle_anilox" class="form-control" value="{{ $spec->angle_anilox }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Main Design / Attachment</label>
                        <input type="file" name="main_design_attachment" class="form-control">
                        @if($spec->main_design_attachment)
                            <small class="text-muted d-block mt-1">Current File: <a href="{{ asset($spec->main_design_attachment) }}" target="_blank">View File</a></small>
                        @endif
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2">{{ $spec->remarks }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border btn-sm rounded-pill px-3 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 fw-bold" style="background-color: #0f5132;">Save Specification</button>
                </div>
            </form>
        </div>
    </div>
</div>