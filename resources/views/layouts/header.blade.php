<header class="header fixed-top d-flex align-items-center justify-content-between px-3">
    
    <!-- Bagian Kiri: Hamburger Kotak -> Logo Kotak -> PT Amcor -->
    <div class="d-flex align-items-center gap-2">
        <!-- Kotak Tombol Hamburger (Paling Kiri) -->
        <div class="border rounded d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 38px; height: 38px; cursor: pointer;" id="toggle-sidebar">
            <i class="fa-solid fa-bars text-secondary" style="font-size: 18px;"></i>
        </div>

        <!-- href diarahkan kembali ke dashboard utama -->
        <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center text-decoration-none ms-2 gap-2">
            <!-- Kotak untuk Logo PT Amcor (Membaca file public/logo.png) -->
            <div class="bg-light border rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; overflow: hidden;">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid">
            </div>
            <!-- Tulisan Nama PT -->
            <span class="d-none d-sm-block" style="color: #012970; font-weight: 700; font-family: 'Nunito', sans-serif; font-size: 22px;">Amcor</span>
        </a>
    </div>

    <div class="search-bar d-none d-md-block flex-grow-1 mx-4" style="max-width: 360px;">
        <form class="search-form d-flex align-items-center bg-light border rounded-pill px-3 py-1" method="POST" action="#">
            <input type="text" name="query" placeholder="Search..." title="Enter search keyword" class="form-control bg-transparent border-0 shadow-none p-1 small">
            <button type="submit" title="Search" class="btn btn-link text-secondary p-0"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <div class="d-flex align-items-center gap-3">
        
        <div class="icon-box border rounded p-2 d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 38px; height: 38px; cursor: pointer;">
            <i class="fa-regular fa-bell text-secondary"></i>
        </div>

        <div class="icon-box border rounded p-2 d-flex align-items-center justify-content-center bg-light shadow-sm" style="width: 38px; height: 38px; cursor: pointer;" id="toggle-dark-mode">
            <i class="fa-regular fa-moon text-secondary"></i>
        </div>

        <div class="dropdown">
            <a class="nav-link nav-profile d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px;">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="d-none d-md-block">
                    <span class="d-block fw-bold text-dark lh-1 small">{{ Auth::user()->name }}</span>
                    <small class="text-muted" style="font-size: 10px;">{{ strtoupper(Auth::user()->role) }}</small>
                </div>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                <li class="dropdown-header text-start px-3 py-2">
                    <h6 class="m-0 fw-bold">{{ Auth::user()->name }}</h6>
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