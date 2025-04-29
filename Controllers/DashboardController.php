<?php
namespace YourNamespace\Controllers;

require_once './Models/ProductModel.php';
require_once './Models/OrderModel.php';
require_once './controllers/BaseController.php';

use YourNamespace\Models\ProductModel;
use YourNamespace\Models\OrderModel;
use YourNamespace\BaseController;

class DashboardController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $orderModel = new OrderModel();
        $totalorders = $orderModel->getTotalOrders(); // Fetch total orders

        $this->views('admin/dashboard', [
            'totalorders' => $totalorders, // Pass total orders to the view
            'totalPrice' => 10000, // Example value
            'totalProducts' => 50, // Example value
            'pendingRequests' => 18 // Example value
        ]);
    }

    public function views($views, $data = [])
    {
        extract($data);

        $viewPath = 'views/' . $views;
        if (!str_ends_with($viewPath, '.php')) {
            $viewPath .= '.php';
        }

        if (!file_exists($viewPath)) {
            die("View file not found: {$viewPath}. Please create this file.");
        }

        require_once $viewPath;
    }
}