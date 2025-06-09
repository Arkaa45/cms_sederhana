<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Selamat Datang di Simple CMS</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Welcome Section -->
                    <div class="welcome-section">
                        <h1><i class="fas fa-newspaper"></i> Selamat Datang di Simple CMS</h1>
                        <p>Platform sederhana untuk berbagi cerita dan informasi</p>
                    </div>

                    <!-- Search Form -->
                    <div class="search-box">
                        <form action="index.php" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari postingan..." value="<?php echo htmlspecialchars($search); ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <?php if(!empty($search)): ?>
                                        <a href="index.php" class="btn btn-default">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if(!empty($search)): ?>
                        <div class="alert alert-info">
                            <i class="icon fas fa-info"></i> Menampilkan hasil pencarian untuk: "<?php echo htmlspecialchars($search); ?>"
                        </div>
                    <?php endif; ?>

                    <?php if($posts): ?>
                        <h2 class="mt-4 mb-4">
                            <i class="fas fa-list"></i> 
                            <?php echo !empty($search) ? 'Hasil Pencarian' : 'Postingan Terbaru'; ?>
                        </h2>
                        <?php foreach($posts as $post): ?>
                            <div class="card card-outline card-info post-card">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="post-meta">
                                        <span class="text-muted">
                                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($post['username']); ?>
                                        </span>
                                        <span class="text-muted">
                                            <i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                                        </span>
                                    </div>
                                    <p><?php echo substr(htmlspecialchars($post['content']), 0, 200) . '...'; ?></p>
                                    <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        <?php endforeach;
                    else: ?>
                        <div class="alert alert-info">
                            <i class="icon fas fa-info"></i> <?php echo !empty($search) ? 'Tidak ditemukan postingan yang sesuai dengan pencarian.' : 'Belum ada postingan yang tersedia.'; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-4">
                    <!-- About Card -->
                    <div class="card about-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle"></i> Tentang Simple CMS</h3>
                        </div>
                        <div class="card-body">
                            <p>Simple CMS adalah platform sederhana untuk berbagi cerita dan informasi. Anda dapat membuat, mengedit, dan menghapus postingan sesuai kebutuhan.</p>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="create_post.php" class="btn btn-info btn-block">
                                    <i class="fas fa-plus"></i> Buat Postingan Baru
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 