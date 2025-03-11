<?php
class Router {
    private $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function delete($uri, $action) {
        $this->routes['DELETE'][$uri] = $action;
    }

    public function put($uri, $action) {
        $this->routes['PUT'][$uri] = $action;
    }

    public function route() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            call_user_func([new $action[0], $action[1]]);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}


require_once "Router.php";
require_once "models/Database.php";
require_once __DIR__ . "/../controllers/WelcomeController.php";
require_once __DIR__ . "/../controllers/UserController.php";
require_once __DIR__ . "/../controllers/CategoriesController.php";
require_once __DIR__ . "/../controllers/ProductController.php";

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