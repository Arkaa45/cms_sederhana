<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Handle post deletion
if(isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$post_id, $_SESSION['user_id']]);
    header("Location: dashboard.php");
    exit();
}

// Fetch user's posts
$stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simple CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Simple CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dashboard</h1>
            <a href="create_post.php" class="btn btn-primary">Create New Post</a>
        </div>

        <?php if(empty($posts)): ?>
            <div class="alert alert-info">You haven't created any posts yet.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($posts as $post): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($post['title']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                                <td>
                                    <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="dashboard.php?delete=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 