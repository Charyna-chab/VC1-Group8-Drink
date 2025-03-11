<?php

class OrderController {
  private $db;
  
  public function __construct() {
      $this->db = Database::getInstance();
  }
  
  public function index() {
      // Check if user is logged in
      if (!isset($_SESSION['user'])) {
          header('Location: /login');
          exit;
      }
      
      // Get user's orders
      $userId = $_SESSION['user']['id'];
      $orders = $this->db->getOrdersByUserId($userId);
      
      // Make database available to the view
      $db = $this->db;
      
      require 'views/orders.php';
  }
  
  public function show() {
      // Check if user is logged in
      if (!isset($_SESSION['user'])) {
          header('Location: /login');
          exit;
      }
      
      // Get order ID from URL
      $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
      
      // Get order details
      // In a real application, you would fetch this from the database
      // For demo purposes, we'll create a sample order
      $order = [
          'id' => $id,
          'user_id' => $_SESSION['user']['id'],
          'product_id' => 1,
          'product_name' => 'Taro Milk Tea',
          'size' => 'medium',
          'sugar_level' => '50%',
          'toppings' => ['pearl', 'cream'],
          'price' => 5.35,
          'status' => 'completed',
          'created_at' => '2023-05-15 14:30:00'
      ];
      
      require 'views/order.php';
  }
  
  public function create() {
      // Check if user is logged in
      if (!isset($_SESSION['user'])) {
          header('Location: /login');
          exit;
      }
      
      // Check if form was submitted
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $userId = $_SESSION['user']['id'];
          $productId = $_POST['product_id'] ?? 0;
          $size = $_POST['size'] ?? 'medium';
          $sugarLevel = $_POST['sugar_level'] ?? '50%';
          $toppings = $_POST['toppings'] ?? [];
          $price = $_POST['price'] ?? 0;
          
          // Validate input
          if (empty($productId) || empty($price)) {
              // Error handling
              header('Location: /product?id=' . $productId);
              exit;
          }
          
          // Create order
          $orderId = $this->db->addOrder($userId, $productId, $size, $sugarLevel, $toppings, $price);
          
          // Redirect to order confirmation
          header('Location: /order?id=' . $orderId);
          exit;
      }
      
      // If not POST request, redirect to home
      header('Location: /');
      exit;
  }
}

