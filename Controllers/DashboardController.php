<?php
namespace YourNamespace\Controllers;

require_once './Models/ProductModel.php';
require_once './controllers/BaseController.php';

use YourNamespace\Models\ProductModel;
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
        // Fetch total price and total product count
        $totalPrice = $this->productModel->getTotalPrice();
        $totalProducts = $this->productModel->getTotalProducts();

        // Pass data to the dashboard view
        $this->views('dashboard/list', [
            'totalPrice' => $totalPrice,
            'totalProducts' => $totalProducts,
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