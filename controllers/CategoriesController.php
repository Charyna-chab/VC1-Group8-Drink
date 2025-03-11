<?php
class CategoriesController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        $categories = $this->db->getAllCategories();
        
        // Include the view
        include 'views/categories.php';
    }
}
?>
