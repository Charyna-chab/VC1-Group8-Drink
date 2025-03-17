<?php
require_once 'Router.php';
require_once './Controllers/UserController.php';
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

// Interface for user





// dispatch
$routes->dispatch();