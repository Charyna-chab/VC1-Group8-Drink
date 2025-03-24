<?php

class BaseController {
    
    public function views($views, $data = []) {
        // Extract data to make variables available in the view
        extract($data);
        
        // Start output buffering to capture the view content
        ob_start();
        // Include the specific view file (with .php extension)
        require_once 'views/' . $views ;
        // Get the buffered content
        $content = ob_get_clean();
        
        // Now include the layout file, which can use $content
        require_once 'views/layout.php';
    }
    
    public function redirect($uri) {
        header('Location: ' . $uri);
        exit();
    }
}

