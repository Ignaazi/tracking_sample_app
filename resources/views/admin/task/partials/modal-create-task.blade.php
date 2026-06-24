<div class="modal fade" id="addTaskModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header border-0 bg-light py-3">
                <h5 class="modal-title fw-bold" style="font-size: 15px; color: #012970 !important;"><i class="fa-solid fa-calendar-plus text-primary me-2"></i>Initialize New Project Node</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.task.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4" style="font-size: 13px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Project Name</label>
                            <input type="text" name="project_name" class="form-control rounded border shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Customer</label>
                            <input type="text" name="customer" class="form-control rounded border shadow-none" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Item Code</label>
                            <input type="text" name="item_code" class="form-control rounded border shadow-none" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">SAP Number</label>
                            <input type="text" name="sap_number" class="form-control rounded border shadow-none" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Brand Family</label>
                            <input type="text" name="brand_family" class="form-control rounded border shadow-none" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Market</label>
                            <input type="text" name="market" class="form-control rounded border shadow-none" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Ascis PD</label>
                            <input type="text" name="ascis_pd" class="form-control rounded border shadow-none">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">CS Brand</label>
                            <input type="text" name="cs_brand" class="form-control rounded border shadow-none">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">CS HW</label>
                            <input type="text" name="cs_hw" class="form-control rounded border shadow-none">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">GHW Set</label>
                            <input type="text" name="ghw_set" class="form-control rounded border shadow-none">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Initial Board Pillar</label>
                            <select name="status" class="form-select rounded border shadow-none" required>
                                <option value="To Do" selected>To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Ready for QA">Ready for QA</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Development Status</label>
                            <select name="development_status" class="form-select rounded border shadow-none" required>
                                <option value="Active" selected>Active</option>
                                <option value="Testing">Testing</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary">Remark</label>
                            <textarea name="remark" class="form-control rounded border shadow-none" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-2">
                    <button type="button" class="btn btn-sm btn-secondary rounded-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4" style="background-color: #4154f1; border:none;">Push Project</button>
                </div>
            </form>
        </div>
    </div>
</div>