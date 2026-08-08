@if($taskList->isEmpty())
    <div class="card border-0 shadow-sm p-5 text-center text-muted" style="font-family: 'Nunito', sans-serif;">
        <i class="fa-solid fa-folder-open fs-1 mb-3 text-secondary"></i>
        <h6 class="fw-bold">Tidak ada project di status ini, bor!</h6>
    </div>
@else
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-custom-spec">
                    <thead>
                        <tr>
                            <th style="width: 130px;">Item Code</th>
                            <th>Project & Customer</th>
                            <th>Market</th>
                            <th>TD</th>
                            <th>Board</th>
                            <th>CS Brand</th>
                            <th>CS HW</th>
                            <th>Registered Specs</th>
                            <th style="width: 140px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taskList as $task)
                        <tr>
                            <td>
                                <span class="badge rounded-pill bg-light border border-dark text-dark font-monospace px-2.5 py-1.5" style="font-size: 12px;">
                                    <i class="fa-solid fa-barcode me-1 text-success"></i> {{ $task->item_code }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold d-block text-dark">{{ $task->project_name }}</span>
                                <small class="text-muted" style="font-size: 11px;">Customer: {{ $task->customer }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border border-dark px-2 py-1">{{ $task->market ?? '-' }}</span></td>
                            <td>{{ $task->td ?? '-' }}</td>
                            <td>{{ $task->board ?? '-' }}</td>
                            <td>{{ $task->cs_brand ?? '-' }}</td>
                            <td>{{ $task->cs_hw ?? '-' }}</td>
                            <td>
                                @if($task->itemSpecs->count() > 0)
                                    <span class="badge bg-success text-white font-monospace px-2 py-1">
                                        <i class="fa-solid fa-palette me-1"></i> {{ $task->itemSpecs->count() }} Colors/Specs
                                    </span>
                                @else
                                    <span class="text-muted small" style="font-size: 11px;">No Sequences</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-info text-white p-1 px-2" data-bs-toggle="modal" data-bs-target="#previewTaskModal{{ $task->id ?? $loop->index }}" title="Preview Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning text-dark p-1 px-2" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id ?? $loop->index }}" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.item-specs.destroy', $task->id ?? 0) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger p-1 px-2" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- NESTED SUB-TABLE PRINTING & INK SPECS -->
                        @if($task->itemSpecs->isNotEmpty())
                        <tr style="background-color: #f4fbf7;">
                            <td colspan="9" class="p-3">
                                <div class="border border-success rounded bg-white p-3 shadow-sm">
                                    <div class="fw-bold text-success mb-2 text-start" style="font-size: 12px; font-family: 'Nunito', sans-serif;">
                                        <i class="fa-solid fa-palette me-1"></i> PRINTING COLOUR & INK SPECIFICATIONS FOR [{{ $task->item_code }}]:
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered align-middle mb-0 table-custom-spec" style="font-size: 12px;">
                                            <thead>
                                                <tr style="background-color: #198754 !important;">
                                                    <th style="width: 80px;">Sequence</th>
                                                    <th>Colour</th>
                                                    <th>BAAN Cylinder</th>
                                                    <th>Film No.</th>
                                                    <th>Ink System</th>
                                                    <th>Ink Code</th>
                                                    <th>Supplier</th>
                                                    <th>BAAN Ink Code</th>
                                                    <th>Coverage (%)</th>
                                                    <th>Usage (Kg/TH)</th>
                                                    <th>Angle / Anilox</th>
                                                    <th>Attachment</th>
                                                    <th>Status</th>
                                                    <th style="width: 100px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($task->itemSpecs->sortBy('sequence') as $spec)
                                                <tr>
                                                    <td><span class="badge bg-dark rounded-pill px-2 py-1">Seq {{ $spec->sequence }}</span></td>
                                                    <td class="fw-bold text-start ps-2">{{ $spec->colour }}</td>
                                                    <td><code>{{ $spec->baan_cylinder ?? '-' }}</code></td>
                                                    <td>{{ $spec->film_number ?? '-' }}</td>
                                                    <td>{{ $spec->ink_system ?? '-' }}</td>
                                                    <td><span class="badge bg-light text-dark border border-dark">{{ $spec->ink_code ?? '-' }}</span></td>
                                                    <td><span class="badge bg-secondary">{{ $spec->supplier_ink ?? '-' }}</span></td>
                                                    <td><code>{{ $spec->baan_ink_code ?? '-' }}</code></td>
                                                    <td>{{ $spec->coverage ? $spec->coverage . '%' : '-' }}</td>
                                                    <td>{{ $spec->usage_kg_th ? number_format($spec->usage_kg_th, 2) : '-' }}</td>
                                                    <td>{{ $spec->angle_anilox ?? '-' }}</td>
                                                    <td>
                                                        @if($spec->main_design_attachment)
                                                            <a href="{{ asset($spec->main_design_attachment) }}" target="_blank" class="btn btn-xs btn-outline-success p-0 px-1" title="View Document">
                                                                <i class="fa-solid fa-paperclip me-1"></i> File
                                                            </a>
                                                        @else
                                                            <span class="text-muted" style="font-size: 10px;">None</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($spec->project_status == 'Completed')
                                                            <span class="badge bg-success">Completed</span>
                                                        @elseif($spec->project_status == 'Progress')
                                                            <span class="badge bg-warning text-dark">Progress</span>
                                                        @else
                                                            <span class="badge bg-secondary">To Do</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <button class="btn btn-sm btn-info text-white p-1 px-2" data-bs-toggle="modal" data-bs-target="#previewSpecModal{{ $spec->id }}" title="Preview Spec">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-warning text-dark p-1 px-2" data-bs-toggle="modal" data-bs-target="#editSpecModal{{ $spec->id }}" title="Edit Spec">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif