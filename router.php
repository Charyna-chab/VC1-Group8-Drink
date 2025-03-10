<?php
class Router {
    private $controller;
    private $action;
    private $params;

    public function __construct() {
        $this->parseUrl();
    }

    private function parseUrl() {
        $url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        // Set controller, action and params
        $this->controller = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
        $this->action = isset($url[1]) ? $url[1] : 'index';
        $this->params = array_slice($url, 2);
    }

    public function route() {
        // Check if controller exists
        $controllerFile = 'controllers/' . $this->controller . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $this->controller();
            
            // Check if action exists
            if (method_exists($controller, $this->action)) {
                call_user_func_array([$controller, $this->action], $this->params);
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }
    }

    private function loadError() {
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->index();
    }
}
