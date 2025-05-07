<?php
session_start();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Simple CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="posts.php">Posts</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h1>Welcome to Simple CMS</h1>
                <p>This is a simple content management system where you can create and manage your content.</p>
                
                <?php
                // Fetch recent posts
                $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5");
                $posts = $stmt->fetchAll();
                
                if($posts): ?>
                    <h2 class="mt-4">Recent Posts</h2>
                    <?php foreach($posts as $post): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                <p class="card-text"><?php echo substr(htmlspecialchars($post['content']), 0, 200) . '...'; ?></p>
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">About</h5>
                        <p class="card-text">This is a simple CMS built with PHP and MySQL. You can create, edit, and manage your content easily.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 