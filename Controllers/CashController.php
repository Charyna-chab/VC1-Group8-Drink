<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class CashController extends BaseController {
    public function index() {
        // Redirect to booking page if no order ID is provided
        if (!isset($_GET['order_id'])) {
            $this->redirect('/booking');
            return;
        }
        
        $orderId = $_GET['order_id'];
        
        // In a real application, you would fetch the order from the database
        // For now, we'll use sample data for rendering
        $orderItems = [];
        $subtotal = 0;
        $tax = 0;
        $total = 0;
        
        // If using localStorage data, we'll load it via JavaScript
        
        $this->views('cash', [
            'title' => 'Cash on Delivery',
            'orderItems' => $orderItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'orderId' => $orderId
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
        
        if (!$data || !isset($data['order_id'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid request data']);
            exit;
        }
        
        $orderId = $data['order_id'];
        $fullName = isset($data['full_name']) ? $data['full_name'] : '';
        $phone = isset($data['phone']) ? $data['phone'] : '';
        $address = isset($data['address']) ? $data['address'] : '';
        $notes = isset($data['notes']) ? $data['notes'] : '';
        
        // In a real application, you would:
        // 1. Validate the order exists
        // 2. Update the order with delivery information
        // 3. Update the order status in the database
        
        // For now, we'll just simulate a successful order confirmation
        $response = [
            'success' => true,
            'message' => 'Cash on delivery order confirmed successfully',
            'order_id' => $orderId,
            'delivery_info' => [
                'name' => $fullName,
                'phone' => $phone,
                'address' => $address,
                'notes' => $notes
            ]
        ];
        
        echo json_encode($response);
        exit;
    }
    
    public function confirm($id) {
        // In a real application, you would:
        // 1. Validate the order exists
        // 2. Update the order status in the database
        
        // For now, we'll just redirect to the booking page
        $this->redirect('/booking');
    }
}