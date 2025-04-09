<?php
namespace YourNamespace\Controllers\Admin;

require_once __DIR__ . '/../../Models/OrderListModel.php'; // Add this line

use YourNamespace\Models\OrderListModel;

class OrderListController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderListModel();
    }

    public function index()
    {
        $orders = $this->orderModel->getAllOrders();
        require_once __DIR__ . '/../../views/order-list.php';
    }

    public function details($id)
    {
        $order = $this->orderModel->getOrderById($id);
        if (!$order) {
            $_SESSION['error'] = 'Order not found';
            header('Location: /admin/orders');
            exit;
        }
        require_once __DIR__ . '/../../views/order-details.php';
    }

    public function delete($id)
    {
        $success = $this->orderModel->deleteOrder($id);
        $_SESSION[$success ? 'success' : 'error'] = $success ? 'Order deleted successfully' : 'Failed to delete order';
        header('Location: /admin/orders');
        exit;
    }
}