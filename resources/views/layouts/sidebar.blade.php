<aside class="sidebar d-flex flex-column justify-content-between">
    <ul class="sidebar-nav d-flex flex-column gap-1">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : 'collapsed' }}" href="{{ route('admin.users.index') }}">
                <i class="fa-solid fa-users"></i>
                <span>Management User</span>
            </a>
        </li>

        <li class="nav-heading mt-3 mb-1 text-muted px-3" style="font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Tracking System</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.timelines.*') ? 'active' : 'collapsed' }}" href="{{ route('admin.timelines.index') }}">
                <i class="fa-solid fa-timeline"></i>
                <span> Timeline Project</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : 'collapsed' }}" href="{{ route('admin.tasks.index') ?? '#' }}">
                <i class="fa-solid fa-list-check"></i>
                <span>Task List</span>
            </a>
        </li>

    </ul>

    <div class="sidebar-footer border rounded p-2 bg-light shadow-sm d-flex align-items-center">
        <div class="d-flex align-items-center gap-2 w-100">
            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 34px; height: 34px; min-width: 34px;">
                <i class="fa-solid fa-user" style="font-size: 13px;"></i>
            </div>
            <div class="overflow-hidden">
                <span class="d-block fw-bold text-dark lh-1 text-truncate" style="font-size: 13px;">{{ Auth::user()->name }}</span>
                <small class="text-muted text-truncate d-block" style="font-size: 10px; text-transform: uppercase; margin-top: 2px;">{{ Auth::user()->role }}</small>
            </div>
        </div>
    </div>
</aside>