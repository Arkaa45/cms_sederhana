<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple CMS</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        .nav-sidebar .nav-item .nav-link.active {
            background-color: #6c757d !important;
            color: #fff !important;
        }
        .nav-sidebar .nav-item .nav-link.active:hover {
            background-color: #5a6268 !important;
        }
        .welcome-section {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .welcome-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .welcome-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .post-card {
            transition: transform 0.2s;
            margin-bottom: 1.5rem;
        }
        .post-card:hover {
            transform: translateY(-5px);
        }
        .post-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .post-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .about-card {
            background: #f8f9fa;
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .about-card .card-header {
            background: #17a2b8;
            color: white;
        }
        .search-box {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/cms_sederhana/" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/cms_sederhana/posts" class="nav-link">Postingan</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/cms_sederhana/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cms_sederhana/logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/cms_sederhana/login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cms_sederhana/register">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/cms_sederhana/" class="brand-link">
                <i class="fas fa-clipboard-list brand-image img-circle elevation-3" style="opacity: .8; font-size: 1.5rem; padding: 0.5rem;"></i>
                <span class="brand-text font-weight-light">Simple CMS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="/cms_sederhana/" class="nav-link active">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/cms_sederhana/posts" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Postingan</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
    </div>
</body>
</html> 