<?php
namespace YourNamespace;

$root = dirname(__DIR__);

function safe_require($path) {
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    error_log("route.php: missing file: $path");
    return false;
}

function class_exists_safe($fqcn) {
    return class_exists($fqcn);
}

require_once __DIR__ . "/Router.php";

$required = [
    "/controllers/BaseController.php",
    "/controllers/WelcomeController.php",
    "/controllers/FavoritesController.php",
    "/controllers/SettingsController.php",
    "/controllers/Customer/OrdersController.php",
    "/controllers/BookingController.php",
    "/controllers/AuthController.php",
    "/controllers/AdminController.php",
    "/controllers/FeedbackController.php",
    "/controllers/PaymentController.php",
    "/controllers/CashController.php",
    "/controllers/ReceiptController.php",
    "/controllers/Admin/AdminFeedbackController.php",
    "/controllers/GiftCardController.php",
    "/controllers/LocationsController.php",
    "/controllers/JoinTheTeamController.php",
    "/controllers/CheckoutController.php",
    "/controllers/Admin/Users/UserController.php",
    "/controllers/Admin/Products/ProductController.php",
    "/controllers/Admin/DashboardController.php",
    "/controllers/Admin/AdminReceiptController.php",
    "/controllers/Customer/ToppingController.php",
    "/controllers/ProfileController.php",
    "/controllers/Admin/OrderListController.php",
];
foreach ($required as $rel) {
    safe_require($root . $rel);
}

use YourNamespace\Router;

$route = new Router();

// Register only if class exists
$map = [
    // GET,     path,                    FQCN,                                          method
    ['get',  "/",                       \YourNamespace\Controllers\WelcomeController::class,       'welcome'],
    ['get',  "/welcome",                \YourNamespace\Controllers\WelcomeController::class,       'welcome'],

    ['get',  "/login",                  \YourNamespace\Controllers\AuthController::class,          'login'],
    ['post', "/login",                  \YourNamespace\Controllers\AuthController::class,          'login'],
    ['get',  "/logout",                 \YourNamespace\Controllers\AuthController::class,          'logout'],
    ['get',  "/admin-login",            \YourNamespace\Controllers\AuthController::class,          'adminLogin'],
    ['post', "/admin-login",            \YourNamespace\Controllers\AuthController::class,          'adminLogin'],
    ['get',  "/admin-verification",     \YourNamespace\Controllers\AuthController::class,          'adminVerification'],
    ['post', "/admin-verification",     \YourNamespace\Controllers\AuthController::class,          'adminVerification'],
    ['get',  "/register",               \YourNamespace\Controllers\AuthController::class,          'register'],
    ['post', "/register",               \YourNamespace\Controllers\AuthController::class,          'register'],

    ['post', "/update-profile-image",   \YourNamespace\Controllers\ProfileController::class,       'updateProfileImage'],

    ['get',  "/gift-card",              \YourNamespace\Controllers\GiftCardController::class,      'index'],
    ['get',  "/gift-card/details/{id}", \YourNamespace\Controllers\GiftCardController::class,      'details'],
    ['get',  "/locations",              \YourNamespace\Controllers\LocationsController::class,     'index'],
    ['get',  "/locations/details/{id}", \YourNamespace\Controllers\LocationsController::class,     'details'],
    ['get',  "/join-the-team",          \YourNamespace\Controllers\JoinTheTeamController::class,   'index'],
    ['get',  "/join-the-team/apply",    \YourNamespace\Controllers\JoinTheTeamController::class,   'apply'],
    ['post', "/join-the-team/apply",    \YourNamespace\Controllers\JoinTheTeamController::class,   'apply'],
    ['get',  "/join-the-team/success",  \YourNamespace\Controllers\JoinTheTeamController::class,   'success'],

    ['get',  "/order",                  \YourNamespace\Controllers\OrdersController::class,        'index'],
    ['get',  "/order/details/{id}",     \YourNamespace\Controllers\OrdersController::class,        'details'],
    ['post', "/order/add-to-cart",      \YourNamespace\Controllers\OrdersController::class,        'addToCart'],
    ['get',  "/cart",                   \YourNamespace\Controllers\OrdersController::class,        'cart'],

    ['get',  "/checkout",               \YourNamespace\Controllers\CheckoutController::class,      'index'],
    ['post', "/process-payment",        \YourNamespace\Controllers\CheckoutController::class,      'processPayment'],
    ['get',  "/checkout/success",       \YourNamespace\Controllers\CheckoutController::class,      'success'],

    ['get',  "/payment",                \YourNamespace\Controllers\PaymentController::class,       'index'],
    ['get',  "/payment/{id}",           \YourNamespace\Controllers\PaymentController::class,       'show'],
    ['post', "/payment/process",        \YourNamespace\Controllers\PaymentController::class,       'process'],
    ['get',  "/cash",                   \YourNamespace\Controllers\CashController::class,          'index'],
    ['post', "/cash/process",           \YourNamespace\Controllers\CashController::class,          'process'],
    ['get',  "/cash/confirm/{id}",      \YourNamespace\Controllers\CashController::class,          'confirm'],

    ['get',  "/receipt",                \YourNamespace\Controllers\ReceiptController::class,       'index'],
    ['get',  "/receipt/download/{id}",  \YourNamespace\Controllers\ReceiptController::class,       'download'],
    ['get',  "/receipt/delete/{id}",    \YourNamespace\Controllers\ReceiptController::class,       'delete'],
    ['post', "/receipt/delete/{id}",    \YourNamespace\Controllers\ReceiptController::class,       'delete'],

    ['get',  "/booking",                \YourNamespace\Controllers\BookingController::class,       'index'],
    ['get',  "/booking/details/{id}",   \YourNamespace\Controllers\BookingController::class,       'details'],
    ['post', "/booking/create",         \YourNamespace\Controllers\BookingController::class,       'createBooking'],

    ['get',  "/favorites",              \YourNamespace\Controllers\FavoritesController::class,     'index'],
    ['post', "/favorites/toggle",       \YourNamespace\Controllers\FavoritesController::class,     'toggle'],

    ['get',  "/feedback",               \YourNamespace\Controllers\FeedbackController::class,      'index'],
    ['post', "/feedback",               \YourNamespace\Controllers\FeedbackController::class,      'index'],
    ['post', "/feedback/submit-review", \YourNamespace\Controllers\FeedbackController::class,      'submitReview'],
    ['post', "/feedback/submit-suggestion", \YourNamespace\Controllers\FeedbackController::class,  'submitSuggestion'],
    ['post', "/feedback/submit-report", \YourNamespace\Controllers\FeedbackController::class,      'submitReport'],

    ['get',  "/settings",               \YourNamespace\Controllers\SettingsController::class,      'index'],
];

// Admin routes — only register if the class exists
$adminMap = [
    ['get',  "/admin-dashboard",        \YourNamespace\Controllers\Admin\DashboardController::class,        'index'],
    ['get',  "/admin/receipts",         \YourNamespace\Controllers\Admin\AdminReceiptController::class,     'index'],
    ['get',  "/admin/receipts/download/{id}", \YourNamespace\Controllers\Admin\AdminReceiptController::class, 'download'],
    ['get',  "/admin/receipts/delete/{id}",   \YourNamespace\Controllers\Admin\AdminReceiptController::class, 'delete'],
    ['post', "/admin/receipts/delete/{id}",   \YourNamespace\Controllers\Admin\AdminReceiptController::class, 'delete'],
    ['get',  "/admin/receipts/export-csv",    \YourNamespace\Controllers\Admin\AdminReceiptController::class, 'exportCSV'],
    ['get',  "/admin/orders",           \YourNamespace\Controllers\Admin\OrderListController::class,       'index'],
    ['get',  "/admin/users",            \YourNamespace\Controllers\Admin\Users\UserController::class,      'index'],
    ['get',  "/admin/users/create",     \YourNamespace\Controllers\Admin\Users\UserController::class,      'create'],
    ['post', "/admin/users/store",      \YourNamespace\Controllers\Admin\Users\UserController::class,      'store'],
    ['get',  "/admin/users/edit/{id}",  \YourNamespace\Controllers\Admin\Users\UserController::class,      'edit'],
    ['post', "/admin/users/update/{id}",\YourNamespace\Controllers\Admin\Users\UserController::class,      'update'],
    ['post', "/admin/users/delete/{id}",\YourNamespace\Controllers\Admin\Users\UserController::class,      'destroy'],
    ['get',  "/admin/products/create",  \YourNamespace\Controllers\Admin\Products\ProductController::class,'create'],
    ['post', "/admin/products/store",   \YourNamespace\Controllers\Admin\Products\ProductController::class,'store'],
    ['get',  "/admin/products/edit/{id}",\YourNamespace\Controllers\Admin\Products\ProductController::class,'edit'],
    ['post', "/admin/products/update/{id}",\YourNamespace\Controllers\Admin\Products\ProductController::class,'update'],
    ['post', "/admin/products/delete/{id}",\YourNamespace\Controllers\Admin\Products\ProductController::class,'delete'],
];

foreach ($map as $r) {
    [$verb, $path, $cls, $method] = $r;
    if (class_exists($cls)) {
        $route->$verb($path, [$cls, $method]);
    }
}
foreach ($adminMap as $r) {
    [$verb, $path, $cls, $method] = $r;
    if (class_exists($cls)) {
        $route->$verb($path, [$cls, $method]);
    }
}

$route->route();
