<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class ReceiptController extends BaseController
{
    function __construct()
    {
        // Make sure sessions are started if you're using $_SESSION
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    function index()
    {
        // Get user ID from session if user is logged in
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        
        if (!$userId) {
            $_SESSION['error'] = "You must be logged in to view receipts.";
            $this->redirect('/login');
            return;
        }
        
        // In a real application, you would fetch receipts from the database
        // For now, we'll use session data
        $receipts = isset($_SESSION['bookings']) ? $_SESSION['bookings'] : [];
        
        // Pass title to the view
        $this->views('receipt-list', ['receipts' => $receipts, 'title' => 'Your Receipts']);
    }

    function view($id = null)
    {
        if (!$id && isset($_GET['order_id'])) {
            $id = $_GET['order_id'];
        }
        
        if (!$id) {
            $_SESSION['error'] = "Invalid receipt ID!";
            $this->redirect('/booking');
            return;
        }
        
        // In a real application, you would fetch the receipt from the database
        // For now, we'll use session data or sample data
        $receipt = null;
        
        if (isset($_SESSION['bookings']) && isset($_SESSION['bookings'][$id])) {
            $receipt = $_SESSION['bookings'][$id];
        } else {
            // Sample data for testing
            $receipt = [
                'id' => $id,
                'date' => date('Y-m-d H:i:s'),
                'items' => [
                    [
                        'name' => 'Classic Milk Tea',
                        'size' => ['name' => 'Medium'],
                        'sugar' => ['name' => '50%'],
                        'ice' => ['name' => 'Regular'],
                        'toppings' => [['name' => 'Boba Pearls', 'price' => 0.50]],
                        'quantity' => 2,
                        'totalPrice' => 10.00
                    ],
                    [
                        'name' => 'Taro Milk Tea',
                        'size' => ['name' => 'Large'],
                        'sugar' => ['name' => '70%'],
                        'ice' => ['name' => 'Less'],
                        'toppings' => [
                            ['name' => 'Pudding', 'price' => 0.75],
                            ['name' => 'Grass Jelly', 'price' => 0.75]
                        ],
                        'quantity' => 1,
                        'totalPrice' => 6.75
                    ]
                ],
                'subtotal' => 16.75,
                'tax' => 1.34,
                'total' => 18.09,
                'status' => 'completed',
                'payment_method' => 'Credit Card',
                'payment_status' => 'completed'
            ];
        }
        
        $this->views('receipt', [
            'title' => 'Receipt',
            'receipt' => $receipt
        ]);
    }
    
    function download($id = null)
    {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id) {
            $_SESSION['error'] = "Invalid receipt ID!";
            $this->redirect('/booking');
            return;
        }
        
        // In a real application, you would fetch the receipt from the database
        // For now, we'll use session data or sample data
        $receipt = null;
        
        if (isset($_SESSION['bookings']) && isset($_SESSION['bookings'][$id])) {
            $receipt = $_SESSION['bookings'][$id];
        } else {
            // Sample data for testing
            $receipt = [
                'id' => $id,
                'date' => date('Y-m-d H:i:s'),
                'items' => [
                    [
                        'name' => 'Classic Milk Tea',
                        'size' => ['name' => 'Medium'],
                        'sugar' => ['name' => '50%'],
                        'ice' => ['name' => 'Regular'],
                        'toppings' => [['name' => 'Boba Pearls', 'price' => 0.50]],
                        'quantity' => 2,
                        'totalPrice' => 10.00
                    ],
                    [
                        'name' => 'Taro Milk Tea',
                        'size' => ['name' => 'Large'],
                        'sugar' => ['name' => '70%'],
                        'ice' => ['name' => 'Less'],
                        'toppings' => [
                            ['name' => 'Pudding', 'price' => 0.75],
                            ['name' => 'Grass Jelly', 'price' => 0.75]
                        ],
                        'quantity' => 1,
                        'totalPrice' => 6.75
                    ]
                ],
                'subtotal' => 16.75,
                'tax' => 1.34,
                'total' => 18.09,
                'status' => 'completed',
                'payment_method' => 'Credit Card',
                'payment_status' => 'completed'
            ];
        }
        
        // Generate PDF (in a real application, you would use a library like FPDF or TCPDF)
        // For now, we'll just output HTML that can be printed
        $this->views('receipt-download', [
            'title' => 'Download Receipt',
            'receipt' => $receipt
        ]);
    }
    
    function delete($id = null)
    {
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        if (!$id) {
            $_SESSION['error'] = "Invalid receipt ID!";
            $this->redirect('/receipt');
            return;
        }
        
        // In a real application, you would delete the receipt from the database
        // For now, we'll just remove it from the session
        if (isset($_SESSION['bookings']) && isset($_SESSION['bookings'][$id])) {
            unset($_SESSION['bookings'][$id]);
            $_SESSION['success'] = "Receipt deleted successfully!";
        } else {
            $_SESSION['error'] = "Receipt not found!";
        }
        
        $this->redirect('/receipt');
    }
}
