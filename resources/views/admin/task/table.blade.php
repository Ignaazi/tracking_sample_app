@extends('layouts.admin')

@section('title', 'Data Project Status - NiceAdmin')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@section('content')
<main id="main" class="main" style="font-family: 'Nunito', sans-serif; background-color: #f6f9ff; min-height: 100vh;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 style="font-size: 22px; font-weight: 700; color: #212529; margin: 0 0 4px 0;">Data Project Status</h1>
            <p class="text-muted m-0" style="font-size: 13.5px;">Track and manage customer database records individually per entity</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white bg-white border rounded-3 btn-sm fw-semibold px-3 py-2 d-flex align-items-center gap-2" style="font-size: 13px; color: #212529; font-family: 'Nunito', sans-serif;">
                <i class="bi bi-download"></i> Export
            </button>
            <a href="{{ route('admin.task.index') }}" class="btn btn-primary rounded-3 btn-sm fw-semibold px-3 py-2 d-flex align-items-center gap-2" style="font-size: 13px; background-color: #4154f1; border-color: #4154f1; font-family: 'Nunito', sans-serif;">
                <i class="bi bi-grid-3x3-gap-fill"></i> Switch to Kanban
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm rounded-3" role="alert" style="background-color: #e8f5e9; color: #1b5e20; font-size: 13.5px; font-family: 'Nunito', sans-serif;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2" style="font-size: 14px; color: #212529;">
                <select class="form-select border rounded-3 shadow-none text-center" style="width: 80px; height: 38px; font-size: 14px; font-family: 'Nunito', sans-serif; color: #212529;">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-secondary">entries per page sebelum ke slide selanjutnya</span>
            </div>
            
            <div style="width: 260px;">
                <input type="text" class="form-control border rounded-3 shadow-none" placeholder="Search orders..." style="height: 38px; font-size: 14px; padding-left: 15px; font-family: 'Nunito', sans-serif; color: #212529;">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0" style="font-size: 14px; min-width: 1350px; --bs-table-hover-bg: #f8fafc; font-family: 'Nunito', sans-serif;">
                <thead style="background-color: #f3f6f9; color: #212529; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 ps-3" style="border-bottom: 2px solid #cbd5e1; width: 60px;">No</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1;">Project Name</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1;">Customer ID</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1;">Brand Family</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1;">Market</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1;">Item Code</th>
                        <th class="py-3" style="border-bottom: 2px solid #cbd5e1;">SAP Number</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1;">Layout Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1;">Baan Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1;">Promp Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1;">Job Bag Status</th>
                        <th class="py-3 text-center" style="border-bottom: 2px solid #cbd5e1; width: 140px;">Main Status</th>
                        <th class="py-3 text-end pe-3" style="border-bottom: 2px solid #cbd5e1; width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $index => $task)
                    <tr style="border-bottom: 1px solid #e9ecef; color: #212529;">
                        <td class="py-3 ps-3 fw-semibold text-dark" style="font-size: 13.5px;">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        
                        <td class="py-3 fw-bold" style="color: #212529;">{{ $task->project_name }}</td>
                        
                        <td class="py-3 fw-bold" style="color: #212529;">{{ $task->customer }}</td>

                        <td class="py-3 fw-semibold" style="color: #212529;">{{ $task->brand_family ?? '-' }}</td>

                        <td class="py-3 fw-semibold" style="color: #212529;">
                            {{ $task->market ?? '-' }}
                        </td>

                        <td class="py-3 fw-bold" style="font-size: 13.5px; color: #212529;">
                            {{ $task->item_code }}
                        </td>

                        <td class="py-3 fw-semibold" style="font-size: 13.5px; color: #212529;">
                            {{ $task->sap_number ?? '-' }}
                        </td>

                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px; font-family: 'Nunito', sans-serif;
                                {{ $task->layout_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->layout_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->layout_status ?? 'Pending' }}
                            </span>
                        </td>

                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px; font-family: 'Nunito', sans-serif;
                                {{ $task->baan_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->baan_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->baan_status ?? 'Pending' }}
                            </span>
                        </td>

                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px; font-family: 'Nunito', sans-serif;
                                {{ $task->promp_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->promp_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->promp_status ?? 'Pending' }}
                            </span>
                        </td>

                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2.5 py-1" style="font-size: 11.5px; font-family: 'Nunito', sans-serif;
                                {{ $task->job_bag_status == 'Completed' ? 'background-color: #e8f5e9; color: #2e7d32;' : ($task->job_bag_status == 'In Progress' ? 'background-color: #fff7ed; color: #ea580c;' : 'background-color: #f1f5f9; color: #64748b;') }}">
                                {{ $task->job_bag_status ?? 'Pending' }}
                            </span>
                        </td>

                        <td class="text-center py-3">
                            @php
                                $statusStyle = [
                                    'To Do'        => ['bg' => '#f1f5f9', 'text' => '#475569'],
                                    'In Progress' => ['bg' => '#fff7ed', 'text' => '#ea580c'],
                                    'Ready for QA'=> ['bg' => '#eff6ff', 'text' => '#2563eb'],
                                    'Completed'   => ['bg' => '#e8f5e9', 'text' => '#2e7d32']
                                ];
                                $style = $statusStyle[$task->status] ?? ['bg' => '#f8fafc', 'text' => '#64748b'];
                            @endphp
                            <span class="badge rounded px-2.5 py-1.5 fw-bold d-block text-center" style="background-color: {{ $style['bg'] }}; color: {{ $style['text'] }}; font-size: 12px; letter-spacing: 0.3px; font-family: 'Nunito', sans-serif;">
                                {{ $task->status }}
                            </span>
                        </td>

                        <td class="text-end py-3 pe-3">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editTaskModalTable{{ $task->id }}" class="btn btn-sm text-dark d-flex align-items-center justify-content-center shadow-none border-0" style="width: 32px; height: 32px; border-radius: 6px; background-color: #ffc107;" title="Edit Record">
                                    <i class="bi bi-pencil-square" style="font-size: 14px; display: inline-block;"></i>
                                </button>
                                <button type="button" onclick="event.preventDefault(); if(confirm('Delete project data permanently?')) document.getElementById('delete-table-task-{{ $task->id }}').submit();" class="btn btn-sm text-white d-flex align-items-center justify-content-center shadow-none border-0" style="width: 32px; height: 32px; border-radius: 6px; background-color: #dc3545;" title="Delete Record">
                                    <i class="bi bi-trash3-fill" style="font-size: 14px; display: inline-block;"></i>
                                </button>
                            </div>
                            <form id="delete-table-task-{{ $task->id }}" action="{{ route('admin.task.destroy', $task->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center py-5 text-muted" style="font-style: italic; font-family: 'Nunito', sans-serif;">
                            <i class="bi bi-inbox d-block mb-2 opacity-40" style="font-size: 28px;"></i>
                            No individual project data entries stored inside database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3" style="font-size: 14px; color: #212529; font-family: 'Nunito', sans-serif;">
            <div class="fw-semibold">
                Showing 1 to {{ min($tasks->count(), 25) }} of {{ $tasks->count() }} entries
            </div>
            
            <nav>
                <ul class="pagination pagination-sm m-0 gap-2">
                    <li class="page-item disabled">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14); opacity: 0.6;" href="#">
                            <i class="bi bi-chevron-left" style="font-size: 14px; display: inline-block;"></i>
                        </a>
                    </li>

                    <li class="page-item active">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            1
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            2
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 800; font-size: 14px; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            3
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link d-flex align-items-center justify-content-center shadow-none text-white border-0" 
                           style="width: 36px; height: 36px; border-radius: 6px; font-weight: 700; background: linear-gradient(135deg, #012970, #00b4d8, #39ff14);" href="#">
                            <i class="bi bi-chevron-right" style="font-size: 14px; display: inline-block;"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>

</main>

@foreach($tasks as $task)
    @include('admin.task.partials.modal-edit-table-specs')
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection