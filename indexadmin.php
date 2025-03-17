<?php
// Start session
session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Include required files
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/utils/functions.php';
require_once BASE_PATH . '/models/UserModel.php';
require_once BASE_PATH . '/lib/Auth.php';
require_once BASE_PATH . '/middleware/Middleware.php';
require_once BASE_PATH . '/controllers/AuthAdminController.php';
require_once BASE_PATH . '/controllers/AdminController.php';



// Simple router
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = rtrim($path, '/');

// Default route
if (empty($path) || $path === '/') {
    $path = '/login';
}

// Process middleware
$middleware = new Middleware();
$middleware->process($path);

// Define routes
$routes = [
    '/login' => ['controller' => 'AuthController', 'method' => 'login'],
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
    '/verify-2fa' => ['controller' => 'AuthController', 'method' => 'verify2fa'],
    '/forgot-password' => ['controller' => 'AuthController', 'method' => 'forgotPassword'],
    '/reset-password' => ['controller' => 'AuthController', 'method' => 'resetPassword'],
    '/admin/dashboard' => ['controller' => 'AdminController', 'method' => 'dashboard'],
    '/admin/users' => ['controller' => 'AdminController', 'method' => 'users'],
    '/admin/settings' => ['controller' => 'AdminController', 'method' => 'settings']
];

// Check if route exists
if (isset($routes[$path])) {
    $controller_name = $routes[$path]['controller'];
    $method_name = $routes[$path]['method'];

    if (class_exists($controller_name) && method_exists($controller_name, $method_name)) {
        // Create controller instance
        $controller = new $controller_name();
        
        // Call method
        $controller->$method_name();
    } else {
        // Controller or method not found
        header('HTTP/1.0 404 Not Found');
        include BASE_PATH . '/views/404.php';
    }
} else {
    // Route not found
    header('HTTP/1.0 404 Not Found');
    if (file_exists(BASE_PATH . '/views/404.php')) {
        include BASE_PATH . '/views/404.php';
    } else {
        echo "404 - Page not found";
    }
}

