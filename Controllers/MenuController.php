<?php
class MenuController {
    public function index() {
        $db = Database::getInstance();
    
        // Get category from query string
        $currentCategory = $_GET['category'] ?? 'all';
        
        // Get products based on category
        $products = $db->getProductsByCategory($currentCategory);
        
        // Get all categories
        $categories = $db->getCategories();
        
        // Get all toppings
        $toppings = $db->getAllToppings();
        
        // Load the menu view
        require_once 'views/menu.php';
    }
}