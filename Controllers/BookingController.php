<?php

namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class BookingController extends BaseController {
    public function index() {
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
}
