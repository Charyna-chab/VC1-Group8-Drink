<?php

namespace YourNamespace\Controllers\Admin;

require_once __DIR__ . '/../../Models/Customer/OrderModel.php';
require_once './controllers/BaseController.php';

use YourNamespace\Models\OrderModel;
use YourNamespace\BaseController;

class OrderListController extends BaseController
{
    public function index()
    {
        $orderModel = new \YourNamespace\Models\OrderModel();
        $orders = $orderModel->getOrders(); // Fetch all orders

        var_dump($orders);
        exit;

        // Pass the orders to the view
        require_once __DIR__ . '/../../views/admin/order-list.php';
    }
}