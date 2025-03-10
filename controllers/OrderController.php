<?php
class OrderController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function add() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        // Get product ID from POST data
        $productId = $_POST['product_id'] ?? null;
        
        if (!$productId) {
            echo json_encode(['error' => 'Product ID is required']);
            return;
        }
        
        // Get product details
        $product = $this->db->getProductById($productId);
        
        if (!$product) {
            echo json_encode(['error' => 'Product not found']);
            return;
        }
        
        // Return product details as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'product' => $product
        ]);
    }
    
    public function place() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        // Get order data from POST
        $productId = $_POST['product_id'] ?? null;
        $size = $_POST['size'] ?? 'Small';
        $sugarLevel = $_POST['sugar_level'] ?? '100%';
        $toppings = $_POST['toppings'] ?? [];
        
        if (!$productId) {
            echo json_encode(['error' => 'Product ID is required']);
            return;
        }
        
        // Get product details
        $product = $this->db->getProductById($productId);
        
        if (!$product) {
            echo json_encode(['error' => 'Product not found']);
            return;
        }
        
        // Calculate total price
        $basePrice = $product['price'];
        $sizePrice = 0;
        
        if ($size === 'Medium') {
            $sizePrice = 0.50;
        } else if ($size === 'Large') {
            $sizePrice = 1.00;
        }
        
        $toppingPrice = count($toppings) * 0.85;
        $totalPrice = $basePrice + $sizePrice + $toppingPrice;
        
        // Create order data
        $orderData = [
            'product_id' => $productId,
            'product_name' => $product['name'],
            'product_image' => $product['image'],
            'size' => $size,
            'sugar_level' => $sugarLevel,
            'toppings' => $toppings,
            'base_price' => $basePrice,
            'size_price' => $sizePrice,
            'topping_price' => $toppingPrice,
            'total_price' => $totalPrice,
            'user_id' => $_SESSION['user_id'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Save order to database
        $orderId = $this->db->createOrder($orderData);
        
        // Return success response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'order_id' => $orderId,
            'message' => 'Order placed successfully',
            'order' => $orderData
        ]);
    }
}
?>

