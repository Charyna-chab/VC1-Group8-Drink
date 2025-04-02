<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;

class ProductController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkAdminAuth();
        $this->initializeProducts();
    }
    
    private function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/admin-login');
            exit();
        }
    }
    
    private function initializeProducts() {
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [
                [
                    'id' => 1,
                    'name' => 'Classic Milk Tea',
                    'description' => 'Our signature milk tea with premium tea leaves',
                    'price' => 4.99,
                    'category' => 'milk-tea',
                    'image' => '/assets/images/products/classic-milk-tea.jpg'
                ],
                [
                    'id' => 2,
                    'name' => 'Taro Milk Tea',
                    'description' => 'Creamy taro flavor with milk tea',
                    'price' => 5.49,
                    'category' => 'milk-tea',
                    'image' => '/assets/images/products/taro-milk-tea.jpg'
                ],
                [
                    'id' => 3,
                    'name' => 'Mango Fruit Tea',
                    'description' => 'Refreshing tea with fresh mango',
                    'price' => 5.99,
                    'category' => 'fruit-tea',
                    'image' => '/assets/images/products/mango-fruit-tea.jpg'
                ]
            ];
        }
    }
    
    public function index() {
        $this->views('admin/products/index', [
            'title' => 'Manage Products - XING FU CHA',
            'products' => $_SESSION['products'],
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        
        // Clear flash messages
        unset($_SESSION['success']);
        unset($_SESSION['error']);
    }
    
    public function create() {
        $this->views('admin/products/create', [
            'title' => 'Add New Product - XING FU CHA',
            'categories' => $this->getCategories()
        ]);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/products');
            return;
        }
        
        // Validate input
        $errors = $this->validateProduct($_POST);
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/admin/products/create');
            return;
        }
        
        // Handle image upload
        $image = $this->handleImageUpload();
        
        // Generate new ID
        $newId = !empty($_SESSION['products']) ? max(array_column($_SESSION['products'], 'id')) + 1 : 1;
        
        // Add new product
        $_SESSION['products'][] = [
            'id' => $newId,
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => (float)$_POST['price'],
            'category' => $_POST['category'],
            'image' => $image
        ];
        
        $_SESSION['success'] = 'Product added successfully';
        $this->redirect('/admin/products');
    }
    
    public function edit($id) {
        $product = $this->findProduct($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Product not found';
            $this->redirect('/admin/products');
            return;
        }
        
        $this->views('admin/products/edit', [
            'title' => 'Edit Product - XING FU CHA',
            'product' => $product,
            'categories' => $this->getCategories()
        ]);
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/products');
            return;
        }
        
        $productIndex = $this->findProductIndex($id);
        
        if ($productIndex === -1) {
            $_SESSION['error'] = 'Product not found';
            $this->redirect('/admin/products');
            return;
        }
        
        // Validate input
        $errors = $this->validateProduct($_POST);
        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('/admin/products/edit/' . $id);
            return;
        }
        
        // Handle image upload (keep current if no new image)
        $image = $this->handleImageUpload() ?? $_SESSION['products'][$productIndex]['image'];
        
        // Update product
        $_SESSION['products'][$productIndex] = [
            'id' => $id,
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => (float)$_POST['price'],
            'category' => $_POST['category'],
            'image' => $image
        ];
        
        $_SESSION['success'] = 'Product updated successfully';
        $this->redirect('/admin/products');
    }
    
    public function delete($id) {
        $productIndex = $this->findProductIndex($id);
        
        if ($productIndex === -1) {
            $_SESSION['error'] = 'Product not found';
            $this->redirect('/admin/products');
            return;
        }
        
        array_splice($_SESSION['products'], $productIndex, 1);
        $_SESSION['success'] = 'Product deleted successfully';
        $this->redirect('/admin/products');
    }
    
    // Helper methods
    private function findProduct($id) {
        foreach ($_SESSION['products'] as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }
    
    private function findProductIndex($id) {
        foreach ($_SESSION['products'] as $index => $product) {
            if ($product['id'] == $id) {
                return $index;
            }
        }
        return -1;
    }
    
    private function validateProduct($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors[] = 'Product name is required';
        }
        
        if (empty($data['description'])) {
            $errors[] = 'Description is required';
        }
        
        if (empty($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
            $errors[] = 'Valid price is required';
        }
        
        if (empty($data['category'])) {
            $errors[] = 'Category is required';
        }
        
        return $errors;
    }
    
    private function handleImageUpload() {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/products/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Validate image
        $imageInfo = getimagesize($_FILES['image']['tmp_name']);
        if ($imageInfo === false) {
            return null;
        }
        
        // Generate unique filename
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $extension;
        $uploadFile = $uploadDir . $fileName;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            return '/assets/images/products/' . $fileName;
        }
        
        return null;
    }
    
    private function getCategories() {
        return [
            'milk-tea' => 'Milk Tea',
            'fruit-tea' => 'Fruit Tea',
            'slush' => 'Slush',
            'coffee' => 'Coffee',
            'specialty' => 'Specialty Drinks'
        ];
    }
}