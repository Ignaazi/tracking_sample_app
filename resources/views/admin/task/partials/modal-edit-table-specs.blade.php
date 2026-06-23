<div class="modal fade" id="editTaskModalTable{{ $task->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" style="font-family: 'Nunito', sans-serif;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3 text-start">
            
            <div class="modal-header border-0 bg-light py-3 px-4">
                <h5 class="modal-title fw-bold" style="font-size: 16px; color: #012970;"><i class="bi bi-sliders text-primary me-2"></i>Edit Specifications (Table View Mode)</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.task.update', $task->id) }}" method="POST">
                @csrf 
                @method('PUT')
                
                <div class="modal-body p-4" style="font-size: 13.5px;">
                    <div class="row g-3">
                        
                        <div class="col-12 mt-1 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-primary" style="font-size: 12px; uppercase; tracking-wider;"><i class="bi bi-info-circle me-1"></i> Core Project Identity</span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Project Name</label>
                            <input type="text" name="project_name" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->project_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Customer ID</label>
                            <input type="text" name="customer" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->customer }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Brand Family</label>
                            <input type="text" name="brand_family" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->brand_family }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Market</label>
                            <input type="text" name="market" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->market }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Item Code</label>
                            <input type="text" name="item_code" class="form-control rounded-3 border shadow-none py-2 font-monospace" value="{{ $task->item_code }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">SAP Number</label>
                            <input type="text" name="sap_number" class="form-control rounded-3 border shadow-none py-2 font-monospace" value="{{ $task->sap_number }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Dev Status</label>
                            <select name="development_status" class="form-select rounded-3 border shadow-none py-2 fw-semibold text-dark" required>
                                <option value="Active" {{ $task->development_status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Testing" {{ $task->development_status == 'Testing' ? 'selected' : '' }}>Testing</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Status Board Utama</label>
                            <select name="status" class="form-select rounded-3 border shadow-none py-2 fw-bold text-dark" required>
                                <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Ready for QA" {{ $task->status == 'Ready for QA' ? 'selected' : '' }}>Ready for QA</option>
                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-warning" style="font-size: 12px; uppercase; tracking-wider;"><i class="bi bi-grid-3x3-gap me-1"></i> Technical Sub-Process Tracking</span>
                        </div>

                        <div class="col-md-3 col-6">
                            <label class="form-label fw-bold text-secondary">Layout Status</label>
                            <select name="layout_status" class="form-select rounded-3 border shadow-none py-2 fw-semibold text-dark" required>
                                <option value="Pending" {{ $task->layout_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $task->layout_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $task->layout_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label fw-bold text-secondary">Baan Status</label>
                            <select name="baan_status" class="form-select rounded-3 border shadow-none py-2 fw-semibold text-dark" required>
                                <option value="Pending" {{ $task->baan_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $task->baan_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $task->baan_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label fw-bold text-secondary">Promp Status</label>
                            <select name="promp_status" class="form-select rounded-3 border shadow-none py-2 fw-semibold text-dark" required>
                                <option value="Pending" {{ $task->promp_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $task->promp_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $task->promp_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label fw-bold text-secondary">Job Bag Status</label>
                            <select name="job_bag_status" class="form-select rounded-3 border shadow-none py-2 fw-semibold text-dark" required>
                                <option value="Pending" {{ $task->job_bag_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $task->job_bag_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $task->job_bag_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-success" style="font-size: 12px; uppercase; tracking-wider;"><i class="bi bi-cpu me-1"></i> Technical Mapped Parameters</span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Ascis PD</label>
                            <input type="text" name="ascis_pd" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->ascis_pd }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">CS Brand</label>
                            <input type="text" name="cs_brand" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->cs_brand }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">CS HW</label>
                            <input type="text" name="cs_hw" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->cs_hw }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">GHW Set</label>
                            <input type="text" name="ghw_set" class="form-control rounded-3 border shadow-none py-2" value="{{ $task->ghw_set }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary">Remark Notes</label>
                            <textarea name="remark" class="form-control rounded-3 border shadow-none" rows="2" placeholder="Add engineering specific updates...">{{ $task->remark }}</textarea>
                        </div>

                    </div>
                </div>
                
                <div class="modal-footer border-0 bg-light py-2 px-4">
                    <button type="button" class="btn btn-sm btn-secondary rounded-2 px-3 fw-semibold" data-bs-dismiss="modal" style="background-color: #fff; color: #475569; border: 1px solid #cbd5e1;">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4 fw-bold shadow-sm" style="background-color: #4154f1; border: none;">Save Modifications</button>
                </div>
                
            </form>
        </div>
    </div>
</div>