<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class PaymentController extends BaseController {
    public function index() {
        // Redirect to booking page if no order ID is provided
        $this->redirect('/booking');
    }
    
    public function show($id) {
        // In a real application, you would fetch the order from the database
        // For now, we'll use localStorage data via JavaScript
        
        // Sample data for rendering
        $orderItems = [];
        $subtotal = 0;
        $tax = 0;
        $total = 0;
        
        $this->views('payment', [
            'title' => 'Complete Payment',
            'orderItems' => $orderItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'orderId' => $id
        ]);
    }
    
    public function process() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get JSON data from request body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data || !isset($data['order_id']) || !isset($data['payment_method'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid request data']);
            exit;
        }
        
        $orderId = $data['order_id'];
        $paymentMethod = $data['payment_method'];
        
        // In a real application, you would:
        // 1. Validate the order exists
        // 2. Process the payment with a payment gateway
        // 3. Update the order status in the database
        
        // For now, we'll just simulate a successful payment
        $response = [
            'success' => true,
            'message' => 'Payment processed successfully',
            'order_id' => $orderId,
            'payment_method' => $paymentMethod
        ];
        
        echo json_encode($response);
        exit;
    }
}