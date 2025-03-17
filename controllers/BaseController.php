<?php
class BaseController {

    public function views($views, $data = []) {
        extract($data); // Extract data into variables
        ob_start(); // Start output buffering
        $content = ob_get_clean(); // Get the buffered content and clean the buffer

        // Include the layout and view files
        require_once 'views/layout.php'; // Include the layout file
        require_once 'views/' . $views . '.php'; // Include the view file
    }

    public function redirect($uri) {
        header('Location:' . $uri);
        exit();
    }
}