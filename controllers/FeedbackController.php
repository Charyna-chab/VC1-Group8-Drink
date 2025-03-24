<?php
class FeedbackController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function index() {
        // Connect to database for products/orders if needed
        $db = $this->connectToDatabase();
        
        $this->views('feedback', [
            'title' => 'Feedback',
            'db' => $db
        ]);
    }
    
    // Connect to database
    private function connectToDatabase() {
        // In a real application, you would connect to your database here
        // For now, we'll create a simple database class with mock methods
        
        return new class {
            public function getAllProducts() {
                // Mock product data
                return [
                    ['id' => 1, 'name' => 'Taiwan Milk Tea'],
                    ['id' => 2, 'name' => 'Thai Tea Brown Sugar Red Bean'],
                    ['id' => 3, 'name' => 'Oolong Passion'],
                    ['id' => 4, 'name' => 'No Name Jewels'],
                    ['id' => 5, 'name' => 'Chocolate Cream'],
                ];
            }
            
            public function getOrdersByUserId($userId) {
                // Mock order data
                return [
                    ['id' => 'ORD123456', 'product_id' => 1],
                    ['id' => 'ORD123457', 'product_id' => 3],
                ];
            }
            
            public function getProductById($productId) {
                // Mock product data
                $products = [
                    1 => ['name' => 'Taiwan Milk Tea'],
                    2 => ['name' => 'Thai Tea Brown Sugar Red Bean'],
                    3 => ['name' => 'Oolong Passion'],
                    4 => ['name' => 'No Name Jewels'],
                    5 => ['name' => 'Chocolate Cream'],
                ];
                
                return isset($products[$productId]) ? $products[$productId] : null;
            }
        };
    }
    
    public function submitReview() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get form data
        $reviewType = isset($_POST['review_type']) ? $_POST['review_type'] : '';
        $productId = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $title = isset($_POST['review_title']) ? $_POST['review_title'] : '';
        $content = isset($_POST['review_content']) ? $_POST['review_content'] : '';
        
        // Validate required fields
        if (empty($reviewType) || empty($title) || empty($content) || $rating < 1) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            exit;
        }
        
        // If review type is product, product_id is required
        if ($reviewType === 'product' && empty($productId)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Please select a product']);
            exit;
        }
        
        
        // In a real application, you would:
        // 1. Validate the data
        // 2. Save the review to the database
        // 3. Update product rating
        
        // For now, we'll just return success
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your review!'
        ]);
        exit;
    }
    
    public function submitSuggestion() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get form data
        $suggestionType = isset($_POST['suggestion_type']) ? $_POST['suggestion_type'] : '';
        $title = isset($_POST['suggestion_title']) ? $_POST['suggestion_title'] : '';
        $content = isset($_POST['suggestion_content']) ? $_POST['suggestion_content'] : '';
        
        // Validate required fields
        if (empty($suggestionType) || empty($title) || empty($content)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            exit;
        }
        
        // In a real application, you would:
        // 1. Validate the data
        // 2. Save the suggestion to the database
        
        // For now, we'll just return success
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your suggestion!'
        ]);
        exit;
    }
    
    public function submitReport() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get form data
        $issueType = isset($_POST['issue_type']) ? $_POST['issue_type'] : '';
        $orderId = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $title = isset($_POST['issue_title']) ? $_POST['issue_title'] : '';
        $content = isset($_POST['issue_content']) ? $_POST['issue_content'] : '';
        
        // Validate required fields
        if (empty($issueType) || empty($title) || empty($content)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
            exit;
        }
        
        // If issue type is order, order_id is required
        if ($issueType === 'order' && empty($orderId)) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Please select an order']);
            exit;
        }
        
        // In a real application, you would:
        // 1. Validate the data
        // 2. Save the report to the database
        // 3. Create a support ticket
        
        // For now, we'll just return success
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your report! We will look into it as soon as possible.'
        ]);
        exit;
    }
}

