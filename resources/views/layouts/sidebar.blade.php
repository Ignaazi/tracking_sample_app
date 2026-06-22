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

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.emails.*') ? 'active' : 'collapsed' }}" href="{{ route('admin.emails.index') }}">
                <i class="fa-solid fa-envelope"></i>
                <span>Email Inbox</span>
            </a>
        </li>

    </ul>

</aside>