<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->username = $_POST['username'];
            $this->user->password = $_POST['password'];
            $this->user->email = $_POST['email'];

            if ($this->user->create()) {
                $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = "Registrasi gagal! Silakan coba lagi.";
            }
        }
        
        require_once __DIR__ . '/../views/users/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->username = $_POST['username'];
            $this->user->password = $_POST['password'];

            $user = $this->user->login();
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Username atau password salah!";
            }
        }
        
        require_once __DIR__ . '/../views/users/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit();
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        $user = $this->user->getUserById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->id = $_SESSION['user_id'];
            $this->user->email = $_POST['email'];

            if ($this->user->update()) {
                $_SESSION['success'] = "Profil berhasil diperbarui!";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['error'] = "Gagal memperbarui profil!";
            }
        }
        
        require_once __DIR__ . '/../views/users/profile.php';
    }

    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->id = $_SESSION['user_id'];
            $this->user->password = $_POST['new_password'];

            if ($this->user->updatePassword()) {
                $_SESSION['success'] = "Password berhasil diubah!";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['error'] = "Gagal mengubah password!";
            }
        }
        
        require_once __DIR__ . '/../views/users/change_password.php';
    }
} 