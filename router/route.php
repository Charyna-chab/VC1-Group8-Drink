<?php
namespace YourNamespace;

require_once "router/Router.php";
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

$route->get("/register", [AuthController::class, 'register']);
$route->post("/register", [AuthController::class, 'register']);
$route->get("/register-success", [AuthController::class, 'registerSuccess']);
$route->get("/forgot-password", [AuthController::class, 'forgotPassword']);
$route->post("/forgot-password", [AuthController::class, 'forgotPassword']);

// Profile update routes
$route->post("/update-profile", [AuthController::class, 'updateProfile']);
$route->post("/update-password", [AuthController::class, 'updatePassword']);

// Original routes
$route->get("/welcome", [WelcomeController::class, 'welcome']);
$route->get("/order", [OrdersController::class, 'index']);
$route->get("/order/details/{id}", [OrdersController::class, 'details']);
$route->post("/order/add-to-cart", [OrdersController::class, 'addToCart']);
$route->get("/cart", [OrdersController::class, 'cart']);

// New checkout and payment routes
$route->get("/checkout", [OrdersController::class, 'checkout']);
$route->post("/process-payment", [OrdersController::class, 'processPayment']);

// New payment routes
$route->get("/payment", [PaymentController::class, 'index']);
$route->get("/payment/{id}", [PaymentController::class, 'show']);
$route->post("/payment/process", [PaymentController::class, 'process']);

// Cash payment routes
$route->get("/cash", [CashController::class, 'index']);
$route->post("/cash/process", [CashController::class, 'process']);
$route->get("/cash/confirm/{id}", [CashController::class, 'confirm']);

// Receipt routes
$route->get("/receipt", [ReceiptController::class, 'index']);
$route->get("/receipt/download/{id}", [ReceiptController::class, 'download']);

// Booking routes
$route->get("/booking", [BookingController::class, 'index']);
$route->get("/booking/details/{id}", [BookingController::class, 'details']);
$route->post("/booking/create", [BookingController::class, 'createBooking']);

// Order routes
$route->get("/orders", [OrdersController::class, 'index']);
$route->get("/orders/details/{id}", [OrdersController::class, 'details']);

// Favorites routes
$route->get("/favorites", [FavoritesController::class, 'index']);
$route->post("/favorites/toggle", [FavoritesController::class, 'toggle']);

// Feedback routes
$route->get("/feedback", [FeedbackController::class, 'index']);
$route->post("/feedback", [FeedbackController::class, 'index']);
$route->post("/feedback/submit-review", [FeedbackController::class, 'submitReview']);
$route->post("/feedback/submit-suggestion", [FeedbackController::class, 'submitSuggestion']);
$route->post("/feedback/submit-report", [FeedbackController::class, 'submitReport']);

$route->get("/settings", [SettingsController::class, 'index']);

// Admin routes
$route->get("/admin-dashboard", [DashboardController::class, 'index']);

// Admin Product Management
$route->get("/admin/products", [ProductController::class, 'index']);
$route->get("/admin/products/create", [ProductController::class, 'create']);
$route->post("/admin/products/store", [ProductController::class, 'store']);
$route->get("/admin/products/edit/{id}", [ProductController::class, 'edit']);
$route->post("/admin/products/update/{id}", [ProductController::class, 'update']);
$route->post("/admin/products/delete/{id}", [ProductController::class, 'delete']);

// Admin User Management
$route->get("/admin/users", [UserController::class, 'index']);
$route->get("/admin/users/create", [UserController::class, 'create']);
$route->post("/admin/users/store", [UserController::class, 'store']);
$route->get("/admin/users/edit/{id}", [UserController::class, 'edit']);
$route->post("/admin/users/update/{id}", [UserController::class, 'update']);
$route->post("/admin/users/delete/{id}", [UserController::class, 'delete']);

// Admin Feedback Management
$route->get("/admin/feedback", [FeedbackController::class, 'index']);
$route->get("/admin/feedback/create", [FeedbackController::class, 'create']);
$route->post("/admin/feedback/store", [FeedbackController::class, 'store']);
$route->get("/admin/feedback/edit/{id}", [FeedbackController::class, 'edit']);
$route->post("/admin/feedback/update/{id}", [FeedbackController::class, 'update']);
$route->post("/admin/feedback/delete/{id}", [FeedbackController::class, 'delete']);

$route->route();

