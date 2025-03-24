<?php
require_once __DIR__ . "/Router.php";
require_once __DIR__ . "/../controllers/BaseController.php";
require_once __DIR__ . "/../controllers/FavoritesController.php";
require_once __DIR__ . "/../controllers/FeedbackController.php";
require_once __DIR__ . "/../controllers/SettingsController.php";
require_once __DIR__ . "/../controllers/OrdersController.php";
require_once __DIR__ . "/../controllers/BookingController.php";
require_once __DIR__ . "/../controllers/AuthController.php";

use YourNamespace\Router;

// Authentication routes
$route->get("/login", [AuthController::class, 'login']);
$route->post("/login", [AuthController::class, 'login']);
$route->get("/logout", [AuthController::class, 'logout']);

$route->get("/admin-login", [AuthController::class, 'adminLogin']);
$route->post("/admin-login", [AuthController::class, 'adminLogin']);
$route->get("/admin-verification", [AuthController::class, 'adminVerification']);
$route->post("/admin-verification", [AuthController::class, 'adminVerification']);

$route->get("/register", [AuthController::class, 'register']);
$route->post("/register", [AuthController::class, 'register']);
$route->get("/register-success", [AuthController::class, 'registerSuccess']);
$route->get("/forgot-password", [AuthController::class, 'forgotPassword']);
$route->post("/forgot-password", [AuthController::class, 'forgotPassword']);

// Original routes
$route->get("/welcome", [WelcomeController::class, 'welcome']);
$route->get("/order", [OrdersController::class, 'index']);
$route->get("/order/details/{id}", [OrdersController::class, 'details']);
$route->post("/order/add-to-cart", [OrdersController::class, 'addToCart']);
$route->get("/cart", [OrdersController::class, 'cart']);
$route->get("/booking", [BookingController::class, 'index']);
$route->get("/orders", [BookingController::class, 'index']);
$route->get("/booking/details/{id}", [BookingController::class, 'details']);
$route->get("/orders/details/{id}", [BookingController::class, 'details']);
$route->get("/favorites", [FavoritesController::class, 'index']);
$route->post("/favorites/toggle", [FavoritesController::class, 'toggle']);
$route->get("/feedback", [FeedbackController::class, 'index']);
$route->get("/settings", [SettingsController::class, 'index']);

$route->route();

