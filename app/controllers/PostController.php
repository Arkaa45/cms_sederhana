<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../config/Database.php';

class PostController {
    private $db;
    private $post;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->post = new Post($this->db);
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $stmt = $this->post->getRecentPosts(5, $search);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . '/../views/posts/index.php';
    }

    public function show($id) {
        $stmt = $this->post->getPostById($id);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$post) {
            header("Location: index.php");
            exit();
        }
        
        require_once __DIR__ . '/../views/posts/show.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post->title = $_POST['title'];
            $this->post->content = $_POST['content'];
            $this->post->user_id = $_SESSION['user_id'];

            if ($this->post->create()) {
                header("Location: index.php");
                exit();
            }
        }
        
        require_once __DIR__ . '/../views/posts/create.php';
    }

    public function edit($id) {
        $stmt = $this->post->getPostById($id);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$post || $post['user_id'] != $_SESSION['user_id']) {
            header("Location: index.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->post->id = $id;
            $this->post->title = $_POST['title'];
            $this->post->content = $_POST['content'];
            $this->post->user_id = $_SESSION['user_id'];

            if ($this->post->update()) {
                header("Location: index.php");
                exit();
            }
        }
        
        require_once __DIR__ . '/../views/posts/edit.php';
    }

    public function delete($id) {
        $stmt = $this->post->getPostById($id);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($post && $post['user_id'] == $_SESSION['user_id']) {
            $this->post->id = $id;
            $this->post->user_id = $_SESSION['user_id'];
            $this->post->delete();
        }
        
        header("Location: index.php");
        exit();
    }
} 