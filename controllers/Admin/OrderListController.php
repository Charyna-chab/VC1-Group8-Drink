<?php

namespace YourNamespace\Controllers\Admin;

require_once '/home/sreyneath/Desktop/VC1-Group8-Drink/Models/OrderModel.php';
require_once '/home/sreyneath/Desktop/VC1-Group8-Drink/controllers/BaseController.php';

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