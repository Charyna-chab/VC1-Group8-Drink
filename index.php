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
require_once 'controllers/PageController.php'; // Include the new controller

// Initialize router
$router = new Router();

// Define routes
$router->addRoute('/', 'HomeController@index');
$router->addRoute('/products', 'ProductController@index');
$router->addRoute('/gift-card', 'PageController@giftCard'); // New route for Gift Card
$router->addRoute('/locations', 'PageController@locations'); // New route for Locations
$router->addRoute('/join-the-team', 'PageController@joinTheTeam'); // New route for Join The Team
$router->addRoute('/order/add', 'OrderController@add');
$router->addRoute('/order/place', 'OrderController@place');
$router->addRoute('/user/profile', 'UserController@profile');
$router->addRoute('/user/notifications', 'UserController@notifications');

// Process the request
$router->dispatch();
?>
