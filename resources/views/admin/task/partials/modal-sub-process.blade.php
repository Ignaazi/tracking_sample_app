@php 
    $subTypes = [
        'layout' => ['title' => 'Layout Management Process', 'short' => 'Layout', 'field' => 'layout_status'],
        'baan'   => ['title' => 'BaaN ERP System Mapping', 'short' => 'BaaN', 'field' => 'baan_status'],
        'promp'  => ['title' => 'Promp Quality Verification', 'short' => 'Promp', 'field' => 'promp_status'],
        'jobbag' => ['title' => 'Job Bag Production Release', 'short' => 'Job Bag', 'field' => 'job_bag_status']
    ];
@endphp

@foreach($subTypes as $key => $sub)
<div class="modal fade" id="subProcessModal{{ $task->id }}_{{ $key }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-3 text-start">
            
            <div class="modal-header border-bottom px-4 py-3 bg-white align-items-center">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-1 font-monospace" style="font-size: 10px; font-weight: 700;">FEATURE SUB-PROCESS</span>
                    <h5 class="modal-title fw-bold" style="font-size: 18px; color: #012970;">{{ $task->project_name }} / <span class="text-primary">{{ $sub['short'] }}</span></h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.task.update', $task->id) }}" method="POST">
                @csrf @method('PUT')
                
                <input type="hidden" name="project_name" value="{{ $task->project_name }}">
                <input type="hidden" name="status" value="{{ $task->status }}">

                <div class="modal-body p-4 bg-white" style="font-size: 13px;">
                    <div class="row g-4">
                        
                        <div class="col-lg-8 border-end pe-lg-4">
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2 text-muted fw-bold" style="font-size: 12px;">
                                    <i class="fa-solid fa-align-left"></i> Description & Specs Info
                                </div>
                                <p class="text-secondary bg-light p-3 rounded-3" style="line-height: 1.6; font-size: 13px; margin: 0;">
                                    Proses peninjauan dokumen teknis untuk item <strong class="text-dark">{{ $task->item_code }}</strong>. Pastikan pengerjaan disesuaikan dengan regulasi pasar ekspor/lokal wilayah <strong class="text-dark">{{ $task->market }}</strong>. Remark Tambahan: {{ $task->remark ?? '-' }}
                                </p>
                            </div>

                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2 text-muted fw-bold" style="font-size: 12px;">
                                        <i class="fa-regular fa-square-check"></i> Checklist Standard Product (6/8)
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-2.5 ps-1">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" checked id="chk1_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-dark fw-semibold" for="chk1_{{ $task->id }}_{{ $key }}">Set up master dimensional layout parameter</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" checked id="chk2_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-dark fw-semibold" for="chk2_{{ $task->id }}_{{ $key }}">Create notification & verification model code</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" checked id="chk3_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-dark fw-semibold" for="chk3_{{ $task->id }}_{{ $key }}">Build specification API endpoints inside system</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" checked id="chk4_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-dark fw-semibold" for="chk4_{{ $task->id }}_{{ $key }}">Implement real-time updates validation tracking</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" checked id="chk5_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-dark fw-semibold" for="chk5_{{ $task->id }}_{{ $key }}">Create notification center UI inside workspace template</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" checked id="chk6_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-dark fw-semibold" for="chk6_{{ $task->id }}_{{ $key }}">Add registration item badges & parameters mapping</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" id="chk7_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-secondary" for="chk7_{{ $task->id }}_{{ $key }}">Implement final push validation routing control</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input shadow-none cursor-pointer p-2" type="checkbox" id="chk8_{{ $task->id }}_{{ $key }}">
                                        <label class="form-check-label text-secondary" for="chk8_{{ $task->id }}_{{ $key }}">Add user notification preference validation settings</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <div class="d-flex align-items-center gap-2 text-muted fw-bold mb-3" style="font-size: 12px;">
                                    <i class="fa-regular fa-comment-dots"></i> Comments (2)
                                </div>
                                <div class="d-flex flex-column gap-3 mb-3">
                                    <div class="d-flex gap-2.5 align-items-start">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white bg-primary" style="width: 32px; height: 32px; font-size: 11px;">MJ</div>
                                        <div>
                                            <div style="font-size: 12px;"><strong class="text-dark">Mike Johnson</strong> <span class="text-muted ms-1">2 hours ago</span></div>
                                            <p class="text-secondary m-0" style="font-size: 12.5px;">{{ $sub['short'] }} implementation is complete. Moving to UI components.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <input type="text" class="form-control form-control-sm border shadow-none rounded-2 text-comment-input" placeholder="Write a comment response...">
                                    <button type="button" class="btn btn-sm btn-primary px-3 rounded-2 btn-send-comment" style="background-color: #4154f1;"><i class="fa-regular fa-paper-plane"></i></button>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 ps-lg-4">
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-1.5 text-muted fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-circle-nodes"></i> SUB-PROCESS STATUS
                                </div>
                                <select name="{{ $sub['field'] }}" class="form-select border shadow-none fw-bold text-dark" style="font-size: 13.5px;" required>
                                    <option value="Pending" {{ $task->{$sub['field']} == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $task->{$sub['field']} == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ $task->{$sub['field']} == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-1.5 text-muted fw-bold mb-2.5" style="font-size: 11px; letter-spacing: 0.5px;">
                                    <i class="fa-regular fa-user"></i> ASSIGNEES IN PROJECT
                                </div>
                                <div class="d-flex flex-column gap-2.5">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white bg-primary" style="width: 28px; height: 28px; font-size: 10px;">MJ</div>
                                        <span class="fw-semibold text-dark" style="font-size: 13px;">Mike Johnson</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-top bg-light py-2 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-2 border-0" onclick="if(confirm('Delete node parameters?')) alert('Deleted');"><i class="fa-regular fa-trash-can me-1"></i> Delete</button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-secondary rounded-2 px-3" data-bs-dismiss="modal" style="background-color: #f1f5f9; color: #4b5563; border:none;">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4" style="background-color: #4154f1; border:none;"><i class="fa-regular fa-floppy-disk me-1"></i> Save Progress</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach