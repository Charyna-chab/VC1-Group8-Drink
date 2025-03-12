<?php
require_once 'Router.php';
require_once './Controllers/UserController.php';
require_once './Controllers/DashboardController.php';
require_once './router/Router.php';


$routes = new router();

// dashboard
$routes->get('/', [DashboardController::class, 'index']);

// user 
$routes->get('/user', [UserController::class, 'index']);
$routes->get('/user/create', [UserController::class, 'create']);
$routes->post('/user/store', [UserController::class, 'store']);
$routes->get('/user/edit', [UserController::class, 'edit']);
$routes->put('/user/update', [UserController::class, 'update']);
$routes->delete('/user/delete', [UserController::class, 'destroy']);

// Initialize router
$router = new Routers();

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




// dispatch
$routes->dispatch();