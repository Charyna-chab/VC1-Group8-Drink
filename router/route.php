<?php
namespace YourNamespace;

require_once __DIR__ . "/Router.php";  // Ensure the correct path

require_once __DIR__ . "/../controllers/BaseController.php";
require_once __DIR__ . "/../controllers/WelcomeController.php";
require_once __DIR__ . "/../controllers/FavoritesController.php";
require_once __DIR__ . "/../controllers/SettingsController.php";
require_once __DIR__ . "/../controllers/OrderListController.php";
require_once __DIR__ . "/../controllers/BookingController.php";
require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/AdminController.php";
require_once __DIR__ . "/../controllers/FeedbackController.php";
require_once __DIR__ . "/../controllers/PaymentController.php";
require_once __DIR__ . "/../controllers/CashController.php";
require_once __DIR__ . "/../controllers/ReceiptController.php";
require_once __DIR__ . "/../controllers/Admin/AdminFeedbackController.php";
require_once __DIR__ . "/../controllers/GiftCardController.php";
require_once __DIR__ . "/../controllers/LocationsController.php";
require_once __DIR__ . "/../controllers/JoinTheTeamController.php";
require_once __DIR__ . "/../controllers/Admin/Users/UserController.php";
require_once __DIR__ . "/../controllers/Admin/Products/ProductController.php";
require_once __DIR__ . "/../controllers/Admin/DashboardController.php";
require_once __DIR__ . "/../controllers/Admin/Receipts/AdminReceiptController.php";

use YourNamespace\Router;
use YourNamespace\Controllers\WelcomeController;
use YourNamespace\Controllers\OrderListController;
use YourNamespace\Controllers\BookingController;
use YourNamespace\Controllers\FavoritesController;
use YourNamespace\Controllers\SettingsController;
use YourNamespace\Controllers\AuthController;
use YourNamespace\Controllers\AdminController;
use YourNamespace\Controllers\FeedbackController;
use YourNamespace\Controllers\PaymentController;
use YourNamespace\Controllers\CashController;
use YourNamespace\Controllers\ReceiptController;
use YourNamespace\Controllers\Admin\AdminFeedbackController;
use YourNamespace\Controllers\GiftCardController;
use YourNamespace\Controllers\LocationsController;
use YourNamespace\Controllers\JoinTheTeamController;
use YourNamespace\Controllers\Admin\Users\UserController;
use YourNamespace\Controllers\Admin\Products\ProductController;
use YourNamespace\Controllers\Admin\DashboardController;
use YourNamespace\Controllers\Admin\AdminReceiptController;

$route = new Router();

// Authentication routes
$route->get("/", [WelcomeController::class, 'welcome']);
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
$route->post("/update-profile", [AuthController::class, 'updateProfile']);
$route->post("/update-password", [AuthController::class, 'updatePassword']);

// Order List routes
$route->get("/admin/order-list", [OrderListController::class, 'index']);
$route->get("/admin/order/create", [OrderListController::class, 'create']);
$route->post("/admin/order/store", [OrderListController::class, 'store']);
$route->get("/admin/order/edit/{id}", [OrderListController::class, 'edit']);
$route->post("/admin/order/update", [OrderListController::class, 'update']);
$route->post("/admin/order/delete", [OrderListController::class, 'delete']);

// Admin Dashboard route
$route->get("/admin-dashboard", [DashboardController::class, 'index']);

$route->route();