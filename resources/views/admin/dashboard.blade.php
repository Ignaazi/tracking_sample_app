@extends('layouts.admin')

@section('title', 'Executive Operations Dashboard')

@section('content')

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-dark mb-1" style="font-size: 24px;">Executive Operations Dashboard</h1>
        <p class="text-muted mb-0" style="font-size: 13px;">Unified delivery, growth, and reliability signals for daily decision-making.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="background-color: #e1fcef; color: #0f5132;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #e0e7ff; color: #4154f1;">
                        <i class="fa-solid fa-cubes fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Total Development</small>
                        <span class="d-block fw-bold text-dark my-1" style="font-size: 20px;">148</span>
                        <small class="text-success fw-bold" style="font-size: 11px;"><i class="fa-solid fa-arrow-trend-up me-1"></i>12 New</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #fff9db 0%, #ffffff 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fff3bf; color: #f59f00;">
                        <i class="fa-solid fa-spinner fs-5 fa-spin-pulse"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Pending Tasks</small>
                        <span class="d-block fw-bold text-dark my-1" style="font-size: 20px;">24</span>
                        <small class="text-warning fw-bold" style="font-size: 11px;"><i class="fa-solid fa-clock me-1"></i>Awaiting Review</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #e0f2fe 0%, #ffffff 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #bae6fd; color: #0284c7;">
                        <i class="fa-solid fa-code-branch fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Active Projects</small>
                        <span class="d-block fw-bold text-dark my-1" style="font-size: 20px;">36</span>
                        <small class="text-info fw-bold" style="font-size: 11px;"><i class="fa-solid fa-gears me-1"></i>Under Development</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 p-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #eafaf1 0%, #ffffff 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #d1f7e3; color: #198754;">
                        <i class="fa-solid fa-circle-check fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Completed Projects</small>
                        <span class="d-block fw-bold text-dark my-1" style="font-size: 20px;">88</span>
                        <small class="text-success fw-bold" style="font-size: 11px;"><i class="fa-solid fa-check-double me-1"></i>100% Deployed</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">
        
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 fw-bold" style="color: #012970; font-size: 16px;">
                        <i class="fa-solid fa-table-list me-2 text-primary"></i>Performance Curve / Monitoring Table
                    </h5>
                    <div class="btn-group btn-group-sm rounded-pill border overflow-hidden" role="group">
                        <button type="button" class="btn btn-light px-3 active fw-bold text-primary bg-transparent border-0" style="font-size: 11px;">MONTH</button>
                        <button type="button" class="btn btn-light px-3 fw-bold text-muted bg-transparent border-0" style="font-size: 11px;">WEEK</button>
                        <button type="button" class="btn btn-light px-3 fw-bold text-muted bg-transparent border-0" style="font-size: 11px;">DAY</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                            <thead class="table-light text-muted" style="font-size: 12px; text-transform: uppercase;">
                                <tr>
                                    <th class="ps-3 py-3">Project Title</th>
                                    <th>Item Code (SAP)</th>
                                    <th>Brand</th>
                                    <th>Priority</th>
                                    <th class="pe-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($samples->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-folder-open fs-3 d-block mb-2 text-secondary"></i>
                                            Belum ada data sampel di database local, bor!
                                        </td>
                                    </tr>
                                @endif
                                @foreach($samples as $sample)
                                <tr>
                                    <td class="ps-3 fw-bold text-dark">{{ $sample->title }}</td>
                                    <td>
                                        <span class="badge font-monospace px-2 py-1.5 rounded" style="background-color: #e6f7ff; color: #055160; font-size: 12px;">
                                            {{ $sample->item_code }}
                                        </span>
                                    </td>
                                    <td class="text-secondary">{{ $sample->brand }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-light text-dark border px-2 py-1" style="font-size: 11px;">
                                            {{ $sample->priority ?? 'Normal' }}
                                        </span>
                                    </td>
                                    <td class="pe-3">
                                        <span class="badge px-2 py-1.5 rounded-pill" style="background-color: #fff3bf; color: #664d03; font-size: 11px; font-weight: 700;">
                                            {{ $sample->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm bg-white">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 fw-bold" style="color: #012970; font-size: 16px;">
                        Recent Activity <span class="text-muted fw-normal" style="font-size: 12px; display: block; margin-top: 2px;">Last 2 hours</span>
                    </h5>
                    <a href="#" class="text-decoration-none fw-bold" style="font-size: 12px; color: var(--nice-blue);">View</a>
                </div>
                <div class="card-body pt-0 px-3 pb-3">
                    
                    <div class="d-flex flex-column gap-2">
                        
                        <div class="p-2 border rounded-3 d-flex align-items-center gap-3 bg-light-subtle" style="font-size: 12.5px;">
                            <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #198754; min-width: 8px;"></span>
                            <span class="text-dark"><strong>Alex Thompson</strong> completed purchase workflow update.</span>
                        </div>

                        <div class="p-2 border rounded-3 d-flex align-items-center gap-3 bg-light-subtle" style="font-size: 12.5px;">
                            <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #0d6efd; min-width: 8px;"></span>
                            <span class="text-dark"><strong>Sarah Wilson</strong> submitted dashboard UX revisions.</span>
                        </div>

                        <div class="p-2 border rounded-3 d-flex align-items-center gap-3 bg-light-subtle" style="font-size: 12.5px;">
                            <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #ffc107; min-width: 8px;"></span>
                            <span class="text-dark">Storage usage crossed <strong>80%</strong> on media bucket.</span>
                        </div>

                        <div class="p-2 border rounded-3 d-flex align-items-center gap-3 bg-light-subtle" style="font-size: 12.5px;">
                            <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #0dcaf0; min-width: 8px;"></span>
                            <span class="text-dark">Deployment <strong>v3.2.1</strong> passed production checks.</span>
                        </div>

                        <div class="p-2 border rounded-3 d-flex align-items-center gap-3 bg-light-subtle" style="font-size: 12.5px;">
                            <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #20c997; min-width: 8px;"></span>
                            <span class="text-dark">New lead batch synced from CRM integrations.</span>
                        </div>

                        <div class="p-2 border rounded-3 d-flex align-items-center gap-3 bg-light-subtle" style="font-size: 12.5px;">
                            <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #dc3545; min-width: 8px;"></span>
                            <span class="text-dark" style="color: #851c26;">Billing retry required for invoice #INV-8043.</span>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection