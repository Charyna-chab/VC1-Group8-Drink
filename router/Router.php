<?php
<<<<<<< HEAD
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

=======

namespace YourNamespace;

class Router
{
    private $uri;
    private $method;
    private $routes = [];

    /**
     * Constructor to initialize the URI and request method.
     */
    public function __construct()
    {
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Registers a GET route.
     *
     * @param string $uri The URI of the route.
     * @param array $action The controller class and method to be executed.
     */
    public function get($uri, $action)
    {
        $this->routes[$uri] = [
            'method' => 'GET',
            'action' => $action
        ];
    }

    /**
     * Registers a POST route.
     *
     * @param string $uri The URI of the route.
     * @param array $action The controller class and method to be executed.
     */
    public function post($uri, $action)
    {
        $this->routes[$uri] = [
            'method' => 'POST',
            'action' => $action
        ];
    }

    /**
     * Registers a PUT route.
     *
     * @param string $uri The URI of the route.
     * @param array $action The controller class and method to be executed.
     */
    public function put($uri, $action)
    {
        $this->routes[$uri] = [
            'method' => 'PUT',
            'action' => $action
        ];
    }

    /**
     * Registers a DELETE route.
     *
     * @param string $uri The URI of the route.
     * @param array $action The controller class and method to be executed.
     */
    public function delete($uri, $action)
    {
        $this->routes[$uri] = [
            'method' => 'DELETE',
            'action' => $action
        ];
    }

    /**
     * Routes the request to the appropriate controller and method.
     */
    public function route()
    {
        foreach ($this->routes as $uri => $route) {
            // Convert route pattern to a regex that matches numbers (for IDs)
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([0-9]+)', trim($uri, '/'));

            if (preg_match("#^$pattern$#", trim($this->uri, '/'), $matches)) {
                array_shift($matches); // Remove full match
                $controllerClass = $route['action'][0];
                $function = $route['action'][1];

                $controller = new $controllerClass();
                $controller->$function(...$matches); // Pass extracted parameters
                exit;
            }
        }

        http_response_code(404);
        echo "Page not found";
    }
}

    
>>>>>>> 3fba3e96c0d806907f91a324a0ff0e492f707d04
