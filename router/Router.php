<?php
namespace YourNamespace;

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
        
        foreach ($this->routes[$method] ?? [] as $route => $controller) {
            $pattern = preg_replace('/{[^\/]+}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);  // Remove the full match
                
                // Extract controller class and method
                list($controllerClass, $method) = $controller;
                
                // Check if the controller class already includes the namespace
                if (strpos($controllerClass, '\\') === false) {
                    $controllerClass = '\\YourNamespace\\Controllers\\' . $controllerClass;
                }
                
                // Debugging: Check if the class exists
                if (!class_exists($controllerClass)) {
                    throw new \Exception("Controller class $controllerClass not found. Check the namespace and file path.");
                }
                
                // Instantiate the controller
                $controllerInstance = new $controllerClass();
                
                // Call the method with parameters
                call_user_func_array([$controllerInstance, $method], $matches);
                return;
            }
        }

        // Check for exact route match
        if (isset($this->routes[$method][$uri])) {
            list($controllerClass, $method) = $this->routes[$method][$uri];
            
            // Check if the controller class already includes the namespace
            if (strpos($controllerClass, '\\') === false) {
                $controllerClass = '\\YourNamespace\\Controllers\\' . $controllerClass;
            }

            if (!class_exists($controllerClass)) {
                throw new \Exception("Controller class $controllerClass not found. Check the namespace and file path.");
            }
            $controllerInstance = new $controllerClass();
            $controllerInstance->$method();
            return;
        }

        // Route not found
        header('HTTP/1.1 404 Not Found');
        echo '404 Page Not Found';
    }
}