<?php
namespace YourNamespace;

class BaseController {
    public function views($views, $data = []) {
        // Make sure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Extract data into variables
        extract($data);
        
        // Check if the view is an auth view
        $isAuthView = strpos($views, 'auth/') === 0;
        
        // Check if it's an admin view
        $isAdminView = strpos($views, 'admin/') === 0;
        
        if ($isAuthView) {
            // For auth views, include the view file directly without layout
            $viewPath = 'views/' . $views . '.php';
            if (!file_exists($viewPath)) {
                die("View file not found: {$viewPath}. Please create this file.");
            }
            require_once $viewPath;
        } elseif ($isAdminView) {
            // For admin views, use the admin layout
            $viewPath = 'views/' . $views . '.php';
            if (!file_exists($viewPath)) {
                die("View file not found: {$viewPath}. Please create this file.");
            }
            
            // Include the view
            require_once $viewPath;
        } else {
            // For non-auth views, use the regular layout
            $viewPath = 'views/' . $views . '.php';
            if (!file_exists($viewPath)) {
                die("View file not found: {$viewPath}. Please create this file.");
            }
            
            // Include the view
            require_once $viewPath;
            
            // Include footer
            require_once 'views/layouts/footer.php';
        }
    }
    
    public function redirect($uri) {
        header('Location: ' . $uri);
        exit();
    }
}
