@if(isset($task) && isset($task->id))
<div class="modal fade" id="editTableTaskModal{{ $task->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-3 text-start">
            <div class="modal-header border-0 bg-light py-3 px-4">
                <h5 class="modal-title fw-bold" style="font-size: 16px; color: #012970;"><i class="bi bi-sliders text-primary me-2"></i>Edit Specifications (Table View Mode)</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            {{-- Pengaman Parameter Rute Eksplisit --}}
            <form action="{{ route('admin.task.update', ['id' => $task->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                
                <div class="modal-body p-4" style="font-size: 13.5px;">
                    <div class="row g-3">
                        
                        <div class="col-12 mt-1 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-primary" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="bi bi-info-circle me-1"></i> Core Project Identity</span>
                        </div>

                        <!-- CORE IDENTITIES -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Project Name</label>
                            <input type="text" name="project_name" class="form-control rounded border shadow-none" value="{{ $task->project_name }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Customer</label>
                            <input type="text" name="customer" class="form-control rounded border shadow-none" value="{{ $task->customer }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Item Code</label>
                            <input type="text" name="item_code" class="form-control rounded border shadow-none" value="{{ $task->item_code }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Brand / Family</label>
                            <input type="text" name="brand_family" class="form-control rounded border shadow-none" value="{{ $task->brand_family }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Market</label>
                            <select name="market" class="form-select rounded border shadow-none">
                                <option value="INDO" {{ ($task->market ?? 'INDO') == 'INDO' ? 'selected' : '' }}>INDO</option>
                                <option value="EXPORT" {{ ($task->market ?? '') == 'EXPORT' ? 'selected' : '' }}>EXPORT</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Workflow Status</label>
                            <select name="status" class="form-select rounded border shadow-none" required>
                                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                                <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <!-- SPECIFICATION DETAILS -->
                        <div class="col-12 mt-4 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-primary" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="bi bi-gear me-1"></i> Technical Specifications</span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">CS Brand</label>
                            <input type="text" name="cs_brand" class="form-control rounded border shadow-none" value="{{ $task->cs_brand }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">CS HW</label>
                            <input type="text" name="cs_hw" class="form-control rounded border shadow-none" value="{{ $task->cs_hw }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">CPI HW</label>
                            <input type="text" name="cpi_hw" class="form-control rounded border shadow-none" value="{{ $task->cpi_hw }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">PD ASCIS</label>
                            <input type="text" name="ascis_pd" class="form-control rounded border shadow-none" value="{{ $task->ascis_pd }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">S5 Internal Approval</label>
                            <input type="text" name="s5_internal_approval" class="form-control rounded border shadow-none" value="{{ $task->s5_internal_approval }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">GHW Set</label>
                            <input type="text" name="ghw_set" class="form-control rounded border shadow-none" value="{{ $task->ghw_set }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">COI Number</label>
                            <input type="text" name="coi_number" class="form-control rounded border shadow-none" value="{{ $task->coi_number }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Green Light</label>
                            <input type="text" name="green_light" class="form-control rounded border shadow-none" value="{{ $task->green_light }}">
                        </div>

                        <!-- TIMELINES -->
                        <div class="col-12 mt-4 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-primary" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="bi bi-calendar-event me-1"></i> Timelines</span>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Information Received Date</label>
                            <input type="date" name="information_received" class="form-control rounded border shadow-none" value="{{ $task->information_received ? \Carbon\Carbon::parse($task->information_received)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">PLM Released Date</label>
                            <input type="date" name="plm_released" class="form-control rounded border shadow-none" value="{{ $task->plm_released ? \Carbon\Carbon::parse($task->plm_released)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Target Date</label>
                            <input type="date" name="end_date" class="form-control rounded border shadow-none" value="{{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') : '' }}">
                        </div>

                        <!-- PRODUCTION BOARD & MACHINE -->
                        <div class="col-12 mt-4 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-primary" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="bi bi-cpu me-1"></i> Board & Machine Parameters</span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">TD (Technical Doc)</label>
                            <input type="text" name="td" class="form-control rounded border shadow-none" value="{{ $task->td }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Machine</label>
                            <input type="text" name="machine" class="form-control rounded border shadow-none" value="{{ $task->machine }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Board Type</label>
                            <input type="text" name="board" class="form-control rounded border shadow-none" value="{{ $task->board }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Board U Code</label>
                            <input type="text" name="board_u_code" class="form-control rounded border shadow-none" value="{{ $task->board_u_code }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">Board A Code</label>
                            <input type="text" name="board_a_code" class="form-control rounded border shadow-none" value="{{ $task->board_a_code }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">Type CM</label>
                            <input type="text" name="type_cm" class="form-control rounded border shadow-none" value="{{ $task->type_cm }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">Die Cut Number</label>
                            <input type="text" name="die_cut_number" class="form-control rounded border shadow-none" value="{{ $task->die_cut_number }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">S10 Number</label>
                            <input type="text" name="s10_number" class="form-control rounded border shadow-none" value="{{ $task->s10_number }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">S11 Number</label>
                            <input type="text" name="s11_number" class="form-control rounded border shadow-none" value="{{ $task->s11_number }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">S12 Number</label>
                            <input type="text" name="s12_number" class="form-control rounded border shadow-none" value="{{ $task->s12_number }}">
                        </div>

                        <!-- CYLINDER & COLOR -->
                        <div class="col-12 mt-4 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-primary" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="bi bi-paint-bucket me-1"></i> Cylinder & Color Specs</span>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Cylinder Supplier</label>
                            <input type="text" name="cylinder_supplier" class="form-control rounded border shadow-none" value="{{ $task->cylinder_supplier }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Repro By</label>
                            <input type="text" name="repro_by" class="form-control rounded border shadow-none" value="{{ $task->repro_by }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Sequence (Seq)</label>
                            <input type="text" name="sequence_seq" class="form-control rounded border shadow-none" value="{{ $task->sequence_seq }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Colour</label>
                            <input type="text" name="colour" class="form-control rounded border shadow-none" value="{{ $task->colour }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">BAAN Cylinder Code</label>
                            <input type="text" name="baan_cylinder" class="form-control rounded border shadow-none" value="{{ $task->baan_cylinder }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Film Number</label>
                            <input type="text" name="film_number" class="form-control rounded border shadow-none" value="{{ $task->film_number }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Ink System</label>
                            <input type="text" name="ink_system" class="form-control rounded border shadow-none" value="{{ $task->ink_system }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Ink Code</label>
                            <input type="text" name="ink_code" class="form-control rounded border shadow-none" value="{{ $task->ink_code }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">Supplier Ink</label>
                            <input type="text" name="supplier_ink" class="form-control rounded border shadow-none" value="{{ $task->supplier_ink }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-secondary">BAAN Ink Code</label>
                            <input type="text" name="baan_ink_code" class="form-control rounded border shadow-none" value="{{ $task->baan_ink_code }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">Coverage (%)</label>
                            <input type="number" name="coverage_percent" step="0.01" class="form-control rounded border shadow-none" value="{{ $task->coverage_percent }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">Usage (Kg/TH)</label>
                            <input type="number" name="usage_kg_th" step="0.01" class="form-control rounded border shadow-none" value="{{ $task->usage_kg_th }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-secondary">Angle / Anilox</label>
                            <input type="text" name="angle_anilox" class="form-control rounded border shadow-none" value="{{ $task->angle_anilox }}">
                        </div>

                        <!-- ATTACHMENTS & REMARKS -->
                        <div class="col-12 mt-4 mb-2 border-bottom pb-1">
                            <span class="fw-bold text-primary" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;"><i class="bi bi-paperclip me-1"></i> System Keys & Remarks</span>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">SAP Number</label>
                            <input type="text" name="sap_number" class="form-control rounded border shadow-none" value="{{ $task->sap_number }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Main Design / Attachment Link</label>
                            <input type="text" name="main_design_attachment" class="form-control rounded border shadow-none" value="{{ $task->main_design_attachment }}" placeholder="e.g. drive-link-file.pdf">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Remarks</label>
                            <input type="text" name="remark" class="form-control rounded border shadow-none" value="{{ $task->remark }}">
                        </div>

                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-sm btn-secondary rounded-2 px-3" data-bs-dismiss="modal" style="background-color: #e2e8f0; color: #475569; border: none;">Discard</button>
                    <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4" style="background-color: #4154f1; border: none;"><i class="bi bi-save me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif