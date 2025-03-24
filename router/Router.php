<?php
namespace YourNamespace;

class Router {
    private $routes = [];
    
    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }
    
    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }
    
    private function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }
    
    public function route() {
        $path = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Remove query string if present
        if (($pos = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $pos);
        }
        
        // Remove trailing slash if present
        $path = rtrim($path, '/');
        
        // If path is empty, set it to '/'
        if (empty($path)) {
            $path = '/';
        }
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            $pattern = $this->convertRouteToRegex($route['path']);
            
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove the full match
                
                list($controller, $method) = $route['callback'];
                
                // ✅ Check if the controller class exists
                if (!class_exists($controller)) {
                    header("HTTP/1.0 500 Internal Server Error");
                    die("Error: Controller '$controller' not found.");
                }
                
                $controllerInstance = new $controller();
                
                // ✅ Check if the method exists
                if (!method_exists($controllerInstance, $method)) {
                    header("HTTP/1.0 500 Internal Server Error");
                    die("Error: Method '$method' not found in controller '$controller'.");
                }
                
                // ✅ Call the method with parameters
                call_user_func_array([$controllerInstance, $method], $matches);
                return;
            }
        }
        
        // ✅ Improved 404 handling
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found: No route matched '$path'.";
    }
    
    private function convertRouteToRegex($route) {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        return $pattern;
    }
}
