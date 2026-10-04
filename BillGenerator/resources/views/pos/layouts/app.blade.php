<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2196f3;
            --light-blue: #eaf6ff;
            --sidebar-blue: #f4faff;
            --border-blue: #d8ecfb;
            --text-dark: #334155;
            --text-muted: #718096;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            background: var(--light-blue);
            color: var(--text-dark);
            font-family: Arial, Helvetica, sans-serif;
        }

        .app-container {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--border-blue);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            height: 72px;
            padding: 0 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border-blue);
            color: var(--primary-blue);
            font-size: 21px;
            font-weight: 700;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-blue);
            border-radius: 10px;
            color: var(--primary-blue);
            font-size: 20px;
        }

        .sidebar-menu {
            padding: 20px 14px;
            flex: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 15px;
            margin-bottom: 7px;
            border-radius: 9px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-menu a i {
            font-size: 18px;
        }

        .sidebar-menu a:hover {
            background: var(--light-blue);
            color: var(--primary-blue);
        }

        .sidebar-menu a.active {
            background: var(--primary-blue);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.18);
        }

        .sidebar-bottom {
            padding: 14px;
            border-top: 1px solid var(--border-blue);
        }

        .sidebar-bottom a {
            color: #e45757;
        }

        .sidebar-bottom a:hover {
            background: #fff1f1;
            color: #d93f3f;
        }

        .main-wrapper {
            width: calc(100% - 250px);
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-header {
            height: 72px;
            background: var(--white);
            border-bottom: 1px solid var(--border-blue);
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .page-heading {
            margin: 0;
            color: var(--text-dark);
            font-size: 21px;
            font-weight: 700;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .user-details {
            text-align: right;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-username {
            font-size: 12px;
            color: var(--text-muted);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-blue);
            color: var(--primary-blue);
            border: 1px solid var(--border-blue);
            font-size: 17px;
            font-weight: 700;
        }

        .page-content {
            flex: 1;
            padding: 28px;
        }

        .footer {
            background: var(--white);
            border-top: 1px solid var(--border-blue);
            padding: 15px 28px;
            color: var(--text-muted);
            font-size: 13px;
            flex-shrink: 0;
        }

        .dashboard-card {
            background: var(--white);
            border: 1px solid var(--border-blue);
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(33, 150, 243, 0.05);
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border-blue);
            border-radius: 12px;
            padding: 22px;
            height: 100%;
            box-shadow: 0 3px 12px rgba(33, 150, 243, 0.05);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-blue);
            color: var(--primary-blue);
            font-size: 22px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 7px;
        }

        .stat-value {
            color: var(--text-dark);
            font-size: 25px;
            font-weight: 700;
            margin: 0;
        }

        .section-card {
            background: var(--white);
            border: 1px solid var(--border-blue);
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(33, 150, 243, 0.05);
        }

        .section-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-blue);
        }

        .section-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .empty-state {
            padding: 50px 20px;
            text-align: center;
        }

        .empty-state-icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: var(--light-blue);
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 28px;
        }

        .empty-state h5 {
            color: var(--text-dark);
            font-size: 16px;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: var(--text-muted);
            margin: 0;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-brand {
                justify-content: center;
                padding: 0;
            }

            .sidebar-brand span {
                display: none;
            }

            .sidebar-brand-icon {
                width: 40px;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 13px;
            }

            .sidebar-menu a span,
            .sidebar-bottom a span {
                display: none;
            }

            .sidebar-bottom a {
                justify-content: center;
            }

            .main-wrapper {
                width: calc(100% - 70px);
                margin-left: 70px;
            }

            .top-header {
                padding: 0 15px;
            }

            .page-content {
                padding: 15px;
            }

            .user-details {
                display: none;
            }

            .footer {
                padding: 15px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="app-container">

    <aside class="sidebar">

        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-shop"></i>
            </div>
            <span>POS System</span>
        </div>

        <div class="sidebar-menu">

            <a href="/pos_dashboard" class="{{ request()->is('pos_dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="/pos_todays_sales" class="{{ request()->is('pos_todays_sales') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Today's Sales</span>
            </a>

            <a href="/pos_biller" class="{{ request()->is('pos_biller') ? 'active' : '' }}">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Biller</span>
            </a>

        </div>

        <div class="sidebar-bottom">

            <a href="/pos_logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>

        </div>

    </aside>

    <div class="main-wrapper">

        <header class="top-header">

            <div>
                <h1 class="page-heading">
                    @yield('page_title', 'Dashboard')
                </h1>
            </div>

            <div class="user-info">

                <div class="user-details">
                    <div class="user-name">
                        {{ session('pos_name', 'POS User') }}
                    </div>

                    <div class="user-username">
                        {{ session('pos_username', '') }}
                    </div>
                </div>

                <div class="user-avatar">
                    {{ strtoupper(substr(session('pos_name', 'P'), 0, 1)) }}
                </div>

            </div>

        </header>

        <main class="page-content">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </main>

        <footer class="footer">

            <div class="d-flex justify-content-between align-items-center">
                <span>© {{ date('Y') }} POS System</span>
                <span>All Rights Reserved</span>
            </div>

        </footer>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>