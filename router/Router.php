<?php
class Router {
    private $routes = [];
    
    public function addRoute($path, $handler) {
        $this->routes[$path] = $handler;
    }
    
    public function dispatch() {
        // Get the current URL path
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        
        // Remove base path from URL
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        $uri = substr($uri, strlen($basePath));
        
        // Default to index if empty
        if (empty($uri) || $uri === '/') {
            $uri = '/';
        }
        
        // Find matching route
        foreach ($this->routes as $route => $handler) {
            // Convert route parameters to regex pattern
            $pattern = preg_replace('/:[a-zA-Z0-9]+/', '([a-zA-Z0-9_-]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';
            
            if (preg_match($pattern, $uri, $matches)) {
                // Extract parameters
                $params = [];
                preg_match_all('/:([a-zA-Z0-9]+)/', $route, $paramNames);
                
                for ($i = 0; $i < count($paramNames[1]); $i++) {
                    $params[$paramNames[1][$i]] = $matches[$i + 1];
                }
                
                // Parse handler (Controller@method)
                list($controller, $method) = explode('@', $handler);
                
                // Call the controller method with parameters
                $controllerInstance = new $controller();
                call_user_func_array([$controllerInstance, $method], $params);
                return;
            }
        }
        
        // No route found - 404
        header("HTTP/1.0 404 Not Found");
        include 'views/404.php';
    }
}
?>

    