<header class="header fixed-top d-flex align-items-center justify-content-between px-3 bg-white" style="border-bottom: 1px solid #e2e8f5; height: 65px; z-index: 997;">
    
    <div class="d-flex align-items-center gap-2">
        <div class="border rounded d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 38px; height: 38px; cursor: pointer; border-color: #e2e8f5 !important;" id="toggle-sidebar">
            <i class="fa-solid fa-bars text-secondary" style="font-size: 18px;"></i>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center text-decoration-none ms-2 gap-2">
            <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm p-1" style="width: 38px; height: 38px; overflow: hidden; border: 1px solid #e2e8f5;">
                <!-- DITAMBAHKAN STYLE RENDER FIT UNTUK GAMBAR -->
                <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <span class="d-none d-sm-block" style="color: #012970; font-weight: 700; font-family: 'Nunito', sans-serif; font-size: 22px;">Amcor</span>
        </a>
    </div>

    <div class="d-flex align-items-center gap-3 ms-auto">
        
        <div class="search-bar d-none d-md-block" style="width: 580px;">
            <form class="search-form d-flex align-items-center bg-light rounded-3 px-3 py-2" method="POST" action="#" style="border: 1px solid #e2e8f5; margin: 0;">
                @csrf
                <input type="text" name="query" placeholder="Search projects, invoices, users..." title="Enter search keyword" class="form-control bg-transparent border-0 shadow-none p-0 small text-secondary" style="font-family: 'Nunito', sans-serif; font-size: 14px;">
                <button type="submit" title="Search" class="btn btn-link text-secondary p-0 ms-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        
        <div class="icon-box rounded p-2 d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 38px; height: 38px; cursor: pointer; border: 1px solid #e2e8f5;">
            <i class="fa-regular fa-bell text-secondary" style="font-size: 16px;"></i>
        </div>

        <div class="icon-box rounded p-2 d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 38px; height: 38px; cursor: pointer; border: 1px solid #e2e8f5;" id="open-chat-box">
            <i class="fa-regular fa-comment-alt text-secondary" style="font-size: 16px;"></i>
        </div>

        <div class="icon-box rounded p-2 d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 38px; height: 38px; cursor: pointer; border: 1px solid #e2e8f5;" id="toggle-dark-mode">
            <i class="fa-regular fa-moon text-secondary" style="font-size: 16px;"></i>
        </div>

        <div class="dropdown">
            <a class="nav-link nav-profile d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px;">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="d-none d-md-block" style="font-family: 'Nunito', sans-serif;">
                    <span class="d-block fw-bold text-dark lh-1 small">{{ Auth::user()->name }}</span>
                    <small class="text-muted" style="font-size: 10px;">{{ strtoupper(Auth::user()->role) }}</small>
                </div>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="font-family: 'Nunito', sans-serif; font-size: 14px;">
                <li class="dropdown-header text-start px-3 py-2">
                    <h6 class="m-0 fw-bold text-dark">{{ Auth::user()->name }}</h6>
                    <small class="text-muted">{{ strtoupper(Auth::user()->role) }}</small>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center text-danger py-2">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</header>