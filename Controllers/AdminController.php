<?php
class AdminController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in and is an admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/login');
        }
    }
    
    public function dashboard() {
        $this->views('admin/dashboard', [
            'title' => 'Admin Dashboard - XING FU CHA',
            'user' => $_SESSION['user']
        ]);
    }
    
    public function users() {
        // In a real application, you would fetch users from the database
        $users = [
            [
                'id' => 1,
                'name' => 'Demo User',
                'email' => 'user@example.com',
                'role' => 'user',
                'created_at' => '2023-01-01'
            ],
            [
                'id' => 2,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'role' => 'user',
                'created_at' => '2023-01-15'
            ],
            [
                'id' => 3,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'role' => 'user',
                'created_at' => '2023-02-01'
            ]
        ];
        
        $this->views('admin/users', [
            'title' => 'Manage Users - XING FU CHA',
            'users' => $users
        ]);
    }
    
    public function orders() {
        // In a real application, you would fetch orders from the database
        $orders = [
            [
                'id' => 'ORD001',
                'user_name' => 'Demo User',
                'total' => 15.75,
                'status' => 'completed',
                'date' => '2023-03-15'
            ],
            [
                'id' => 'ORD002',
                'user_name' => 'John Doe',
                'total' => 22.50,
                'status' => 'processing',
                'date' => '2023-03-16'
            ],
            [
                'id' => 'ORD003',
                'user_name' => 'Jane Smith',
                'total' => 18.25,
                'status' => 'cancelled',
                'date' => '2023-03-17'
            ]
        ];
        
        $this->views('admin/orders', [
            'title' => 'Manage Orders - XING FU CHA',
            'orders' => $orders
        ]);
    }
    
    public function products() {
        // In a real application, you would fetch products from the database
        $products = [
            [
                'id' => 1,
                'name' => 'Taiwan Milk Tea',
                'price' => 1.75,
                'category' => 'milk-tea',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'name' => 'Thai Tea Brown Sugar Red Bean',
                'price' => 2.50,
                'category' => 'milk-tea',
                'status' => 'active'
            ],
            [
                'id' => 9,
                'name' => 'Avocado Fresh Milk',
                'price' => 2.50,
                'category' => 'smoothie',
                'status' => 'active'
            ]
        ];
        
        $this->views('admin/products', [
            'title' => 'Manage Products - XING FU CHA',
            'products' => $products
        ]);
    }
}

