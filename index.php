<?php
// Entry point for the application
// Initialize session
session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Include router
require_once 'router/Router.php';

// Include database connection
require_once 'models/Database.php';

// Include controllers
require_once 'controllers/HomeController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/OrderController.php';
require_once 'controllers/UserController.php';

// Initialize router
$router = new Router();

// Define routes
$router->addRoute('/', 'HomeController@index');
$router->addRoute('/products', 'ProductController@index');
$router->addRoute('/products/category/:category', 'ProductController@getByCategory');
$router->addRoute('/products/:id', 'ProductController@show');
$router->addRoute('/order/add', 'OrderController@add');
$router->addRoute('/order/place', 'OrderController@place');
$router->addRoute('/user/profile', 'UserController@profile');
$router->addRoute('/user/notifications', 'UserController@notifications');

// Process the request
$router->dispatch();
?>


<?php
// Start session
session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Include required files
require_once 'config/config.php';
require_once 'utils/functions.php';
require_once 'models/UserModel.php';
require_once 'lib/Auth.php';
require_once 'middleware/Middleware.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/AdminController.php';
require_once 'views/header.php';
require_once 'views/admin/partials/footer.php';



// Simple router
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = rtrim($path, '/');

// Remove query string if present
if (($pos = strpos($path, '?')) !== false) {
    $path = substr($path, 0, $pos);
}

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
    
    // Create controller instance
    $controller = new $controller_name();
    
    // Call method
    $controller->$method_name();
} else {
    // Route not found
    header('HTTP/1.0 404 Not Found');
    include 'views/404.php';
}



