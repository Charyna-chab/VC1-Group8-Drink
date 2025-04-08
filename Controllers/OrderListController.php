<?php
// Controllers/OrderListController.php

namespace YourNamespace\Controllers;

use YourNamespace\Controllers\BaseController;

class OrderListController
{
    private $orderModel;
    private $productModel;

    public function __construct()
    {
        // Include model files if not already included
        if (!class_exists('\YourNamespace\Models\OrderModel')) {
            require_once __DIR__ . '/../models/OrderModel.php';
        }
        
        if (!class_exists('\YourNamespace\Models\ProductModel')) {
            require_once __DIR__ . '/../models/ProductModel.php';
        }
        
        // Create model instances
        $this->orderModel = new \YourNamespace\Models\OrderModel();
        $this->productModel = new \YourNamespace\Models\ProductModel();
    }

    public function index()
    {
        // Process date filters if provided
        $dateFrom = $_GET['date_from'] ?? null;
        $dateTo = $_GET['date_to'] ?? null;
        
        // Get orders based on filters
        if ($dateFrom && $dateTo) {
            $orders = $this->orderModel->getOrdersByDateRange($dateFrom, $dateTo);
        } else {
            $orders = $this->orderModel->getAllOrders();
        }
        
        // Get product details for display
        $products = [];
        $productsList = $this->productModel->getProducts();
        if ($productsList) {
            foreach ($productsList as $product) {
                $products[$product['product_id']] = $product;
            }
        }
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Number of orders per page
        $totalOrders = count($orders);
        $totalPages = ceil($totalOrders / $limit);
        
        // Apply pagination to orders
        $offset = ($page - 1) * $limit;
        $paginatedOrders = array_slice($orders, $offset, $limit);
        
        // Render the view
        // $this->views('admin/order_list', [
        //     'title' => 'Order List',
        //     'orders' => $paginatedOrders,
        //     'products' => $products,
        //     'currentPage' => $page,
        //     'totalPages' => $totalPages
        // ]);
    }

    public function details($id)
    {
        // Get the specific order
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            $_SESSION['error'] = 'Order not found';
            header('Location: /admin/order-list');
            exit;
        }
        
        // Get product details
        $product = $this->productModel->getProductById($order['product_id']);
        
        // Get user details (you might need to create a UserModel for this)
        $user = [
            'user_id' => $order['user_id'],
            'name' => $order['user_name'] ?? 'User #' . $order['user_id'],
            'email' => 'user' . $order['user_id'] . '@example.com',
            'phone' => 'N/A'
        ];
        
        // Render the view
        $this->views('admin/order_details', [
            'title' => 'Order Details',
            'order' => $order,
            'product' => $product,
            'user' => $user
        ]);
    }
    
    public function create()
    {
        // Get all products for the dropdown
        $products = $this->productModel->getProducts();
        
        // Get all users for the dropdown (you might need to create a UserModel for this)
        $users = []; // Replace with actual user data
        
        // Render the view
        $this->views('admin/order_create', [
            'title' => 'Create New Order',
            'products' => $products,
            'users' => $users
        ]);
    }
    
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['error'] = 'Method not allowed';
            header('Location: /admin/order-list');
            exit;
        }
        
        // Validate form data
        $userId = $_POST['user_id'] ?? null;
        $productId = $_POST['product_id'] ?? null;
        $drinkSize = $_POST['drink_size'] ?? null;
        
        if (!$userId || !$productId || !$drinkSize) {
            $_SESSION['error'] = 'All fields are required';
            header('Location: /admin/order/create');
            exit;
        }
        
        // Create the order
        $success = $this->orderModel->saveOrder($userId, [
            [
                'product_id' => $productId,
                'size' => $drinkSize
            ]
        ]);
        
        if ($success) {
            $_SESSION['success'] = 'Order created successfully';
        } else {
            $_SESSION['error'] = 'Failed to create order';
        }
        
        header('Location: /admin/order-list');
        exit;
    }
    
    public function edit($id)
    {
        // Get the specific order
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            $_SESSION['error'] = 'Order not found';
            header('Location: /admin/order-list');
            exit;
        }
        
        // Get all products for the dropdown
        $products = $this->productModel->getProducts();
        
        // Get all users for the dropdown (you might need to create a UserModel for this)
        $users = []; // Replace with actual user data
        
        // Render the view
        $this->views('admin/order_edit', [
            'title' => 'Edit Order',
            'order' => $order,
            'products' => $products,
            'users' => $users
        ]);
    }
    
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['error'] = 'Method not allowed';
            header('Location: /admin/order-list');
            exit;
        }
        
        // Validate form data
        $userId = $_POST['user_id'] ?? null;
        $productId = $_POST['product_id'] ?? null;
        $drinkSize = $_POST['drink_size'] ?? null;
        
        if (!$userId || !$productId || !$drinkSize) {
            $_SESSION['error'] = 'All fields are required';
            header("Location: /admin/order/edit/{$id}");
            exit;
        }
        
        // Update the order
        $success = $this->orderModel->updateOrder($id, $userId, $productId, $drinkSize);
        
        if ($success) {
            $_SESSION['success'] = 'Order updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update order';
        }
        
        header('Location: /admin/order-list');
        exit;
    }
    
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['error'] = 'Method not allowed';
            header('Location: /admin/order-list');
            exit;
        }
        
        // Delete the order
        $success = $this->orderModel->deleteOrder($id);
        
        if ($success) {
            $_SESSION['success'] = 'Order deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete order';
        }
        
        header('Location: /admin/order-list');
        exit;
    }
}