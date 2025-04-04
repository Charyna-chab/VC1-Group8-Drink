<?php
namespace YourNamespace\Controllers\Admin\Products;

require_once './Models/ProductModel.php';
require_once './controllers/BaseController.php';

use YourNamespace\Models\ProductModel; // Keep this
use YourNamespace\BaseController; // Keep this

class ProductController extends BaseController
{
    private $model;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new ProductModel(); // Use the namespaced ProductModel
    }

    public function index()
    {
        $products = $this->model->getProducts(); // Fetch products from the database
        $this->views('products/product-list', ['products' => $products]); // Pass products to the view
    }

    public function create()
    {
        $this->views('products/product-create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uploadDir = 'uploads/product/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $data = [
                    'product_name' => $_POST['product_name'],
                    'product_detail' => $_POST['product_detail'],
                    'price' => $_POST['price'],
                    'image' => $uploadFile,
                ];

                $this->model->createProduct($data);
                $this->redirect('/admin/products');
            }
        }
    }

    public function edit($id)
    {
        $product = $this->model->getProduct($id);
        $this->views('products/product-edit', ['product' => $product]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = $_POST['existing_image'];

            if (!empty($_FILES['image']['name'])) {
                $uploadDir = 'uploads/product/';
                $imageName = basename($_FILES['image']['name']);
                $imagePath = $uploadDir . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    $image = $imagePath;
                }
            }

            $data = [
                'product_name' => $_POST['product_name'],
                'product_detail' => $_POST['product_detail'],
                'price' => $_POST['price'],
                'image' => $image,
            ];

            $this->model->updateProduct($id, $data);
            $this->redirect('/admin/products');
        }
    }

    public function destroy($id)
    {
        $this->model->deleteProduct($id);
        $this->redirect('/admin/products');
    }

    public function views($views, $data = []) {
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
