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
            } else {
                die("Failed to upload the image.");
            }
        }
    }

    public function edit($id)
    {
        $product = $this->model->getProduct($id);
        if (!$product) {
            $_SESSION['error'] = "Product not found!";
            return $this->redirect('/product');
        }
        $this->views('products/product-edit.php', ['product' => $product]);
    }


    function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Invalid request method!";
            $this->redirect('/product');
            return;
        }

        if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
            $_SESSION['error'] = "Invalid product ID!";
            $this->redirect('/product');
            return;
        }

        $id = $_POST['product_id'];

        // Handle file upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = 'uploads/product/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imagePath;
            } else {
                $_SESSION['error'] = "Image upload failed!";
                $this->redirect('/product/edit?id=' . $id);
                return;
            }
        } else {
            $image = $_POST['existing_image']; // Keep existing image if no new one is uploaded
        }

        $data = [
            'product_name' => $_POST['product_name'],
            'product_detail' => $_POST['product_detail'],
            'price' => $_POST['price'],
            'image' => $image
        ];

        // Update the product
        if ($this->model->updateProduct($id, $data)) {
            $_SESSION['success'] = "Product updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update product!";
        }

        $this->redirect('/product');
    }




    function delete($id)
    {
        if (!is_numeric($id)) {
            $_SESSION['error'] = 'Invalid product ID!';
            return $this->redirect('/product');
        }

        if ($this->model->deleteProduct($id)) {
            $_SESSION['success'] = 'Product deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete product!';
        }

        $this->redirect('/product');
    }
}
