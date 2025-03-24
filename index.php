<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Include router and controller files
require_once __DIR__ . '/router/route.php';
require_once __DIR__ . '/Controllers/LocationsController.php';

use LocationsController\Controllers\Router;
use LocationsController\Controllers\LocationsController;

// // Create a new Router instance
// $router = new Router();

// ✅ Register the route correctly
// $router->get('/locations', [LocationsController::class, 'index']);

// Route the request
// $router->route();
?>
