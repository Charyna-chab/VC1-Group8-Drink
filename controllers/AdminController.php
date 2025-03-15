<?php
class AdminController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
        
        // Check if user is authenticated
        if (!is_authenticated()) {
            redirect('/login');
        }
        
        // Check if user is admin
        if (!is_admin()) {
            // Log unauthorized access attempt
            log_action('unauthorized_access', $_SESSION['user_id'] ?? null, 'failed', 'Attempted to access admin area');
            
            // Redirect to login page
            redirect('/login');
        }
    }
    
    /**
     * Admin dashboard
     */
    public function dashboard() {
        // Get user data
        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($user_id);
        
        // Include dashboard view
        include 'views/admin/dashboard.php';
    }
    
    /**
     * Admin users page
     */
    public function users() {
        // Get user data
        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($user_id);
        
        // Include users view
        include 'views/admin/users.php';
    }
    
    /**
     * Admin settings page
     */
    public function settings() {
        // Get user data
        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($user_id);
        
        // Include settings view
        include 'views/admin/settings.php';
    }
}

