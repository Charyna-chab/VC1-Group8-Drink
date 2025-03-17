<?php

class ProductController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function menu() {
        $categories = $this->db->getCategories();
        $products = $this->db->getAllProducts();
        
        require 'views/menu.php';
    }
    
    public function show() {
        // Get product ID from URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
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

