<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Proden')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B0000;
            --secondary-color: #6A1B9A;
            --success-color: #1B5E20;
            --danger-color: #C41E3A;
            --warning-color: #6A1B9A;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
            color: white;
            box-shadow: 2px 0 4px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand h4 {
            margin-bottom: 0;
            font-weight: bold;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--secondary-color);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .topbar {
            background: white;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-toggle {
            display: none;
            border: 1px solid #d8dee6;
            background: #fff;
            color: var(--primary-color);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
        }

        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease;
        }

        .sidebar-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stat-card.primary {
            border-left-color: var(--primary-color);
        }

        .stat-card.success {
            border-left-color: var(--success-color);
        }

        .stat-card.warning {
            border-left-color: var(--warning-color);
        }

        .stat-card.danger {
            border-left-color: var(--danger-color);
        }

        .stat-card h6 {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .stat-card h3 {
            margin: 0;
            color: var(--primary-color);
            font-weight: bold;
        }

        .stat-card .stat-icon {
            float: right;
            font-size: 2rem;
            opacity: 0.3;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 15px 20px;
            font-weight: 500;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .btn {
            border-radius: 5px;
            padding: 8px 15px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 999;
                transition: transform 0.3s;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }

            .topbar {
                padding: 12px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .topbar .d-flex.align-items-center.gap-3 {
                width: 100%;
                justify-content: space-between;
                gap: 8px !important;
                flex-wrap: wrap;
            }

            .sidebar-toggle {
                display: inline-flex;
            }
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>
                <i class="fas fa-tachometer-alt"></i> Proden Admin
            </h4>
            <small class="text-muted">Dashboard</small>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders') }}" class="@if(Route::currentRouteName() == 'admin.orders') active @endif">
                    <i class="fas fa-receipt"></i> Orders
                </a>
            </li>
            <li>
                <a href="{{ route('admin.inventory') }}" class="@if(Route::currentRouteName() == 'admin.inventory') active @endif">
                    <i class="fas fa-boxes"></i> Inventory
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="@if(Route::currentRouteName() == 'admin.products.index') active @endif">
                    <i class="fas fa-bottle-water"></i> Products
                </a>
            </li>
            <li>
                <a href="{{ route('admin.inventory.report') }}" class="@if(Route::currentRouteName() == 'admin.inventory.report') active @endif">
                    <i class="fas fa-chart-line"></i> Reports
                </a>
            </li>
            <li>
                <a href="{{ route('admin.distributors.index') }}" class="@if(Route::currentRouteName() == 'admin.distributors.index') active @endif">
                    <i class="fas fa-user-tie"></i> Distributors
                </a>
            </li>
            <li>
                <hr style="border-color: rgba(255,255,255,0.2); margin: 10px 0;">
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="@if(Route::currentRouteName() == 'admin.products.index') active @endif">
                    <i class="fas fa-store"></i> Store / Products
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-link" style="width: 100%; text-align: left; color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px 20px; border: none;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('shop.products') }}" class="btn btn-sm btn-outline-secondary" title="Visit store">
                    <i class="fas fa-globe"></i> Store
                </a>
                <span class="text-muted">{{ Auth::user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="35" height="35">
            </div>
        </div>

        <!-- Alerts -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    @yield('scripts')
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarBackdrop.classList.remove('active');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                sidebarBackdrop.classList.toggle('active');
            });
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', closeSidebar);
        }

        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

        const logoutButton = sidebar.querySelector('button[type="submit"]');
        if (logoutButton) {
            logoutButton.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        }
    </script>
</body>
</html>

