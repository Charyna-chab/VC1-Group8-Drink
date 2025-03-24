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

// Navbar routes
// Gift Card
$route->get("/gift-card", [GiftCardController::class, 'index']);





$route->get("/favorites", [FavoritesController::class, 'index']);
$route->post("/favorites/toggle", [FavoritesController::class, 'toggle']);
$route->get("/feedback", [FeedbackController::class, 'index']);


$route->route();