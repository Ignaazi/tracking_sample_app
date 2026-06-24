<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --nice-blue: #4154f1;
            --nice-dark: #012970;
            --nice-gray: #899bbd;
            --bg-light: #f6f9ff;
        }
        body { 
            font-family: "Nunito", sans-serif; 
            background-color: var(--bg-light); 
            color: #444444;
            overflow-x: hidden;
            font-size: 14px;
        }
        
        /* ==========================================================================
           HEADER STYLE
           ========================================================================== */
        .header {
            height: 60px;
            box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.05);
            background-color: #fff;
            z-index: 997;
        }
        .header .logo span {
            font-size: 20px;
            font-weight: 700;
            color: var(--nice-dark);
        }

        /* ==========================================================================
           SIDEBAR STYLE (ADJUSTED & COMPACT)
           ========================================================================== */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            width: 260px; 
            z-index: 996;
            transition: all 0.3s ease-in-out;
            padding: 15px;
            overflow-y: auto;
            background-color: #fff;
            box-shadow: 0px 0px 20px rgba(1, 41, 112, 0.05);
            display: flex;
            flex-direction: column;
        }
        .sidebar-nav {
            padding: 0;
            margin: 0;
            list-style: none;
        }
        
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--nice-dark);
            padding: 10px 12px;
            border-radius: 4px;
            text-decoration: none;
            background: #fff;
            transition: all 0.2s ease;
            position: relative;
            border-left: 4px solid transparent;
        }
        .sidebar-nav .nav-link i {
            font-size: 15px;
            margin-right: 10px;
            color: var(--nice-gray);
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link:hover, 
        .sidebar-nav .nav-link.active {
            color: var(--nice-blue) !important;
            background-color: #f6f9ff !important;
            border-left: 4px solid var(--nice-blue) !important;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .sidebar-nav .nav-link:hover i, 
        .sidebar-nav .nav-link.active i {
            color: var(--nice-blue) !important;
        }

        /* ==========================================================================
           CONTENT WRAPPER & TOGGLE MECHANISM
           ========================================================================== */
        .main-wrapper {
            margin-left: 260px; 
            padding-top: 60px;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            padding: 25px;
            flex: 1;
        }
        
        body.toggle-sidebar .sidebar {
            left: -260px;
        }
        body.toggle-sidebar .main-wrapper {
            margin-left: 0;
        }
        
        .card {
            border: none;
            border-radius: 6px;
            box-shadow: 0px 0 20px rgba(1, 41, 112, 0.05);
        }
        .footer {
            padding: 15px 0;
            font-size: 13px;
            border-top: 1px solid #e2e8f0;
            background-color: #fff;
            color: #012970;
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('layouts.header')
    @include('layouts.sidebar')

    <div class="main-wrapper">
        <main class="main-content">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.body.classList.toggle('toggle-sidebar');
        });
    </script>

    @stack('scripts')
</body>
</html>