<?php

namespace YourNamespace\Controllers;

use YourNamespace\BaseController;
use PDOException;

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
    public function createBooking()
    {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'You must log in to place an order']);
            exit;
        }

        // Get JSON data from the request body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data || !isset($data['items']) || empty($data['items'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid request data']);
            exit;
        }

        // Database connection
        require_once __DIR__ . '/../Database/database.php';
        $db = new \YourNamespace\Database\Database();
        $pdo = $db->getConnection();

        try {
            // Insert each item into the orders table
            foreach ($data['items'] as $item) {
                $stmt = $pdo->prepare("
                    INSERT INTO orders (user_id, product_id, drink_size, quantity, order_date)
                    VALUES (:user_id, :product_id, :drink_size, :quantity, NOW())
                ");
                $stmt->execute([
                    ':user_id' => $_SESSION['user_id'],
                    ':product_id' => $item['product_id'],
                    ':drink_size' => $item['drink_size'],
                    ':quantity' => $item['quantity']
                ]);
            }

            echo json_encode(['success' => true, 'message' => 'Booking created successfully']);
        } catch (PDOException $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Failed to create booking']);
        }
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
