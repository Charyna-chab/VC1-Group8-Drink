<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class ReceiptController extends BaseController {
    public function index() {
        // Redirect to booking page if no order ID is provided
        if (!isset($_GET['order_id'])) {
            $this->redirect('/booking');
            return;
        }
        
        $orderId = $_GET['order_id'];
        
        // In a real application, you would fetch the order from the database
        // For now, we'll use localStorage data via JavaScript
        
        // Sample data for rendering
        $orderItems = [];
        $subtotal = 0;
        $tax = 0;
        $total = 0;
        
        $this->views('receipt', [
            'title' => 'Order Receipt',
            'orderItems' => $orderItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'orderId' => $orderId
        ]);
    }
    
    public function download($id) {
        // In a real application, you would generate a PDF receipt
        // For now, we'll just redirect to the receipt page
        $this->redirect('/receipt?order_id=' . $id);
    }
}

