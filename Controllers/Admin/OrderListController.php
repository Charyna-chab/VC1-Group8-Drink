<?php

namespace YourNamespace\Controllers\Admin;

require_once './Models/OrderModel.php';
require_once './controllers/BaseController.php';

use YourNamespace\Models\OrderModel;
use YourNamespace\BaseController;

class OrderListController extends BaseController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $orders = $this->orderModel->getOrders();
        $this->views('admin/order-list', ['orders' => $orders]);
    }
}