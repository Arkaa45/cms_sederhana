<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['create'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    if($stmt->execute([$_SESSION['user_id'], $title, $content])) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Gagal membuat postingan";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Postingan - Simple CMS</title>

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
        .btn-info {
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
        }
        .btn-info:hover {
            background-color: #138496 !important;
            border-color: #117a8b !important;
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
                    <a href="../index.php" class="nav-link">Beranda</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../index.php" class="brand-link">
                <i class="fas fa-clipboard-list brand-image img-circle elevation-3" style="opacity: .8; font-size: 1.5rem; padding: 0.5rem;"></i>
                <span class="brand-text font-weight-light">Simple CMS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Tambah Postingan Baru</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Form Postingan</h3>
                                </div>
                                <div class="card-body">
                                    <?php if(isset($error)): ?>
                                        <div class="alert alert-danger">
                                            <i class="icon fas fa-ban"></i> <?php echo $error; ?>
                                        </div>
                                    <?php endif; ?>

                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="title">Judul</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Konten</label>
                                            <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="create" class="btn btn-info">
                                                <i class="fas fa-save"></i> Simpan Postingan
                                            </button>
                                            <a href="dashboard.php" class="btn btn-default">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2025 <a href="../index.php">Raka Gemilang F.A</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html> 