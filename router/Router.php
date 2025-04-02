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

    public function put($path, $callback) {
        $this->addRoute('PUT', $path, $callback);
    }
    
    public function delete($path, $callback) {
        $this->addRoute('DELETE', $path, $callback);
    }
    
    private function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }
    
    public function route() {
        $this->dispatch();
    }
    
    public function dispatch() {
        $path = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Handle PUT and DELETE methods via POST with _method parameter
        if ($method === 'POST' && isset($_POST['_method'])) {
            if (in_array(strtoupper($_POST['_method']), ['PUT', 'DELETE'])) {
                $method = strtoupper($_POST['_method']);
            }
        }
        
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
            // Skip if method doesn't match
            if ($route['method'] !== $method) {
                continue;
            }
            
            // Convert route parameters to regex pattern
            $pattern = $this->convertRouteToRegex($route['path']);
            
            if (preg_match($pattern, $path, $matches)) {
                // Remove the full match
                array_shift($matches);
                
                // Extract the controller and method
                list($controller, $method) = $route['callback'];
                
                // Create controller instance
                $controllerInstance = new $controller();
                
                // Call the method with parameters
                call_user_func_array([$controllerInstance, $method], $matches);
                return;
            }
        }
        
        // No route found
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
    
    private function convertRouteToRegex($route) {
        // Replace route parameters with regex pattern
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        
        // Add start and end delimiters
        $pattern = '#^' . $pattern . '$#';
        
        return $pattern;
    }
}
