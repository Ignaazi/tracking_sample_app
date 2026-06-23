<!-- Modal Create Task / Project -->
<div class="modal fade" id="addTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true" style="font-family: 'Nunito', sans-serif;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- HEADER MODAL -->
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="addTaskModalLabel" style="color: #012970; font-size: 19px;">
                    <i class="fa-solid fa-folder-plus text-primary me-2"></i>Create New Project Node
                </h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.task.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    
                    <!-- BARIS 1: DATA UTAMA PROYEK -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">Project Name</label>
                            <input type="text" name="project_name" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" placeholder="e.g. Neo Pack Production" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">Item Code (SAP Code)</label>
                            <input type="text" name="item_code" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" placeholder="e.g. 123-123" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">SAP Number</label>
                            <input type="text" name="sap_number" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" placeholder="e.g. 000-000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">Customer / Client</label>
                            <input type="text" name="customer" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" placeholder="e.g. Unilever" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">Brand Family</label>
                            <input type="text" name="brand_family" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" placeholder="e.g. Pepsodent">
                        </div>
                    </div>

                    <!-- BARIS 2: METADATA & PIPELINE MANAGEMENT -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">Market Distribution</label>
                            <input type="text" name="market" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" placeholder="e.g. INDO / EXPORT">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">Start Date</label>
                            <input type="date" name="start_date" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">End Date / Target</label>
                            <input type="date" name="end_date" class="form-control rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" required>
                        </div>
                    </div>

                    <!-- ==================================================== -->
                    <!-- KEBUTUHAN UTAMA: 4 GRID POINT SEJAJAR KE BAWAH/SAMPING -->
                    <!-- ==================================================== -->
                    <div class="p-3 bg-light rounded-4 border mb-2">
                        <span class="d-block fw-bold mb-3" style="font-size: 13.5px; color: #012970;">
                            <i class="fa-solid fa-sliders text-primary me-1"></i> Core Sub-Process Initialization Matrix
                        </span>
                        
                        <div class="row g-3">
                            <!-- GRID 1: LAYOUT STATUS -->
                            <div class="col-md-3 col-sm-6">
                                <div class="card border p-3 bg-white shadow-xs rounded-3 text-center h-100">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 38px; height: 38px;">
                                        <i class="fa-solid fa-layer-group" style="font-size: 14px;"></i>
                                    </div>
                                    <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">1. LAYOUT (LYO)</label>
                                    <select name="layout_status" class="form-select form-select-sm rounded-2 border shadow-none mt-auto" style="font-size: 12px; font-weight: 600;">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <!-- GRID 2: BAAN STATUS -->
                            <div class="col-md-3 col-sm-6">
                                <div class="card border p-3 bg-white shadow-xs rounded-3 text-center h-100">
                                    <div class="rounded-circle bg-purple bg-opacity-10 text-purple mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 38px; height: 38px; color: #a855f7; background-color: #f3e8ff;">
                                        <i class="fa-solid fa-server" style="font-size: 14px;"></i>
                                    </div>
                                    <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">2. BAAN ERP</label>
                                    <select name="baan_status" class="form-select form-select-sm rounded-2 border shadow-none mt-auto" style="font-size: 12px; font-weight: 600;">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <!-- GRID 3: PROMP STATUS -->
                            <div class="col-md-3 col-sm-6">
                                <div class="card border p-3 bg-white shadow-xs rounded-3 text-center h-100">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 38px; height: 38px; color: #d97706; background-color: #fef3c7;">
                                        <i class="fa-solid fa-bolt" style="font-size: 14px;"></i>
                                    </div>
                                    <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">3. PROMP (PRMP)</label>
                                    <select name="promp_status" class="form-select form-select-sm rounded-2 border shadow-none mt-auto" style="font-size: 12px; font-weight: 600;">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <!-- GRID 4: JOB BAG STATUS -->
                            <div class="col-md-3 col-sm-6">
                                <div class="card border p-3 bg-white shadow-xs rounded-3 text-center h-100">
                                    <div class="rounded-circle bg-success bg-opacity-10 text-success mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 38px; height: 38px; color: #16a34a; background-color: #dcfce7;">
                                        <i class="fa-solid fa-briefcase" style="font-size: 14px;"></i>
                                    </div>
                                    <label class="form-label fw-bold text-dark mb-1" style="font-size: 12.5px;">4. JOB BAG (BAG)</label>
                                    <select name="job_bag_status" class="form-select form-select-sm rounded-2 border shadow-none mt-auto" style="font-size: 12px; font-weight: 600;">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KANBAN INITIAL COLUMN PIPELINE STAGE -->
                    <div class="mt-3">
                        <label class="form-label fw-bold text-secondary mb-1" style="font-size: 12.5px;">Initial Kanban Pipeline Stage</label>
                        <select name="status" class="form-select rounded-3 py-2 px-3 shadow-none border" style="font-size: 13.5px;" required>
                            <option value="todo" selected>To Do Stack</option>
                            <option value="in_progress">In Progress Dev</option>
                            <option value="ready_qa">Ready for QA Testing</option>
                            <option value="completed">Completed Deployment</option>
                        </select>
                    </div>

                </div>

                <!-- FOOTER TOMBOL MODAL -->
                <div class="modal-footer border-0 pt-0 pb-4 px-4 gap-2">
                    <button type="button" class="btn btn-light rounded-3 fw-bold px-3 py-2" style="font-size: 13px; color: #475569;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4 py-2 border-0 shadow-sm" style="background-color: #4154f1; font-size: 13px;">
                        <i class="fa-solid fa-square-check me-1"></i> Register Node Project
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>