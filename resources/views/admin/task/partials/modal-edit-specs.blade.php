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
    .form-section-title-edit {
        color: #15803d !important;
        font-size: 14px;
        letter-spacing: 0.3px;
    }
</style>

<div class="modal fade" id="editTaskModal{{ $task->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3 text-start">
            
            <!-- Modal Header -->
            <div class="modal-header text-white py-3" style="background-color: #15803d; flex-shrink: 0;">
                <h5 class="modal-title fw-bold" id="editTaskModalLabel{{ $task->id }}" style="font-size: 16px;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Task Specification — {{ $task->item_code }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form Tag Update -->
            <form action="{{ route('admin.task.update', ['id' => $task->id]) }}" method="POST" style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden;">
                @csrf 
                @method('PUT')
                
                <!-- Modal Body Continuous Scroll -->
                <div class="modal-body p-4 bg-light">

                    <!-- INFO BANNER SINKRONISASI STATUS AUTOMATIS -->
                    <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-4 me-3 text-info"></i>
                        <div class="small">
                            <strong>Status Update Otomatis:</strong> Lengkapi data yang masih kosong. Jika seluruh data spesifikasi terisi penuh, status akan otomatis berpindah ke <strong>In Progress</strong>.
                        </div>
                    </div>

                    <!-- SECTION 1: IDENTITY & GENERAL SPECIFICATIONS -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3 form-section-title-edit">
                            <i class="bi bi-info-circle me-2"></i>1. Identity & General Specifications
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Item Code <span class="text-danger">*</span></label>
                                <input type="text" name="item_code" class="form-control bg-light" value="{{ old('item_code', $task->item_code) }}" readonly required title="Item Code tidak dapat diubah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Brand / Family</label>
                                <input type="text" name="brand_family" class="form-control" value="{{ old('brand_family', $task->brand_family) }}" placeholder="e.g. Cleo / Garuda">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Market Zone</label>
                                <input type="text" name="market" class="form-control" value="{{ old('market', $task->market) }}" placeholder="e.g. INDO / EXPORT">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">PD ASCIS</label>
                                <input type="text" name="ascis_pd" class="form-control" value="{{ old('ascis_pd', $task->ascis_pd) }}" placeholder="Input PD ASCIS">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Project Name</label>
                                <input type="text" name="project_name" class="form-control" value="{{ old('project_name', $task->project_name) }}" placeholder="Input project name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Customer Name</label>
                                <input type="text" name="customer" class="form-control" value="{{ old('customer', $task->customer) }}" placeholder="Input customer name">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CS Brand</label>
                                <input type="text" name="cs_brand" class="form-control" value="{{ old('cs_brand', $task->cs_brand) }}" placeholder="Input CS Brand">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CS HW</label>
                                <input type="text" name="cs_hw" class="form-control" value="{{ old('cs_hw', $task->cs_hw) }}" placeholder="Input CS HW">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CPI HW</label>
                                <input type="text" name="cpi_hw" class="form-control" value="{{ old('cpi_hw', $task->cpi_hw) }}" placeholder="Input CPI HW">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: APPROVAL & TECHNICAL MILESTONES -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3 form-section-title-edit">
                            <i class="bi bi-sliders me-2"></i>2. Approval & Technical Milestones
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">S5 Internal Approval</label>
                                <input type="text" name="s5_internal_approval" class="form-control" value="{{ old('s5_internal_approval', $task->s5_internal_approval) }}" placeholder="Input S5 Internal Approval">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">GHW Set</label>
                                <input type="text" name="ghw_set" class="form-control" value="{{ old('ghw_set', $task->ghw_set) }}" placeholder="Input GHW Set">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Information Received Date</label>
                                <input type="date" name="information_received" class="form-control" value="{{ old('information_received', $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">PLM Released Date</label>
                                <input type="date" name="plm_released" class="form-control" value="{{ old('plm_released', $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">COI Number</label>
                                <input type="text" name="coi_number" class="form-control" value="{{ old('coi_number', $task->coi_number) }}" placeholder="Input COI Number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Green Light Date</label>
                                <input type="date" name="green_light" class="form-control" value="{{ old('green_light', $task->green_light ? \Carbon\Carbon::parse($task->green_light)->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">TD (Technical Doc)</label>
                                <input type="text" name="td" class="form-control" value="{{ old('td', $task->td) }}" placeholder="Input TD">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Machine</label>
                                <input type="text" name="machine" class="form-control" value="{{ old('machine', $task->machine) }}" placeholder="e.g. Offset / Gravure">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: BOARD, CODES, DIE CUT & CYLINDER SPECS -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm">
                        <h6 class="fw-bold border-bottom pb-2 mb-3 form-section-title-edit">
                            <i class="bi bi-box-seam me-2"></i>3. Board, Codes, Die Cut & Cylinder Specs
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Board Type</label>
                                <input type="text" name="board" class="form-control" value="{{ old('board', $task->board) }}" placeholder="Input Board Type">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Board U Code</label>
                                <input type="text" name="board_u_code" class="form-control" value="{{ old('board_u_code', $task->board_u_code) }}" placeholder="Input Board U Code">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Board A Code</label>
                                <input type="text" name="board_a_code" class="form-control" value="{{ old('board_a_code', $task->board_a_code) }}" placeholder="Input Board A Code">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Type CM</label>
                                <input type="text" name="type_cm" class="form-control" value="{{ old('type_cm', $task->type_cm) }}" placeholder="Input Type CM">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Die Cut Number</label>
                                <input type="text" name="die_cut_number" class="form-control" value="{{ old('die_cut_number', $task->die_cut_number) }}" placeholder="Input Die Cut Number">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S10 Number</label>
                                <input type="text" name="s10_number" class="form-control" value="{{ old('s10_number', $task->s10_number) }}" placeholder="Input S10 Number">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S11 Number</label>
                                <input type="text" name="s11_number" class="form-control" value="{{ old('s11_number', $task->s11_number) }}" placeholder="Input S11 Number">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S12 Number</label>
                                <input type="text" name="s12_number" class="form-control" value="{{ old('s12_number', $task->s12_number) }}" placeholder="Input S12 Number">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Cylinder Supplier</label>
                                <input type="text" name="cylinder_supplier" class="form-control" value="{{ old('cylinder_supplier', $task->cylinder_supplier) }}" placeholder="e.g. SEIN / JNSK">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Repro By</label>
                                <input type="text" name="repro_by" class="form-control" value="{{ old('repro_by', $task->repro_by) }}" placeholder="e.g. Internal / External">
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