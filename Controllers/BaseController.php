<?php

namespace YourNamespace;

class BaseController {
    public function views($views, $data = []) {
        // Make sure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Extract variables from data array
        extract($data);

        // Determine the view path
        $viewPath = 'views/' . $views . '.php';

        if (!file_exists($viewPath)) {
            die("View file not found: {$viewPath}. Please create this file.");
        }

        // Check for view type
        $isAuthView = strpos($views, 'auth/') === 0;
        $isAdminView = strpos($views, 'admin/') === 0;

        if ($isAuthView || $isAdminView) {
            require_once $viewPath;
        } else {
            require_once $viewPath;
            require_once 'views/layouts/footer.php';
        }
    }

    public function redirect($uri) {
        header('Location: ' . $uri);
        exit();
    }
}
