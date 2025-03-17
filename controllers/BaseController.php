<?php
class BaseController {
    public function views($views, $data = []) {
        // Extract data into variables
        extract($data); 
        
        // Define the view path
        $viewPath = 'views/' . $views . '.php';

        // Check if the view file exists before including it
        if (!file_exists($viewPath)) {
            // Create directory if it doesn't exist
            $dir = dirname($viewPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // If view doesn't exist, show an error
            die("View file not found: {$viewPath}. Please create this file.");
        }

        // Start output buffering
        ob_start();
        
        // Include the view file
        require_once $viewPath;
        
        // Get the buffered content and clean the buffer
        $content = ob_get_clean();

        // Include the layout file and pass the content
        require_once 'views/layout.php';
    }

    public function redirect($uri) {
        header('Location: ' . $uri);
        exit();
    }
}
