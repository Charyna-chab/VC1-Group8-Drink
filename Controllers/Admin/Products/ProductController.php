<?php

namespace YourNamespace\Controllers\Admin\Products;

require_once './Models/ProductModel.php';
require_once './controllers/BaseController.php';

use YourNamespace\Models\ProductModel; // Keep this
use YourNamespace\BaseController; // Keep this
use PDOException; // Add this to import PDOException

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

        // Check if file uploaded successfully
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $data = [
                'product_name' => $_POST['product_name'],
                'product_detail' => $_POST['product_detail'],
                'price' => $_POST['price'],
                'image' => $uploadFile,
                'category' => $_POST['category'], // Add category to data array
                'quantity' => $_POST['quantity'],
            ];

            $this->model->createProduct($data);
            $this->redirect('/product');
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
        $this->views('products/product-edit', ['product' => $product]);
    }


    public function update($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product = $this->model->getProduct($id);

        if (!$product) {
            $_SESSION['error'] = "Product not found!";
            return $this->redirect('/product');
        }

        $product_name = $_POST['product_name'];
        $product_detail = $_POST['product_detail'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $existing_image = $_POST['existing_image'];

        // Handle file upload
        $image = $existing_image;
        if (!empty($_FILES['image']['name'])) {
            $upload_dir = __DIR__ . '/../public/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $filename = time() . '_' . basename($_FILES['image']['name']);
            $target_file = $upload_dir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $filename;

                // Optionally delete the old image
                $old_image_path = $upload_dir . $existing_image;
                if (file_exists($old_image_path) && $existing_image !== '') {
                    unlink($old_image_path);
                }
            }
        }

        $data = [
            'product_name' => $product_name,
            'product_detail' => $product_detail,
            'price' => $price,
            'category' => $category,
            'quantity' => $quantity,
            'image' => $image,
        ];

        $updated = $this->model->updateProduct($id, $data);

        if ($updated) {
            $_SESSION['success'] = "Product updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update product.";
        }

        return $this->redirect('/product');
    }

    
}



public function delete($id)
{
    if (!is_numeric($id)) {
        $_SESSION['error'] = 'Invalid product ID!';
        return $this->redirect('/product');
    }

    try {
        // First check if product exists
        $product = $this->model->getProduct($id);
        if (!$product) {
            $_SESSION['error'] = 'Product not found!';
            return $this->redirect('/product');
        }

        // Delete the product image if exists
        if (!empty($product['image'])){
            $imagePath = __DIR__ . '/../../public/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete from database
        $deleted = $this->model->deleteProduct($id);
        
        if ($deleted) {
            $_SESSION['success'] = 'Product deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete product!';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    }

    return $this->redirect('/product');
}
}