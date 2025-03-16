<?php
require_once './Routes/routes.php';


// $controller = new HomeController();
// $controller->index();

// Entry point for the application
// Initialize session
session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Include router
require_once './router/Router.php';

// Include database connection
// require_once 'models/Database.php';

// Include controllers
require_once 'Controllers/HomeController.php';
require_once 'Controllers/ProductController.php';
require_once 'Controllers/OrderController.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/PageController.php'; // Include the new controller



// Process the request
$router->dispatch();
?>
