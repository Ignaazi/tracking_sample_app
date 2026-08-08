@if(isset($task) && isset($task->id))

<!-- Style Pengaman Scroll Modal Edit -->
<style>
    #editTaskModal{{ $task->id }} .modal-dialog {
        max-height: 90vh !important;
    }
    #editTaskModal{{ $task->id }} .modal-content {
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    #editTaskModal{{ $task->id }} .modal-body {
        max-height: calc(90vh - 130px) !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
    }
</style>

<div class="modal fade" id="editTaskModal{{ $task->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3 text-start">
            
            <!-- Modal Header -->
            <div class="modal-header text-white py-3" style="background-color: #15803d; flex-shrink: 0;">
                <h5 class="modal-title fw-bold" id="editTaskModalLabel{{ $task->id }}" style="font-size: 16px;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Project Specification — {{ $task->item_code }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form Tag Update -->
            <form action="{{ route('admin.task.update', ['id' => $task->id]) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden;">
                @csrf 
                @method('PUT')
                
                <!-- Modal Body Continuous Scroll -->
                <div class="modal-body p-4 bg-light">

                    <!-- SECTION 1: GENERAL & IDENTITY SPECS -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3" style="color: #15803d !important;">
                            <i class="bi bi-info-circle me-2"></i>1. General Information & Identity
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Item Code <span class="text-danger">*</span></label>
                                <input type="text" name="item_code" class="form-control" value="{{ $task->item_code }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">SAP Number</label>
                                <input type="text" name="sap_number" class="form-control" value="{{ $task->sap_number }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Brand / Family</label>
                                <input type="text" name="brand_family" class="form-control" value="{{ $task->brand_family }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Market Zone</label>
                                <select name="market" class="form-select">
                                    <option value="INDO" {{ ($task->market ?? 'INDO') == 'INDO' ? 'selected' : '' }}>INDO</option>
                                    <option value="EXPORT" {{ ($task->market ?? '') == 'EXPORT' ? 'selected' : '' }}>EXPORT</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Project Name <span class="text-danger">*</span></label>
                                <input type="text" name="project_name" class="form-control" value="{{ $task->project_name }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">PD ASCIS</label>
                                <input type="text" name="ascis_pd" class="form-control" value="{{ $task->ascis_pd }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer" class="form-control" value="{{ $task->customer }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CS Brand</label>
                                <input type="text" name="cs_brand" class="form-control" value="{{ $task->cs_brand }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CS HW</label>
                                <input type="text" name="cs_hw" class="form-control" value="{{ $task->cs_hw }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CPI HW</label>
                                <input type="text" name="cpi_hw" class="form-control" value="{{ $task->cpi_hw }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Development Status <span class="text-danger">*</span></label>
                                <select name="development_status" class="form-select" required>
                                    <option value="Active" {{ $task->development_status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Testing" {{ $task->development_status == 'Testing' ? 'selected' : '' }}>Testing</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Main Board Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="todo" {{ in_array(strtolower($task->status), ['todo', 'to do']) ? 'selected' : '' }}>To Do</option>
                                    <option value="in-progress" {{ in_array(strtolower($task->status), ['in-progress', 'in progress']) ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ in_array(strtolower($task->status), ['completed', 'done']) ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: TECHNICAL & APPROVAL SPECS -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3" style="color: #15803d !important;">
                            <i class="bi bi-sliders me-2"></i>2. Technical Approval & Process
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">S5 Internal Approval</label>
                                <input type="text" name="s5_internal_approval" class="form-control" value="{{ $task->s5_internal_approval }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">GHW Set</label>
                                <input type="text" name="ghw_set" class="form-control" value="{{ $task->ghw_set }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Information Received Date</label>
                                <input type="date" name="information_received" class="form-control" value="{{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">PLM Released Date</label>
                                <input type="date" name="plm_released" class="form-control" value="{{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">COI Number</label>
                                <input type="text" name="coi_number" class="form-control" value="{{ $task->coi_number }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Green Light</label>
                                <input type="text" name="green_light" class="form-control" value="{{ $task->green_light }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">TD (Technical Doc)</label>
                                <input type="text" name="td" class="form-control" value="{{ $task->td }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Repro By</label>
                                <input type="text" name="repro_by" class="form-control" value="{{ $task->repro_by }}">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: MACHINE, BOARD & TOOLING SPECS -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3" style="color: #15803d !important;">
                            <i class="bi bi-box-seam me-2"></i>3. Machine, Board & Cylinder Tooling
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Machine</label>
                                <input type="text" name="machine" class="form-control" value="{{ $task->machine }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Board</label>
                                <input type="text" name="board" class="form-control" value="{{ $task->board }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Board U Code</label>
                                <input type="text" name="board_u_code" class="form-control" value="{{ $task->board_u_code }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Board A Code</label>
                                <input type="text" name="board_a_code" class="form-control" value="{{ $task->board_a_code }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Type CM</label>
                                <input type="text" name="type_cm" class="form-control" value="{{ $task->type_cm }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Die Cut Number</label>
                                <input type="text" name="die_cut_number" class="form-control" value="{{ $task->die_cut_number }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Cylinder Supplier</label>
                                <input type="text" name="cylinder_supplier" class="form-control" value="{{ $task->cylinder_supplier }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S10 Number</label>
                                <input type="text" name="s10_number" class="form-control" value="{{ $task->s10_number }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S11 Number</label>
                                <input type="text" name="s11_number" class="form-control" value="{{ $task->s11_number }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S12 Number</label>
                                <input type="text" name="s12_number" class="form-control" value="{{ $task->s12_number }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">BAAN Cylinder Code</label>
                                <input type="text" name="baan_cylinder" class="form-control" value="{{ $task->baan_cylinder }}">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: INK, COLOUR & ATTACHMENT SPECS -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm">
                        <h6 class="fw-bold border-bottom pb-2 mb-3" style="color: #15803d !important;">
                            <i class="bi bi-palette me-2"></i>4. Ink, Colour & Target Schedule
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Sequence (Seq)</label>
                                <input type="text" name="sequence_seq" class="form-control" value="{{ $task->sequence_seq }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Colour</label>
                                <input type="text" name="colour" class="form-control" value="{{ $task->colour }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Film Number</label>
                                <input type="text" name="film_number" class="form-control" value="{{ $task->film_number }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Ink System</label>
                                <input type="text" name="ink_system" class="form-control" value="{{ $task->ink_system }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Ink Code</label>
                                <input type="text" name="ink_code" class="form-control" value="{{ $task->ink_code }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">BAAN Ink Code</label>
                                <input type="text" name="baan_ink_code" class="form-control" value="{{ $task->baan_ink_code }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Supplier Ink</label>
                                <input type="text" name="supplier_ink" class="form-control" value="{{ $task->supplier_ink }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Angle / Anilox</label>
                                <input type="text" name="angle_anilox" class="form-control" value="{{ $task->angle_anilox }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Coverage (%)</label>
                                <input type="number" step="0.01" min="0" max="100" name="coverage_percent" class="form-control" value="{{ $task->coverage_percent }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Usage (Kg/TH)</label>
                                <input type="number" step="0.01" min="0" name="usage_kg_th" class="form-control" value="{{ $task->usage_kg_th }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Main Design / Attachment</label>
                                <input type="text" name="main_design_attachment" class="form-control" value="{{ $task->main_design_attachment }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Target Date (End Date)</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Remarks</label>
                                <textarea name="remark" class="form-control" rows="3">{{ $task->remark }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
                
                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top d-flex justify-content-between p-3" style="flex-shrink: 0;">
                    <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn text-white px-5 fw-semibold shadow-sm" style="background-color: #15803d; border-color: #15803d;">
                        <i class="bi bi-floppy-fill me-1"></i> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endif