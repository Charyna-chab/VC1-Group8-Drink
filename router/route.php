<?php
require_once "Router.php";
require_once "Models/Database.php";
require_once "controllers/BaseController.php";
require_once "controllers/WelcomeController.php";

use YourNamespace\Router;

$route = new Router();
$route->get("/", [WelcomeController::class, 'welcome']);

// User routes
$route->get("/user", [UserController::class, 'index']);
$route->get("/user/create", [UserController::class, 'create']);
$route->post("/user/store", [UserController::class, 'store']);
$route->delete("/user/delete/{id}", [UserController::class, 'destroy']);
$route->get("/user/edit/{id}", [UserController::class, 'edit']);
$route->put("/user/update/{id}", [UserController::class, 'update']);

// Categories routes
$route->get("/categories", [CategoriesController::class, 'index']);

// Products routes
$route->get("/products", [ProductController::class, 'index']);
$route->route();