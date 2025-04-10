<?php

namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class BookingController extends BaseController {
    public function index() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // In a real application, you would fetch bookings from the database
        // For now, we'll create sample data
        $bookings = [
            [
                'id' => 1,
                'order_number' => 'ORD-001',
                'date' => '2023-05-15',
                'time' => '14:30',
                'items' => [
                    [
                        'name' => 'Classic Milk Tea',
                        'size' => 'Medium',
                        'sugar' => '50%',
                        'ice' => 'Regular',
                        'toppings' => ['Boba Pearls'],
                        'price' => 5.00
                    ]
                ],
                'total' => 5.00,
                'status' => 'Completed'
            ],
            [
                'id' => 2,
                'order_number' => 'ORD-002',
                'date' => '2023-05-18',
                'time' => '16:45',
                'items' => [
                    [
                        'name' => 'Taro Milk Tea',
                        'size' => 'Large',
                        'sugar' => '70%',
                        'ice' => 'Less',
                        'toppings' => ['Pudding', 'Grass Jelly'],
                        'price' => 6.75
                    ],
                    [
                        'name' => 'Mango Smoothie',
                        'size' => 'Medium',
                        'sugar' => '100%',
                        'ice' => 'Regular',
                        'toppings' => ['Fresh Fruit'],
                        'price' => 6.25
                    ]
                ],
                'total' => 13.00,
                'status' => 'Processing'
            ]
        ];
        
        $this->views('booking', [
            'title' => 'My Bookings',
            'bookings' => $bookings
        ]);
    }
    
    public function details($id) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // In a real application, you would fetch the booking from the database
        // For now, we'll create sample data
        $bookings = [
            1 => [
                'id' => 1,
                'order_number' => 'ORD-001',
                'date' => '2023-05-15',
                'time' => '14:30',
                'items' => [
                    [
                        'name' => 'Classic Milk Tea',
                        'size' => 'Medium',
                        'sugar' => '50%',
                        'ice' => 'Regular',
                        'toppings' => ['Boba Pearls'],
                        'price' => 5.00
                    ]
                ],
                'total' => 5.00,
                'status' => 'Completed',
                'payment_method' => 'Credit Card',
                'delivery_address' => '123 Main St, Apt 4B, New York, NY 10001',
                'contact' => '+1 (555) 123-4567'
            ],
            2 => [
                'id' => 2,
                'order_number' => 'ORD-002',
                'date' => '2023-05-18',
                'time' => '16:45',
                'items' => [
                    [
                        'name' => 'Taro Milk Tea',
                        'size' => 'Large',
                        'sugar' => '70%',
                        'ice' => 'Less',
                        'toppings' => ['Pudding', 'Grass Jelly'],
                        'price' => 6.75
                    ],
                    [
                        'name' => 'Mango Smoothie',
                        'size' => 'Medium',
                        'sugar' => '100%',
                        'ice' => 'Regular',
                        'toppings' => ['Fresh Fruit'],
                        'price' => 6.25
                    ]
                ],
                'total' => 13.00,
                'status' => 'Processing',
                'payment_method' => 'PayPal',
                'delivery_address' => '456 Park Ave, Suite 7C, New York, NY 10022',
                'contact' => '+1 (555) 987-6543'
            ]
        ];
        
        $booking = isset($bookings[$id]) ? $bookings[$id] : null;
        
        if (!$booking) {
            // Handle booking not found
            header('Location: /booking');
            exit;
        }
        
        $this->views('booking_details', [
            'title' => 'Booking Details',
            'booking' => $booking
        ]);
    }
    
    // Add a new method to create a booking from cart
    public function createBooking() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        
        // Get JSON data from request body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data || !isset($data['items']) || empty($data['items'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid request data']);
            exit;
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $subtotal += $item['totalPrice'];
        }
        
        $tax = $subtotal * 0.08; // 8% tax
        $total = $subtotal + $tax;
        
        // Generate a unique order ID
        $orderId = 'ORD' . date('YmdHis') . rand(100, 999);
        
        // Create booking
        $booking = [
            'id' => $orderId,
            'date' => date('Y-m-d H:i:s'),
            'items' => $data['items'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'status' => 'processing',
            'payment_status' => 'pending'
        ];
        
        // In a real application, you would save the booking to the database
        // For now, we'll store it in the session
        if (!isset($_SESSION['bookings'])) {
            $_SESSION['bookings'] = [];
        }
        
        $_SESSION['bookings'][$orderId] = $booking;
        
        echo json_encode([
            'success' => true,
            'message' => 'Booking created successfully',
            'booking' => $booking
        ]);
        exit;
    }
    
    // Add a method to complete a booking
    public function completeBooking($id) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if booking exists
        if (!isset($_SESSION['bookings']) || !isset($_SESSION['bookings'][$id])) {
            http_response_code(404); // Not Found
            echo json_encode(['success' => false, 'message' => 'Booking not found']);
            exit;
        }
        
        // Update booking status
        $_SESSION['bookings'][$id]['status'] = 'completed';
        $_SESSION['bookings'][$id]['payment_status'] = 'completed';
        
        echo json_encode([
            'success' => true,
            'message' => 'Booking completed successfully',
            'booking' => $_SESSION['bookings'][$id]
        ]);
        exit;
    }
}
