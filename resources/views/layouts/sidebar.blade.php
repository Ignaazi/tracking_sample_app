<aside class="sidebar d-flex flex-column justify-content-between" style="font-family: 'Nunito', sans-serif; background-color: #ffffff; border-right: 1px solid #e2e8f5; height: 100vh; padding-top: 15px; width: 260px; transition: all 0.3s ease;">
    <ul class="sidebar-nav d-flex flex-column gap-1 list-unstyled px-1.5" style="margin: 0;">
  
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : 'collapsed' }}"
           href="{{ route('admin.dashboard') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-chart-pie me-2" style="font-size: 15px;"></i>
          <span>Dashboard</span>
          <span class="ms-auto fw-bold text-uppercase opacity-50" style="font-size: 10px; letter-spacing: 0.5px;">Home</span>
        </a>
      </li>
  
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('admin.users.*') ? 'active' : 'collapsed' }}"
           href="{{ route('admin.users.index') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-users me-2" style="font-size: 15px;"></i>
          <span>User Management</span>
        </a>
      </li>
  
      <li class="nav-heading mt-3 mb-2 px-2 d-flex align-items-center position-relative" style="height: 20px;">
        <span class="bg-white pe-2 text-muted fw-bold position-relative" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.8px; z-index: 2; color: #747d8c !important;">
          Project Management
        </span>
        <div class="position-absolute start-0 end-0 top-50 translate-y-50" style="border-bottom: 1px solid #e2e8f5; z-index: 1; margin-left: 8px; margin-right: 8px;"></div>
      </li>
  
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs(['admin.task.index', 'admin.task.create', 'admin.task.store', 'admin.task.edit', 'admin.task.update', 'admin.task.show']) ? 'active' : 'collapsed' }}"
           href="{{ route('admin.task.index') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-folder-plus me-2" style="font-size: 15px;"></i>
          <span>Create Project</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('admin.task.table') ? 'active' : 'collapsed' }}"
           href="{{ route('admin.task.table') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-bars-progress me-2" style="font-size: 15px;"></i>
          <span>Data Project Status</span>
        </a>
      </li>
  
      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('admin.timelines.*') ? 'active' : 'collapsed' }}"
           href="{{ route('admin.timelines.index') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-timeline me-2" style="font-size: 15px;"></i>
          <span>Project Timeline</span>
        </a>
      </li>

      <li class="nav-heading mt-3 mb-2 px-2 d-flex align-items-center position-relative" style="height: 20px;">
        <span class="bg-white pe-2 text-muted fw-bold position-relative" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.8px; z-index: 2; color: #747d8c !important;">
          Item Specification
        </span>
        <div class="position-absolute start-0 end-0 top-50 translate-y-50" style="border-bottom: 1px solid #e2e8f5; z-index: 1; margin-left: 8px; margin-right: 8px;"></div>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center collapsed"
           href="#"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-file-shield me-2" style="font-size: 15px;"></i>
          <span>Item Spec & Requirements</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center collapsed"
           href="#"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-diagram-project me-2" style="font-size: 15px;"></i>
          <span>Workflow Engine</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center {{ request()->routeIs('admin.emails.*') ? 'active' : 'collapsed' }}"
           href="{{ route('admin.emails.index') }}"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-list-check me-2" style="font-size: 15px;"></i>
          <span>Task List Project</span>
        </a>
      </li>

      <li class="nav-heading mt-3 mb-2 px-2 d-flex align-items-center position-relative" style="height: 20px;">
        <span class="bg-white pe-2 text-muted fw-bold position-relative" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.8px; z-index: 2; color: #747d8c !important;">
          Color Machine & Trial
        </span>
        <div class="position-absolute start-0 end-0 top-50 translate-y-50" style="border-bottom: 1px solid #e2e8f5; z-index: 1; margin-left: 8px; margin-right: 8px;"></div>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center collapsed"
           href="#"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-file-invoice me-2" style="font-size: 15px;"></i>
          <span>Trial Report</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center collapsed"
           href="#"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-boxes-stacked me-2" style="font-size: 15px;"></i>
          <span>Sample Request</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link rounded-3 d-flex align-items-center collapsed"
           href="#"
           style="padding: 6px 12px; height: 35px; font-size: 13.5px; font-weight: 600;">
          <i class="fa-solid fa-clock-rotate-left me-2" style="font-size: 15px;"></i>
          <span>History Log</span>
        </a>
      </li>

    </ul>
</aside>
  
<style>
/* Reset & Base style link navigasi sidebar */
.sidebar-nav .nav-link {
  color: #4b5563;
  transition: all 0.15s ease-in-out;
  border-radius: 6px !important; 
  text-decoration: none;
  border-left: 4px solid transparent;
}

/* KONDISI HOVER */
.sidebar-nav .nav-link:hover,
.sidebar-nav .nav-link.active:hover {
  background-color: #f1f5f9 !important;
  color: #1e293b !important;
  border-left: 4px solid #94a3b8 !important;
}

/* KONDISI AKTIF/DIKLIK */
.sidebar-nav .nav-link.active {
  background-color: #eff6ff !important;
  color: #2563eb !important;
  border-left: 4px solid #3b82f6 !important;
}
</style>