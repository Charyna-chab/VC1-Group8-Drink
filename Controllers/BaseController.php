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
            $viewPath = 'views/' . $views . '.php';
            if (!file_exists($viewPath)) {
                die("View file not found: {$viewPath}. Please create this file.");
            }
            
            // Include header
            require_once 'views/layouts/header.php';
            
            // Include sidebar if not welcome page
            // if (strpos($views, 'welcome/') !== 0) {
            //     require_once 'views/layouts/sidebar.php';
            // }
            
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

    // Define the BaseController class
    protected function render($view) {
        // Logic to render the view
        echo "Rendering view: $view";
    }
}

class GiftCardController extends BaseController {
    public function index() {
        // Render the gift card page
        $this->views('gift-card');
    }
}

class LocationsController extends BaseController {
    public function index() {
        // Render the locations page
        $this->views('locations');
    }
}

class JoinTheTeamController extends BaseController {  // Fixed class declaration here
    public function index() {
        // Render the join-the-team page
        $this->views('join-the-team');
    }
}
class MoreController extends BaseController {  // Fixed class declaration here
    public function index() {
        // Render the join-the-team page
        $this->views('more');
    }
}
?>
