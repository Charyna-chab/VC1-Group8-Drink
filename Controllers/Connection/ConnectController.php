<?php
require_once './Models/ConnectModel.php';
require_once './Controllers/BaseController.php';
require_once './Controllers/ProductsController.php';

session_start(); // Ensure session is started

class ConnectController extends BaseController {

    public function addToCart() {
        // Ensure request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        // Get JSON data from request body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid request data']);
            exit;
        }

        // Validate required fields
        $requiredFields = ['product_id', 'size', 'sugar', 'ice', 'quantity'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
                exit;
            }
        }

        // Fetch product details from ProductsController
        $productController = new ProductsController();
        $product = $productController->getProductById($data['product_id']);

        if (!$product) {
            http_response_code(404); // Not Found
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }

        // Calculate total price based on product price and quantity
        $total_price = $product['price'] * $data['quantity'];

        // Initialize session cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Generate a unique ID for the cart item
        $cartItemId = uniqid();

        // Add to cart
        $_SESSION['cart'][] = [
            'id' => $cartItemId,
            'product_id' => $product['id'],
            'product_name' => $product['name'],
            'size' => $data['size'],
            'sugar' => $data['sugar'],
            'ice' => $data['ice'],
            'toppings' => isset($data['toppings']) ? $data['toppings'] : [],
            'quantity' => $data['quantity'],
            'price' => $product['price'],
            'total_price' => $total_price,
            'image' => $product['image'],
            'added_at' => date('Y-m-d H:i:s')
        ];

        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => count($_SESSION['cart'])
        ]);
        exit;
    }
}
