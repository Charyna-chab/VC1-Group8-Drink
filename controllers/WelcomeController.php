<?php

class WelcomeController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function welcome() {
        $categories = $this->db->getAllCategories();
        $featuredProducts = $this->db->getFeaturedProducts();
        
        // Include the welcome view
        include 'views/welcome/welcome.php';
    }
}
?>