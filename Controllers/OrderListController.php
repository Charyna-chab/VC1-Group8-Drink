<?php
namespace YourNamespace\Controllers; // Corrected namespace

use YourNamespace\Models\OrderModel; // Import OrderModel if it's in the Models folder

class OrderListController
{
    private $model;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new OrderModel(); // Ensure OrderModel exists
    }

    public function index(): void
    {
        $orders = $this->model->getOrders();
        $this->render('welcome/order-list', ['orders' => $orders, 'title' => 'Order List']);
    }

    public function details(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "Invalid order ID!";
            $this->redirect('/order-list');
            return;
        }

        $id = (int) $_GET['id'];
        $order = $this->model->getOrder($id);

        if (!$order) {
            $_SESSION['error'] = "Order not found!";
            $this->redirect('/order-list');
            return;
        }

        $this->render('welcome/order-details', ['order' => $order, 'title' => 'Order Details']);
    }

    public function updateStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Invalid request method!";
            $this->redirect('/order-list');
            return;
        }

        if (!isset($_POST['order_id']) || !is_numeric($_POST['order_id'])) {
            $_SESSION['error'] = "Invalid order ID!";
            $this->redirect('/order-list');
            return;
        }

        $id = (int) $_POST['order_id'];
        $status = $_POST['status'] ?? 'pending';

        $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            $_SESSION['error'] = "Invalid status!";
            $this->redirect('/order-list');
            return;
        }

        $_SESSION['success'] = $this->model->updateOrderStatus($id, $status)
            ? "Order status updated successfully!"
            : "Failed to update order status!";

        $this->redirect('/order-list');
    }

    public function deleteOrder(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Invalid request method!";
            $this->redirect('/order-list');
            return;
        }

        if (!isset($_POST['order_id']) || !is_numeric($_POST['order_id'])) {
            $_SESSION['error'] = "Invalid order ID!";
            $this->redirect('/order-list');
            return;
        }

        $id = (int) $_POST['order_id'];

        $_SESSION['success'] = $this->model->deleteOrder($id)
            ? "Order deleted successfully!"
            : "Failed to delete order! It may not exist or have dependencies.";

        $this->redirect('/order-list');
    }
    
    // Corrected rendering function
    protected function render($view, $data = [])
    {
        extract($data);
        require_once __DIR__ . "/../views/{$view}.php";
    }
    
    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }
}
