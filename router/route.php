<?php
require_once "Router.php";
require_once "controllers/BaseController.php";
require_once "controllers/WelcomeController.php";
require_once "controllers/FavoritesController.php";
require_once "controllers/FeedbackController.php";
require_once "controllers/SettingsController.php";
require_once "controllers/OrdersController.php";
require_once "controllers/BookingController.php";
require_once "controllers/AuthController.php";

use YourNamespace\Router;

$route = new Router();

// Authentication routes
$route->get("/", [AuthController::class, 'index']);
$route->get("/login", [AuthController::class, 'login']);
$route->post("/login", [AuthController::class, 'login']);
$route->get("/register", [AuthController::class, 'register']);
$route->post("/register", [AuthController::class, 'register']);
$route->get("/register-success", [AuthController::class, 'registerSuccess']);
$route->get("/forgot-password", [AuthController::class, 'forgotPassword']);
$route->post("/forgot-password", [AuthController::class, 'forgotPassword']);
$route->get("/logout", [AuthController::class, 'logout']);

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
$route->get("/favorites", [FavoritesController::class, 'index']);
$route->post("/favorites/toggle", [FavoritesController::class, 'toggle']); // Add this line
$route->get("/feedback", [FeedbackController::class, 'index']);
$route->get("/settings", [SettingsController::class, 'index']);

$route->route();