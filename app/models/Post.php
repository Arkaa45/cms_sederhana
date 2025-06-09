<?php
class Post {
    private $conn;
    private $table_name = "posts";

    public $id;
    public $title;
    public $content;
    public $user_id;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getRecentPosts($limit = 5, $search = '') {
        $where = '';
        $params = [];

        if (!empty($search)) {
            $where = "WHERE posts.title LIKE ? OR posts.content LIKE ? OR users.username LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%"];
        }

        $query = "SELECT posts.*, users.username 
                  FROM " . $this->table_name . " 
                  JOIN users ON posts.user_id = users.id 
                  $where
                  ORDER BY posts.created_at DESC 
                  LIMIT ?";
        
        $params[] = $limit;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        
        return $stmt;
    }

    public function getPostById($id) {
        $query = "SELECT posts.*, users.username 
                  FROM " . $this->table_name . " 
                  JOIN users ON posts.user_id = users.id 
                  WHERE posts.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (title, content, user_id, created_at)
                VALUES (?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->content,
            $this->user_id
        ]);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET title = ?, content = ?
                WHERE id = ? AND user_id = ?";

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->content,
            $this->id,
            $this->user_id
        ]);
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . "
                WHERE id = ? AND user_id = ?";

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->id,
            $this->user_id
        ]);
    }
} 