<?php
class Auth {
    public static function check() {
        return isset($_SESSION['user_id']);
    }

    public static function user() {
        if (self::check()) {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);
            return $user->getUserById($_SESSION['user_id']);
        }
        return null;
    }

    public static function requireLogin() {
        if (!self::check()) {
            $_SESSION['error'] = "Silakan login terlebih dahulu!";
            header("Location: login.php");
            exit();
        }
    }

    public static function requireGuest() {
        if (self::check()) {
            header("Location: index.php");
            exit();
        }
    }
} 