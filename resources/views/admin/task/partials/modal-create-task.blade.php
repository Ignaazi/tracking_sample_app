<!-- Style Khusus Memaksa Body Modal BISA SCROLL -->
<style>
    #addTaskModal .modal-dialog {
        max-height: 90vh !important;
    }
    #addTaskModal .modal-content {
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
    }
    #addTaskModal .modal-body {
        max-height: calc(90vh - 130px) !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
    }
</style>

<!-- Modal Utama Create New Project Specification -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3">
            
            <!-- Modal Header -->
            <div class="modal-header text-white py-3" style="background-color: #15803d; flex-shrink: 0;">
                <h5 class="modal-title fw-bold" id="addTaskModalLabel">
                    <i class="bi bi-plus-circle-fill me-2"></i>Create New Project Specification
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Tag Utama -->
            <form id="dynamicTaskForm" action="{{ route('admin.task.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden;">
                @csrf
                
                <!-- Modal Body (Bisa Di-scroll Bebas) -->
                <div class="modal-body p-4 bg-light">

                    <!-- SECTION 1: GENERAL & IDENTITY SPECS -->
                    <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
                        <h6 class="fw-bold border-bottom pb-2 mb-3" style="color: #15803d !important;">
                            <i class="bi bi-info-circle me-2"></i>1. General Information & Identity
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Item Code <span class="text-danger">*</span></label>
                                <input type="text" name="item_code" class="form-control" placeholder="e.g. 123-123" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">SAP Number</label>
                                <input type="text" name="sap_number" class="form-control" placeholder="e.g. 000-000">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Brand / Family</label>
                                <input type="text" name="brand_family" class="form-control" placeholder="e.g. Cleo">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Market Zone</label>
                                <select name="market" class="form-select">
                                    <option value="INDO">INDO</option>
                                    <option value="EXPORT">EXPORT</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Project Name <span class="text-danger">*</span></label>
                                <input type="text" name="project_name" class="form-control" placeholder="Input project name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">PD ASCIS</label>
                                <input type="text" name="ascis_pd" class="form-control" placeholder="Input PD ASCIS">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer" class="form-control" placeholder="Input customer name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CS Brand</label>
                                <input type="text" name="cs_brand" class="form-control" placeholder="Input CS Brand">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CS HW</label>
                                <input type="text" name="cs_hw" class="form-control" placeholder="Input CS HW">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">CPI HW</label>
                                <input type="text" name="cpi_hw" class="form-control" placeholder="Input CPI HW">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Development Status <span class="text-danger">*</span></label>
                                <select name="development_status" class="form-select" required>
                                    <option value="Active">Active</option>
                                    <option value="Testing">Testing</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Main Board Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="todo">To Do</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
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
                                <input type="text" name="s5_internal_approval" class="form-control" placeholder="Input S5 Internal Approval">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">GHW Set</label>
                                <input type="text" name="ghw_set" class="form-control" placeholder="Input GHW Set">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Information Received Date</label>
                                <input type="date" name="information_received" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">PLM Released Date</label>
                                <input type="date" name="plm_released" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">COI Number</label>
                                <input type="text" name="coi_number" class="form-control" placeholder="Input COI Number">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Green Light</label>
                                <input type="text" name="green_light" class="form-control" placeholder="Input Green Light Status">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">TD (Technical Doc)</label>
                                <input type="text" name="td" class="form-control" placeholder="Input TD">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Repro By</label>
                                <input type="text" name="repro_by" class="form-control" placeholder="Who performs repro process?">
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
                                <input type="text" name="machine" class="form-control" placeholder="Input Machine Type">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Board</label>
                                <input type="text" name="board" class="form-control" placeholder="Input Board Type">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Board U Code</label>
                                <input type="text" name="board_u_code" class="form-control" placeholder="Input Board U Code">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Board A Code</label>
                                <input type="text" name="board_a_code" class="form-control" placeholder="Input Board A Code">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Type CM</label>
                                <input type="text" name="type_cm" class="form-control" placeholder="Input Type CM">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Die Cut Number</label>
                                <input type="text" name="die_cut_number" class="form-control" placeholder="Input Die Cut Number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Cylinder Supplier</label>
                                <input type="text" name="cylinder_supplier" class="form-control" placeholder="Input Cylinder Supplier">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S10 Number</label>
                                <input type="text" name="s10_number" class="form-control" placeholder="Input S10 Number">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S11 Number</label>
                                <input type="text" name="s11_number" class="form-control" placeholder="Input S11 Number">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">S12 Number</label>
                                <input type="text" name="s12_number" class="form-control" placeholder="Input S12 Number">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">BAAN Cylinder Code</label>
                                <input type="text" name="baan_cylinder" class="form-control" placeholder="Input BAAN Cylinder Code">
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
                                <input type="text" name="sequence_seq" class="form-control" placeholder="e.g. 1, 2, 3">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Colour</label>
                                <input type="text" name="colour" class="form-control" placeholder="Input Colour Info">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Film Number</label>
                                <input type="text" name="film_number" class="form-control" placeholder="Input Film Number">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Ink System</label>
                                <input type="text" name="ink_system" class="form-control" placeholder="Input Ink System">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Ink Code</label>
                                <input type="text" name="ink_code" class="form-control" placeholder="Input Ink Code">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">BAAN Ink Code</label>
                                <input type="text" name="baan_ink_code" class="form-control" placeholder="Input BAAN Ink Code">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Supplier Ink</label>
                                <input type="text" name="supplier_ink" class="form-control" placeholder="Input Supplier Ink Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Angle / Anilox</label>
                                <input type="text" name="angle_anilox" class="form-control" placeholder="Input Angle / Anilox">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Coverage (%)</label>
                                <input type="number" step="0.01" min="0" max="100" name="coverage_percent" class="form-control" placeholder="e.g. 75.50">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Usage (Kg/TH)</label>
                                <input type="number" step="0.01" min="0" name="usage_kg_th" class="form-control" placeholder="e.g. 1.25">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Main Design / Attachment</label>
                                <input type="text" name="main_design_attachment" class="form-control" placeholder="File Name or URL attachment">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Target Date (End Date)</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Remarks</label>
                                <textarea name="remark" class="form-control" rows="3" placeholder="Write additional project specifications or notes here..."></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top d-flex justify-content-between p-3" style="flex-shrink: 0;">
                    <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn text-white px-5 fw-semibold shadow-sm" style="background-color: #15803d; border-color: #15803d;">
                        <i class="bi bi-check-circle-fill me-1"></i>Save Specification
                    </button>
                </div>

            </form>
            
        </div>
    </div>
</div>