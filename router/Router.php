<?php
// Router.php
define('BASE_DIR', __DIR__);  // Define the base directory globally

// namespace YourNamespace;

use YourNamespace\Controllers\OrderListController; // Ensure the correct namespace

class Router {
    private $routes = [];
    
    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }
    
    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }
    
    public function route() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Check for dynamic routes with parameters
        foreach ($this->routes[$method] ?? [] as $route => $controller) {
            $pattern = preg_replace('/{[^\/]+}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove the full match
                
                // Extract controller class and method
                list($controllerClass, $controllerMethod) = $controller;
                
                // Ensure class exists
                if (!class_exists($controllerClass)) {
                    header('HTTP/1.1 500 Internal Server Error');
                    echo "Error: Controller '$controllerClass' not found.";
                    return;
                }

                // Instantiate controller
                $controllerInstance = new $controllerClass();
                
                // Call method with parameters
                call_user_func_array([$controllerInstance, $controllerMethod], $matches);
                return;
            }
        }
        
        // Check for exact route match
        if (isset($this->routes[$method][$uri])) {
            list($controllerClass, $controllerMethod) = $this->routes[$method][$uri];
            
            // Ensure class exists
            if (!class_exists($controllerClass)) {
                header('HTTP/1.1 500 Internal Server Error');
                echo "Error: Controller '$controllerClass' not found.";
                return;
            }

            $controllerInstance = new $controllerClass();
            $controllerInstance->$controllerMethod();
            return;
        }
        
        // Route not found
        header('HTTP/1.1 404 Not Found');
        echo '404 Page Not Found';
    }
}
