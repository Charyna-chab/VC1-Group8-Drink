<?php
// Modified BaseController.php
class BaseController
{
    /**
     * Helper function to render a view.
     *
     * @param string $view The view file to render.
     * @param array $data The data to pass to the view.
     */
    protected function view($view, $data = [])
    {
        extract($data);
        
        // Check if the view file exists
        $viewPath = "views/{$view}.php";
        if (!file_exists($viewPath)) {
            // Create directory if it doesn't exist
            $dir = dirname($viewPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Create an empty view file with a basic structure
            file_put_contents($viewPath, "<?php \n// View file for {$view}\n?>\n<div class=\"content\">\n    <h1>{$view}</h1>\n    <p>This view has been automatically generated.</p>\n</div>");
        }
        
        // Check if layout file exists
        if (!file_exists("views/layout.php")) {
            // Create directory if it doesn't exist
            if (!is_dir("views")) {
                mkdir("views", 0755, true);
            }
            
            // Create a basic layout file
            file_put_contents("views/layout.php", "<!DOCTYPE html>\n<html>\n<head>\n    <title><?php echo isset(\$title) ? \$title : 'Boba Tea Shop'; ?></title>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <link rel=\"stylesheet\" href=\"/assets/css/style.css\">\n    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css\">\n</head>\n<body>\n    <?php echo \$content; ?>\n    <script src=\"/assets/js/main.js\"></script>\n</body>\n</html>");
        }
        
        // Check if layouts directory exists
        if (!is_dir("views/layouts")) {
            mkdir("views/layouts", 0755, true);
        }
        
        // Check if header.php exists
        if (!file_exists("views/layouts/header.php")) {
            file_put_contents("views/layouts/header.php", "<!DOCTYPE html>\n<html>\n<head>\n    <title><?php echo isset(\$title) ? \$title : 'Boba Tea Shop'; ?></title>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <link rel=\"stylesheet\" href=\"/assets/css/style.css\">\n    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css\">\n</head>\n<body>");
        }
        
        // Check if sidebar.php exists
        if (!file_exists("views/layouts/sidebar.php")) {
            file_put_contents("views/layouts/sidebar.php", "<aside class=\"sidebar\">\n    <div class=\"branch-order-sidebar\">\n        <img src=\"<?php echo isset(\$branchLogo) ? \$branchLogo : '/assets/image/logo/logo.png'; ?>\" alt=\"Branch Logo\" class=\"branch-logo\">\n    </div>\n    <ul class=\"nav-list\">\n        <li><a href=\"/order\"><i class=\"fas fa-mug-hot drink-icon\"></i> Order drink</a></li>\n        <li><a href=\"/dashboard\"><i class=\"fas fa-tachometer-alt dashboard-icon\"></i> Dashboard</a></li>\n        <li><a href=\"/booking\"><i class=\"fas fa-calendar-check booking-icon\"></i> Booking</a></li>\n        <li><a href=\"/favorites\"><i class=\"fas fa-heart favorite-icon\"></i> Favorite</a></li>\n        <li><a href=\"/feedback\"><i class=\"fas fa-comment-alt feedback-icon\"></i> Feedback</a></li>\n        <li><a href=\"/settings\"><i class=\"fas fa-cogs setting-icon\"></i> Setting</a></li>\n    </ul>\n</aside>\n<main class=\"main-content\">");
        }
        
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        require "views/layout.php";
    }

    /**
     * Helper function to handle redirections.
     *
     * @param string $url The URL to redirect to.
     */
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}