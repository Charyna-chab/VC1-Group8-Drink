<?php

namespace OrderController;

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
                array_shift($matches);
                list($controllerClass, $methodName) = $controller;
                $controllerInstance = new $controllerClass();
                call_user_func_array([$controllerInstance, $methodName], $matches);
                return;
            }
        }

        if (isset($this->routes[$method][$uri])) {
            list($controllerClass, $methodName) = $this->routes[$method][$uri];
            $controllerInstance = new $controllerClass();
            $controllerInstance->$methodName();
            return;
        }

        header('HTTP/1.1 404 Not Found');
        echo '404 Page Not Found';
    }
}
