<?php
namespace YourNamespace;

class BaseController {
    public function views($views, $data = []) {
        // Extract data into variables
        extract($data);
        
        // Check if the view is an auth view
        $isAuthView = strpos($views, 'auth/') === 0;
        
        if ($isAuthView) {
            // For auth views, include the view file directly without layout
            $viewPath = 'views/' . $views . '.php';
            if (!file_exists($viewPath)) {
                die("View file not found: {$viewPath}. Please create this file.");
            }
            require_once $viewPath;
        } else {
            // For non-auth views, use the layout
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

    /* Additional requested functionality below */
    /* These methods are added without modifying any existing code */

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function validateCsrfToken() {
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Invalid CSRF token!";
            $this->redirect('/');
            exit();
        }
    }

    protected function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function handleError($message, $redirectUrl = '/') {
        $_SESSION['error'] = $message;
        $this->redirect($redirectUrl);
        exit();
    }

    protected function handleSuccess($message, $redirectUrl = '/') {
        $_SESSION['success'] = $message;
        $this->redirect($redirectUrl);
        exit();
    }
}