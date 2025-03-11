<?php
require_once "Router.php";
require_once "Models/Database.php";
require_once "controllers/BaseController.php";
require_once "controllers/WelcomeController.php";


use YourNamespace\Router;

$route = new Router();
$route->get("/", [WelcomeController::class, 'welcome']);

$route->route();