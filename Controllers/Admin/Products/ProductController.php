<?php

require_once './Models/ProductModel.php';
require_once './Controllers/BaseController.php';

use YourNamespace\BaseController;


class ProductController extends BaseController
{

    private $model;

    function __construct()
    {
        // Make sure sessions are started if you're using $_SESSION
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new ProductModel();
    }

    function index()
    {
        $products = $this->model->getProducts();
        $this->views('products/product-list.php', ['products' => $products]);
    }

    function create()
    {
        $this->views('products/product-create.php');
    }

    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set up the target directory for image uploads
            $uploadDir = 'uploads/product/';

            // Check if the directory exists, if not create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Creates the directory if it doesn't exist
            }

            // Set the image file path
            $imageName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $imageName;

            // Check if file is an image
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($imageFileType, $allowedTypes)) {
                // Try to upload the file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image_url = $uploadFile;  // Image URL or path saved to the database

                    // Prepare the data for the user
                    $data = [
                        'product_name' => isset($_POST['product_name']) ? $_POST['product_name'] : null,
                        'image' => $image_url,
                        'product_detail' => isset($_POST['product_detail']) ? $_POST['product_detail'] : null,
                        'price' => isset($_POST['price']) ? $_POST['price'] : null,
                    ];

                    // Validate that all required fields are present
                    if (empty($data['product_name']) || empty($data['product_detail']) || empty($data['price'])) {
                        $_SESSION['error'] = 'All fields except the image are required!';
                        $this->views('product/product_create.php', ['error' => $_SESSION['error']]); // Removed .php extension
                        return;
                    }
                }
            }

            $this->model->createProduct($data);
            $this->redirect('/product');
        }
    }


    function edit()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "Invalid product ID!";
            $this->redirect('/product');
            return;
        }
    
        $id = $_GET['id'];
        $product = $this->model->getProduct($id); // Fetch the product by ID
    
        if (!$product) {
            $_SESSION['error'] = "Product not found!";
            $this->redirect('/product');
            return;
        }
    
        $this->views('products/product-edit.php', ['product' => $product]); // Pass product data to the view
    }

    function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'product_name' => $_POST['product_name'],
                'image' => $_POST['image'],
                'product_detail' => $_POST['product_detail'],
                'price' => $_POST['price'],
            ];
                $this->model->updateProduct($id, $data); // Only call updateProduct
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
    
    function destroy()
  
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Validate product ID
            if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
                $_SESSION['error'] = 'Invalid product ID!';
                return $this->redirect('/product');
            }

            $id = $_GET['product_id'];

            if ($this->model->deleteProduct($id)) {
                $_SESSION['success'] = 'Product deleted successfully!';
            } else {
                $_SESSION['error'] = 'Failed to delete product! It may not exist.';
            }

            $this->redirect('/product');
        }
    }
}
                  