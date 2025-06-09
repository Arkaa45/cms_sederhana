<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $email;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (username, password, email, created_at)
                VALUES (?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($query);
        
        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        return $stmt->execute([
            $this->username,
            $hashed_password,
            $this->email
        ]);
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->username]);
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($this->password, $row['password'])) {
                return $row;
            }
        }
        
        return false;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET email = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->email,
            $this->id
        ]);
    }

    public function updatePassword() {
        $query = "UPDATE " . $this->table_name . "
                SET password = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        
        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        return $stmt->execute([
            $hashed_password,
            $this->id
        ]);
    }
} 