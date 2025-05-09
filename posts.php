<?php
session_start();
require_once 'config/database.php';

// Handle search
$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = '';
$params = [];

if (!empty($search)) {
    $where = "WHERE posts.title LIKE ? OR posts.content LIKE ? OR users.username LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%"];
}

// Fetch all posts with author information
$query = "SELECT posts.*, users.username 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          $where
          ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Postingan - Simple CMS</title>

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
                    <a href="index.php" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="posts.php" class="nav-link">Postingan</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <i class="fas fa-clipboard-list brand-image img-circle elevation-3" style="opacity: .8; font-size: 1.5rem; padding: 0.5rem;"></i>
                <span class="brand-text font-weight-light">Simple CMS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="posts.php" class="nav-link active">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Postingan</p>
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
                            <h1 class="m-0">Semua Postingan</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Search Form -->
                            <div class="input-group mb-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari postingan..." value="<?php echo htmlspecialchars($search); ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <?php if(!empty($search)): ?>
                                        <a href="posts.php" class="btn btn-default">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if(!empty($search)): ?>
                                <div class="alert alert-info">
                                    <i class="icon fas fa-info"></i> Menampilkan hasil pencarian untuk: "<?php echo htmlspecialchars($search); ?>"
                                </div>
                            <?php endif; ?>

                            <?php if(empty($posts)): ?>
                                <div class="alert alert-info">
                                    <i class="icon fas fa-info"></i> <?php echo !empty($search) ? 'Tidak ditemukan postingan yang sesuai dengan pencarian.' : 'Belum ada postingan yang tersedia.'; ?>
                                </div>
                            <?php else: ?>
                                <?php foreach($posts as $post): ?>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                            <div class="card-tools">
                                                <span class="badge badge-primary">
                                                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($post['username']); ?>
                                                </span>
                                                <span class="badge badge-info">
                                                    <i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p><?php echo substr(htmlspecialchars($post['content']), 0, 200) . '...'; ?></p>
                                            <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> Baca Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
            <strong>Copyright &copy; 2025 <a href="index.php">Raka Gemilang F.A</a>.</strong> All rights reserved.
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