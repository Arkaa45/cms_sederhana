<?php
session_start();

// Load configuration
require_once __DIR__ . '/../app/config/Database.php';

// Load controllers
require_once __DIR__ . '/../app/controllers/PostController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

// Get the requested URL
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/cms_sederhana/';
$path = str_replace($base_path, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);

// Remove 'public/' from the path if it exists
$path = str_replace('public/', '', $path);

// Simple routing
switch ($path) {
    case '':
    case 'index.php':
        $controller = new PostController();
        $controller->index();
        break;
        
    case 'post':
        $controller = new PostController();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller->show($id);
        break;
        
    case 'create_post':
        $controller = new PostController();
        $controller->create();
        break;
        
    case 'edit_post':
        $controller = new PostController();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller->edit($id);
        break;
        
    case 'delete_post':
        $controller = new PostController();
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller->delete($id);
        break;
        
    case 'login':
        $controller = new UserController();
        $controller->login();
        break;
        
    case 'register':
        $controller = new UserController();
        $controller->register();
        break;
        
    case 'logout':
        $controller = new UserController();
        $controller->logout();
        break;
        
    case 'profile':
        $controller = new UserController();
        $controller->profile();
        break;
        
    case 'change_password':
        $controller = new UserController();
        $controller->changePassword();
        break;
        
    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
} 