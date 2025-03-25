<?php
class ProductController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function menu() {
        $categories = $this->db->getCategories();
        $products = $this->db->getAllProducts();
        
        require 'views/menu.php';
    }
    
    public function show() {
        // Get product ID from URL with validation
        $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
        
        if ($id <= 0) {
            // Invalid ID
            header("HTTP/1.0 400 Bad Request");
            require 'views/400.php';
            return;
        }
        
        // Get product details
        $product = $this->db->getProductById($id);
        
        if (!$product) {
            // Product not found
            header("HTTP/1.0 404 Not Found");
            require 'views/404.php';
            return;
        }
        
        // Get related products
        $relatedProducts = array_filter($this->db->getAllProducts(), function($p) use ($product) {
            return $p['category'] === $product['category'] && $p['id'] !== $product['id'];
        });
        
        // Limit to 4 related products
        $relatedProducts = array_slice($relatedProducts, 0, 4);
        
        require 'views/product.php';
    }
}