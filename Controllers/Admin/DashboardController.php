<?php

namespace YourNamespace\Controllers\Admin;

require_once './controllers/BaseController.php';
require_once './Models/ProductModel.php';

use YourNamespace\BaseController;

class DashboardController extends BaseController
{
    private $productModel;
    public function __construct()
    {
        $this->productModel = new \YourNamespace\Models\ProductModel();
    }
    public function index()
    {
        $prodCount = count($this->productModel->getProducts());
        $prodPrice = array_reduce($this->productModel->getProducts(), function ($carry, $item) {
            return $carry + $item['price'];
        }, 0);
        $this->views('admin/dashboard', ['totalProducts' => $prodCount, 'totalPrice' => $prodPrice]);	
    }
}
