<?php
require_once "Router.php";
require_once "controllers/BaseController.php";
require_once "controllers/WelcomeController.php";
require_once "controllers/FeedbackController.php";
require_once "controllers/SettingsController.php";
require_once "controllers/OrdersController.php";
require_once "controllers/BookingController.php";

use YourNamespace\Router;

$route = new Router();



// Original routes
$route->get("/welcome", [WelcomeController::class, 'welcome']);
$route->get("/order", [OrderController::class, 'index']);
$route->get("/order/details/{id}", [OrderController::class, 'details']);
$route->post("/order/add-to-cart", [OrderController::class, 'addToCart']);
$route->get("/cart", [OrderController::class, 'cart']);
$route->get("/booking", [BookingController::class, 'index']);
$route->get("/orders", [BookingController::class, 'index']);
$route->get("/booking/details/{id}", [BookingController::class, 'details']);
$route->get("/orders/details/{id}", [BookingController::class, 'details']);
$route->get("/feedback", [FeedbackController::class, 'index']);
$route->get("/settings", [SettingsController::class, 'index']);

$route->route();