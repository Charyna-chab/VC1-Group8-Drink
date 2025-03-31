<?php

class Router {
    private $routes = [];
    
    // Register GET route
    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }
    
    // Register POST route
    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }

    // Register PUT route
    public function put($path, $callback) {
        $this->addRoute('PUT', $path, $callback);
    }
    
    // Register DELETE route
    public function delete($path, $callback) {
        $this->addRoute('DELETE', $path, $callback);
    }
    
    // Add route to the routes array
    private function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }
    
    // Dispatch the request
    public function route() {
        $this->dispatch();
    }
    
    // Handle the route dispatch
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
        
        // Loop through routes to find a matching one
        foreach ($this->routes as $route) {
            // Skip if the HTTP method doesn't match
            if ($route['method'] !== $method) {
                continue;
            }
            
            // Convert the route to regex and match it against the path
            $pattern = $this->convertRouteToRegex($route['path']);
            
            if (preg_match($pattern, $path, $matches)) {
                // Remove the full match (the entire path)
                array_shift($matches);
                
                // Extract the controller and method from the callback
                list($controller, $method) = $route['callback'];
                
                // Ensure the controller class exists
                if (!class_exists($controller)) {
                    header("HTTP/1.0 404 Not Found");
                    echo "Controller not found: $controller";
                    return;
                }
                
                // Create an instance of the controller
                $controllerInstance = new $controller();
                
                // Ensure the method exists within the controller
                if (!method_exists($controllerInstance, $method)) {
                    header("HTTP/1.0 404 Not Found");
                    echo "Method not found: $method in $controller";
                    return;
                }
                
                // Call the controller method with parameters
                call_user_func_array([$controllerInstance, $method], $matches);
                return;
            }
        }
        
        // If no route is found, return a 404 error
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
    
    // Convert route to regex pattern
    private function convertRouteToRegex($route) {
        // Replace route parameters (e.g. {id}) with regex capture groups
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        
        // Add start and end delimiters
        $pattern = '#^' . $pattern . '$#';
        
        return $pattern;
    }
}
