<?php
namespace YourNamespace\Controllers;

use YourNamespace\Models\OrderModel;

class OrderListController {
    private $orderModel;
    
    public function __construct() {
        $this->orderModel = new OrderModel(); // Instantiate the OrderModel class
    }

    public function index() {
        $orders = $this->orderModel->getOrders();
        // Assume you're passing the data to a view for rendering
        $this->views('welcome/order-list', ['orders' => $orders]);
    }

    public function details($id) {
        $order = $this->orderModel->getOrder($id);
        // Render the order details view
        $this->views('welcome/order-details', ['order' => $order]);
    }

    public function updateStatus() {
        // Handle order status update logic
    }

    public function deleteOrder() {
        // Handle order deletion logic
    }

    private function views($view, $data = []) {
        extract($data);
        require_once BASE_DIR . "/views/" . $view . ".php"; // Adjust the path accordingly
    }
}
