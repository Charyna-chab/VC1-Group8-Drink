<?php
require_once "Router.php";
require_once "Models/Database.php";
require_once "controllers/BaseController.php";
require_once "controllers/WelcomeController.php";
require_once "controllers/FavoritesController.php";
require_once "controllers/FeedbackController.php";
require_once "controllers/DashboardController.php";
require_once "controllers/SettingsController.php";
require_once "controllers/OrdersController.php";
require_once "controllers/BookingController.php";
require_once "controllers/AuthController.php";

use YourNamespace\Router;

$route = new Router();

$route->get("/", [WelcomeController::class, 'welcome']);
$route->get("/dashboard", [DashboardController::class, 'index']);
$route->get("/order", [OrderController::class, 'index']);
$route->get("/order/details/{id}", [OrderController::class, 'details']);
$route->get("/booking", [BookingController::class, 'index']);
$route->get("/orders", [BookingController::class, 'index']); // Alias for booking
$route->get("/booking/details/{id}", [BookingController::class, 'details']);
$route->get("/orders/details/{id}", [BookingController::class, 'details']); // Alias for booking details
$route->get("/favorites", [FavoritesController::class, 'index']);
$route->get("/feedback", [FeedbackController::class, 'index']);
$route->get("/settings", [SettingsController::class, 'index']);

$route->route();