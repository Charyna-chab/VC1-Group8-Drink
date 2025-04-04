<?php
// Manually include your files or ensure autoloading is configured
require_once "Router.php";  // Include Router class
require_once "controllers/BaseController.php";
require_once "controllers/WelcomeController.php";
require_once "controllers/FavoritesController.php";
require_once "controllers/SettingsController.php";
require_once "controllers/OrdersController.php";
require_once "controllers/BookingController.php";
require_once "controllers/AuthController.php";
require_once "controllers/AdminController.php";
require_once "controllers/ProductController.php";
require_once "controllers/FeedbackController.php";
require_once "controllers/UserController.php";
require_once "controllers/DashboardController.php";
require_once "controllers/PaymentController.php";
require_once "controllers/CashController.php";
require_once "controllers/ReceiptController.php";
require_once "controllers/Admin/AdminFeedbackController.php";
require_once "controllers/GiftCardController.php";
require_once "controllers/LocationsController.php";
require_once "controllers/JoinTheTeamController.php";
require_once "controllers/OrderListController.php";
require_once "Models/OrderModel.php";

// Use the correct namespaces for controllers and Router class
use YourNamespace\Router;
use YourNamespace\Controllers\WelcomeController;
use YourNamespace\Controllers\OrdersController;
use YourNamespace\Controllers\BookingController;
use YourNamespace\Controllers\FavoritesController;
use YourNamespace\Controllers\SettingsController;
use YourNamespace\Controllers\AuthController;
use YourNamespace\Controllers\AdminController;
use YourNamespace\Controllers\ProductController;
use YourNamespace\Controllers\FeedbackController;
use YourNamespace\Controllers\UserController;
use YourNamespace\Controllers\DashboardController;
use YourNamespace\Controllers\PaymentController;
use YourNamespace\Controllers\CashController;
use YourNamespace\Controllers\ReceiptController;
use YourNamespace\Controllers\Admin\AdminFeedbackController;
use YourNamespace\Controllers\GiftCardController;
use YourNamespace\Controllers\LocationsController;
use YourNamespace\Controllers\JoinTheTeamController;
use YourNamespace\Controllers\OrderListController;

// Create the Router instance and define routes
$route = new Router();

// Welcome page as the default route
$route->get("/", [WelcomeController::class, 'welcome']);

// Authentication routes
$route->get("/login", [AuthController::class, 'login']);
$route->post("/login", [AuthController::class, 'login']);
$route->get("/logout", [AuthController::class, 'logout']);

$route->get("/admin-login", [AuthController::class, 'adminLogin']);
$route->post("/admin-login", [AuthController::class, 'adminLogin']);
$route->get("/admin-verification", [AuthController::class, 'adminVerification']);
$route->post("/admin-verification", [AuthController::class, 'adminVerification']);

// Other routes here ...

// Define routes for OrderListController
$route->get("/order-list", [OrderListController::class, 'index']);
$route->get("/order-list/details", [OrderListController::class, 'details']);
$route->post("/update-order-status", [OrderListController::class, 'updateStatus']);
$route->post("/delete-order", [OrderListController::class, 'deleteOrder']);

// Final routing call
$route->route();
