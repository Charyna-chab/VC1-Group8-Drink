<?php

namespace YourNamespace\Controllers\Admin;

require_once __DIR__ . '/../../Models/OrderListModel.php';
require_once './controllers/BaseController.php';

use YourNamespace\Models\OrderListModel;
use YourNamespace\BaseController;

class OrderListController extends BaseController
{
    public function index()
    {
        // Use the correct model
        $orderModel = new OrderListModel();
        $orders = $orderModel->getAllOrders(); // Fetch all orders

        // Pass the orders to the view
        require_once __DIR__ . '/../../views/admin/order-list.php';
    }
}