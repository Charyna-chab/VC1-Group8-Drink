<?php
class ProductController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function index() {
        $products = $this->db->getAllProducts();
        $categories = $this->db->getAllCategories();
        
        // Include the view
        include 'views/products.php';
    }
    
    public function getByCategory($category) {
        $products = $this->db->getProductsByCategory($category);
        $categories = $this->db->getAllCategories();
        $currentCategory = $category;
        
        // Include the view
        include 'views/products.php';
    }
    
    public function show($id) {
        $product = $this->db->getProductById($id);
        $toppings = $this->db->getAllToppings();
        
        if (!$product) {
            // Product not found
            header("HTTP/1.0 404 Not Found");
            include 'views/404.php';
            return;
        }
        
        // Include the view
        include 'views/product_detail.php';
    }
}
?>

