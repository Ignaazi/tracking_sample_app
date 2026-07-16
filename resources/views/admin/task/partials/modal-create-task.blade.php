<!-- Modal Utama (Single Dynamic Modal) -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3">
            
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="addTaskModalLabel">
                    <i class="bi bi-plus-circle-fill me-2"></i>Create New Project Specification
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Tag -->
            <form id="dynamicTaskForm" action="{{ route('admin.task.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Modal Body -->
                <div class="modal-body p-4 bg-light">
                    
                    <!-- TAB NAVIGATION -->
                    <ul class="nav nav-pills nav-justified mb-4 p-1 bg-white rounded-3 shadow-sm border" id="taskTab" role="tablist" style="font-size: 13.5px;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-2.5 fw-bold" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-pane" type="button" role="tab">
                                <i class="bi bi-info-circle me-1.5"></i>General Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2.5 fw-bold" id="technical-tab" data-bs-toggle="tab" data-bs-target="#technical-pane" type="button" role="tab">
                                <i class="bi bi-sliders me-1.5"></i>Technical Specs
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2.5 fw-bold" id="board-tab" data-bs-toggle="tab" data-bs-target="#board-pane" type="button" role="tab">
                                <i class="bi bi-box-seam me-1.5"></i>Board & Tooling
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2.5 fw-bold" id="ink-tab" data-bs-toggle="tab" data-bs-target="#ink-pane" type="button" role="tab">
                                <i class="bi bi-palette me-1.5"></i>Ink & Colour
                            </button>
                        </li>
                    </ul>

                    <!-- TAB CONTENTS -->
                    <div class="tab-content bg-white p-4 rounded-3 border shadow-sm" id="taskTabContent">
                        
                        <!-- TAB 1: GENERAL INFO -->
                        <div class="tab-pane fade show active" id="general-pane" role="tabpanel" aria-labelledby="general-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Project Name <span class="text-danger">*</span></label>
                                    <input type="text" name="project_name" class="form-control" placeholder="Input project name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" name="customer" class="form-control" placeholder="Input customer" required>
                                </div>
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
                                    <label class="form-label fw-bold text-dark">PD ASCIS</label>
                                    <input type="text" name="ascis_pd" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">CS Brand</label>
                                    <input type="text" name="cs_brand" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">CS HW</label>
                                    <input type="text" name="cs_hw" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">CPI HW</label>
                                    <input type="text" name="cpi_hw" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Development Status <span class="text-danger">*</span></label>
                                    <select name="development_status" class="form-select" required>
                                        <option value="Active">Active</option>
                                        <option value="Testing">Testing</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold text-dark">Main Status Board <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="todo">To Do</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Target Date (End Date)</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: TECHNICAL SPECS -->
                        <div class="tab-pane fade" id="technical-pane" role="tabpanel" aria-labelledby="technical-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">S5 Internal Approval</label>
                                    <input type="text" name="s5_internal_approval" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">GHW Set</label>
                                    <input type="text" name="ghw_set" class="form-control">
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
                                    <input type="text" name="coi_number" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Green Light Status</label>
                                    <input type="text" name="green_light" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">TD (Technical Doc)</label>
                                    <input type="text" name="td" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark">Repro By</label>
                                    <input type="text" name="repro_by" class="form-control" placeholder="Who does the repro process?">
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: BOARD & TOOLING SPECS -->
                        <div class="tab-pane fade" id="board-pane" role="tabpanel" aria-labelledby="board-tab">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Machine Type</label>
                                    <input type="text" name="machine" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Board Type</label>
                                    <input type="text" name="board" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Type CM</label>
                                    <input type="text" name="type_cm" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Board U Code</label>
                                    <input type="text" name="board_u_code" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Board A Code</label>
                                    <input type="text" name="board_a_code" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Die Cut Number</label>
                                    <input type="text" name="die_cut_number" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Cylinder Supplier</label>
                                    <input type="text" name="cylinder_supplier" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">S10 Number</label>
                                    <input type="text" name="s10_number" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">S11 Number</label>
                                    <input type="text" name="s11_number" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">S12 Number</label>
                                    <input type="text" name="s12_number" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark">BAAN Cylinder Code</label>
                                    <input type="text" name="baan_cylinder" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: INK & COLOUR SPECS -->
                        <div class="tab-pane fade" id="ink-pane" role="tabpanel" aria-labelledby="ink-tab">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Sequence (Seq)</label>
                                    <input type="text" name="sequence_seq" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Colour Info</label>
                                    <input type="text" name="colour" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Film Number</label>
                                    <input type="text" name="film_number" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Ink System</label>
                                    <input type="text" name="ink_system" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">Ink Code</label>
                                    <input type="text" name="ink_code" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark">BAAN Ink Code</label>
                                    <input type="text" name="baan_ink_code" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Supplier Ink Name</label>
                                    <input type="text" name="supplier_ink" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Angle / Anilox</label>
                                    <input type="text" name="angle_anilox" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Coverage (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="coverage_percent" class="form-control" placeholder="e.g. 75.50">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Usage (Kg/TH)</label>
                                    <input type="number" step="0.01" min="0" name="usage_kg_th" class="form-control" placeholder="e.g. 1.25">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark">Main Design / Attachment (File Name/Url)</label>
                                    <input type="text" name="main_design_attachment" class="form-control" placeholder="Attachment path/file name">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark">Remarks</label>
                                    <textarea name="remark" class="form-control" rows="3" placeholder="Write addition comments here..."></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top d-flex justify-content-between p-3">
                    <button type="button" class="btn btn-secondary px-4 fw-semibold" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm" style="background-color: #4154f1; border-color: #4154f1;">
                        <i class="bi bi-check-circle-fill me-1"></i>Save Specification
                    </button>
                </div>

            </form>
            
        </div>
    </div>
</div>