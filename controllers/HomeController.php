<?php
require_once 'Database/database.php';
class HomeController {
    private $db;
    
    public function __construct() {
        // $this->db = Database::getInstance();
    }
    
    public function index() {
        // $featuredProducts = $this->db->getFeaturedProducts();
        // $categories = $this->db->getAllCategories();
        
        // Get current user if logged in
        $user = null;
        if (isset($_SESSION['user_id'])) {
            $user = $this->db->getUserById($_SESSION['user_id']);
        }
        
        // Include the view
        include 'views/home.php';
    }
}
?>

