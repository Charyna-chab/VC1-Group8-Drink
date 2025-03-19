<?php
require_once 'Router.php';
require_once './Controllers/UserController.php';
require_once './Controllers/ProductController.php';
require_once './Controllers/DashboardController.php';
// require_once './router/Router.php';


$routes = new Router();

// user 
$routes->get('/user', [UserController::class, 'index']);
$routes->get('/user/create', [UserController::class, 'create']);
$routes->post('/user/store', [UserController::class, 'store']);
$routes->get('/user/edit', [UserController::class, 'edit']);
$routes->put('/user/update', [UserController::class, 'update']);
$routes->delete('/user/delete', [UserController::class, 'destroy']);

// product
$routes->get('/product', [ProductController::class, 'index']);
$routes->get('/product/create', [ProductController::class, 'create']);  
$routes->post('/product/store', [ProductController::class, 'store']);
$routes->get('/product/edit', [ProductController::class, 'edit']);
$routes->put('/product/update', [ProductController::class, 'update']);
$routes->delete('/product/delete', [ProductController::class, 'destroy']);




// dispatch
$routes->dispatch();