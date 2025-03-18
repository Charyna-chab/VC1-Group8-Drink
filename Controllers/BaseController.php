<?php
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
            ob_start();
            $content = ob_get_clean();
            require_once 'views/layout.php';
            require_once 'views/' . $views . '.php';
        }
    }
    
    public function redirect($uri) {
        header('Location: ' . $uri);
        exit();
    }
}
?>
