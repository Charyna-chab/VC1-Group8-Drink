<?php
// Start session
session_start();

// Load models and controllers
require_once 'models/Database.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/OrderController.php';
require_once 'controllers/SplashController.php';

// Parse URL
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = trim($path, '/');

// If path is empty, show splash screen
if (empty($path)) {
    $controller = new SplashController();
    $controller->index();
    exit;
}

// Define routes
$routes = [
    'home' => ['controller' => 'HomeController', 'action' => 'index'],
    'menu' => ['controller' => 'ProductController', 'action' => 'menu'],
    'product' => ['controller' => 'ProductController', 'action' => 'show'],
    'login' => ['controller' => 'AuthController', 'action' => 'login'],
    'register' => ['controller' => 'AuthController', 'action' => 'register'],
    'logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    'forgot-password' => ['controller' => 'AuthController', 'action' => 'forgotPassword'],
    'orders' => ['controller' => 'OrderController', 'action' => 'index'],
    'order' => ['controller' => 'OrderController', 'action' => 'show'],
    'favorites' => ['controller' => 'HomeController', 'action' => 'favorites'],
    'feedback' => ['controller' => 'HomeController', 'action' => 'feedback'],
    'settings' => ['controller' => 'HomeController', 'action' => 'settings'],
    'about' => ['controller' => 'HomeController', 'action' => 'about'],
    'contact' => ['controller' => 'HomeController', 'action' => 'contact'],
    'careers' => ['controller' => 'HomeController', 'action' => 'careers'],
    'franchise' => ['controller' => 'HomeController', 'action' => 'franchise'],
    'blog' => ['controller' => 'HomeController', 'action' => 'blog'],
    'faq' => ['controller' => 'HomeController', 'action' => 'faq'],
    'splash' => ['controller' => 'SplashController', 'action' => 'index']
];

// Route the request
if (array_key_exists($path, $routes)) {
    $route = $routes[$path];
    $controller_name = $route['controller'];
    $action = $route['action'];
    
    $controller = new $controller_name();
    $controller->$action();
} else {
    // 404 Not Found
    header("HTTP/1.0 404 Not Found");
    require 'views/404.php';
}

    