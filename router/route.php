<?php
// Ensure autoloading is configured or manually include files
require_once __DIR__ . "/../router/Router.php";  // Include Router class
require_once __DIR__ . "/../controllers/BaseController.php";
require_once __DIR__ . "/../controllers/WelcomeController.php";
require_once __DIR__ . "/../controllers/FavoritesController.php";
require_once __DIR__ . "/../controllers/SettingsController.php";
require_once __DIR__ . "/../controllers/OrdersController.php";
require_once __DIR__ . "/../controllers/BookingController.php";
require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/AdminController.php";
require_once __DIR__ . "/../controllers/ProductController.php";
require_once __DIR__ . "/../controllers/FeedbackController.php";
require_once __DIR__ . "/../controllers/UserController.php";
require_once __DIR__ . "/../controllers/DashboardController.php";
require_once __DIR__ . "/../controllers/PaymentController.php";
require_once __DIR__ . "/../controllers/CashController.php";
require_once __DIR__ . "/../controllers/ReceiptController.php";
require_once __DIR__ . "/../controllers/Admin/AdminFeedbackController.php";
require_once __DIR__ . "/../controllers/GiftCardController.php";
require_once __DIR__ . "/../controllers/LocationsController.php";
require_once __DIR__ . "/../controllers/JoinTheTeamController.php";
require_once __DIR__ . "/../controllers/OrderListController.php";
require_once __DIR__ . "/../Models/OrderModel.php";

// Initialize the router
$route = new Router();

// Welcome page as the default route
$route->get("/", [WelcomeController::class, 'welcome']);

// Authentication routes
$route->get("/login", [AuthController::class, 'login']);
$route->post("/login", [AuthController::class, 'login']);
$route->get("/register", [AuthController::class, 'register']);
$route->post("/register", [AuthController::class, 'register']);
$route->get("/logout", [AuthController::class, 'logout']);

// Admin authentication routes
$route->get("/admin-login", [AuthController::class, 'adminLogin']);
$route->post("/admin-login", [AuthController::class, 'adminLogin']);
$route->get("/admin-verification", [AuthController::class, 'adminVerification']);
$route->post("/admin-verification", [AuthController::class, 'adminVerification']);

// Dashboard routes
$route->get("/admin-dashboard", [DashboardController::class, 'index']);

// User routes
$route->get("/users", [UserController::class, 'index']);
$route->get("/users/create", [UserController::class, 'create']);
$route->post("/users/store", [UserController::class, 'store']);
$route->get("/users/edit", [UserController::class, 'edit']);
$route->post("/users/update", [UserController::class, 'update']);
$route->post("/users/delete", [UserController::class, 'delete']);
$route->get("/profile", [UserController::class, 'profile']);
$route->post("/profile/update", [UserController::class, 'updateProfile']);

// Admin routes
$route->get("/admin", [AdminController::class, 'index']);
$route->get("/admin/users", [AdminController::class, 'users']);
$route->get("/admin/products", [AdminController::class, 'products']);
$route->get("/admin/orders", [AdminController::class, 'orders']);
$route->get("/admin/feedback", [AdminController::class, 'feedback']);
$route->get("/admin/settings", [AdminController::class, 'settings']);

// Product routes
$route->get("/products", [ProductController::class, 'index']);
$route->get("/products/create", [ProductController::class, 'create']);
$route->post("/products/store", [ProductController::class, 'store']);
$route->get("/products/edit", [ProductController::class, 'edit']);
$route->post("/products/update", [ProductController::class, 'update']);
$route->post("/products/delete", [ProductController::class, 'delete']);
$route->get("/products/details", [ProductController::class, 'details']);

// Order routes
$route->get("/order", [OrdersController::class, 'index']);
$route->post("/order/add", [OrdersController::class, 'addToCart']);
$route->post("/order/remove", [OrdersController::class, 'removeFromCart']);
$route->post("/order/update", [OrdersController::class, 'updateCart']);
$route->get("/order/checkout", [OrdersController::class, 'checkout']);
$route->post("/order/place", [OrdersController::class, 'placeOrder']);
$route->get("/order/confirmation", [OrdersController::class, 'confirmation']);
$route->get("/order/history", [OrdersController::class, 'history']);
$route->get("/order/details", [OrdersController::class, 'details']);

// Order List routes (admin)
$route->get("/order-list", [OrderListController::class, 'index']);
$route->get("/order-list/details", [OrderListController::class, 'details']);
$route->post("/update-order-status", [OrderListController::class, 'updateStatus']);
$route->post("/delete-order", [OrderListController::class, 'deleteOrder']);

// Payment routes
$route->get("/payment", [PaymentController::class, 'index']);
$route->post("/payment/process", [PaymentController::class, 'process']);
$route->get("/payment/success", [PaymentController::class, 'success']);
$route->get("/payment/cancel", [PaymentController::class, 'cancel']);

// Cash payment routes
$route->get("/cash", [CashController::class, 'index']);
$route->post("/cash/confirm", [CashController::class, 'confirm']);

// Receipt routes
$route->get("/receipts", [ReceiptController::class, 'index']);
$route->get("/receipts/view", [ReceiptController::class, 'view']);
$route->get("/receipts/download", [ReceiptController::class, 'download']);
$route->get("/admin/receipts", [ReceiptController::class, 'adminIndex']);

// Feedback routes
$route->get("/feedback", [FeedbackController::class, 'index']);
$route->post("/feedback/submit", [FeedbackController::class, 'submit']);
$route->get("/feedback/thank-you", [FeedbackController::class, 'thankYou']);

// Admin Feedback routes
$route->get("/admin/feedback", [AdminFeedbackController::class, 'index']);
$route->get("/admin/feedback/view", [AdminFeedbackController::class, 'view']);
$route->post("/admin/feedback/respond", [AdminFeedbackController::class, 'respond']);
$route->post("/admin/feedback/delete", [AdminFeedbackController::class, 'delete']);

// Favorites routes
$route->get("/favorites", [FavoritesController::class, 'index']);
$route->post("/favorites/add", [FavoritesController::class, 'add']);
$route->post("/favorites/remove", [FavoritesController::class, 'remove']);

// Settings routes
$route->get("/settings", [SettingsController::class, 'index']);
$route->post("/settings/update", [SettingsController::class, 'update']);
$route->get("/settings/password", [SettingsController::class, 'password']);
$route->post("/settings/password/update", [SettingsController::class, 'updatePassword']);

// Booking routes
$route->get("/booking", [BookingController::class, 'index']);
$route->post("/booking/create", [BookingController::class, 'create']);
$route->get("/booking/success", [BookingController::class, 'success']);
$route->get("/booking/history", [BookingController::class, 'history']);
$route->post("/booking/cancel", [BookingController::class, 'cancel']);
$route->get("/admin/bookings", [BookingController::class, 'adminIndex']);
$route->post("/admin/bookings/update", [BookingController::class, 'adminUpdate']);

// Gift Card routes
$route->get("/gift-cards", [GiftCardController::class, 'index']);
$route->post("/gift-cards/purchase", [GiftCardController::class, 'purchase']);
$route->get("/gift-cards/check-balance", [GiftCardController::class, 'checkBalance']);
$route->post("/gift-cards/redeem", [GiftCardController::class, 'redeem']);
$route->get("/admin/gift-cards", [GiftCardController::class, 'adminIndex']);

// Locations routes
$route->get("/locations", [LocationsController::class, 'index']);
$route->get("/locations/details", [LocationsController::class, 'details']);
$route->get("/admin/locations", [LocationsController::class, 'adminIndex']);
$route->get("/admin/locations/create", [LocationsController::class, 'create']);
$route->post("/admin/locations/store", [LocationsController::class, 'store']);
$route->get("/admin/locations/edit", [LocationsController::class, 'edit']);
$route->post("/admin/locations/update", [LocationsController::class, 'update']);
$route->post("/admin/locations/delete", [LocationsController::class, 'delete']);

// Join The Team routes
$route->get("/careers", [JoinTheTeamController::class, 'index']);
$route->get("/careers/job", [JoinTheTeamController::class, 'jobDetails']);
$route->get("/careers/apply", [JoinTheTeamController::class, 'apply']);
$route->post("/careers/submit", [JoinTheTeamController::class, 'submit']);
$route->get("/admin/careers", [JoinTheTeamController::class, 'adminIndex']);
$route->get("/admin/careers/applications", [JoinTheTeamController::class, 'applications']);
$route->post("/admin/careers/status", [JoinTheTeamController::class, 'updateStatus']);

// Final routing call
$route->route();