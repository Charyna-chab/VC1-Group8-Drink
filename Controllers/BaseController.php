<?php
class BaseController {

    public function views($views, $data = []) {
        extract($data); // Convert data array into variables
        ob_start(); // Start buffering the output
        require_once 'views/'.$views . '.php'; // Render the view
        $content = ob_get_clean(); // Capture the output into $content
        require_once 'views/layout.php'; // Now include the layout, passing $content
    }

    public function redirect($uri) {
        header('Location: ' . $uri);
        exit();
    }
}
?>
