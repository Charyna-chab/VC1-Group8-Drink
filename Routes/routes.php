<?php
require_once 'Router.php';
require_once './Controllers/Admin/Users/UserController.php';
require_once './Controllers/Admin/Products/ProductController.php';
require_once './Controllers/Admin/DashboardController.php';
require_once './Controllers/Admin/FeedbackController.php'; // Add this line
require_once './Controllers/Connection/ConnectController.php'; // connect function product

$routes = new Router();

$routes->get('/', [DashboardController::class, 'index']);

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
$routes->get('/product/delete', [ProductController::class, 'destroy']);

// feedback
$routes->get('/feedback', [FeedbackController::class, 'index']);
$routes->get('/feedback/create', [FeedbackController::class, 'create']);

$routes->dispatch();