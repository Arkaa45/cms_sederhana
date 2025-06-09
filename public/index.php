<?php
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/controllers/PostController.php';

$controller = new PostController();
$controller->index(); 