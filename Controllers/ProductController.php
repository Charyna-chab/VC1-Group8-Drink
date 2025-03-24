<?php
class ProductController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkAdminAuth();
    }
    
    private function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/admin-login');
        }
    }
    
    public function index() {
        // In a real application, you would fetch products from a database
        // For demo purposes, we'll use a session array
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
        
        $this->views('admin/products/index', [
            'title' => 'Manage Products - XING FU CHA',
            'products' => $_SESSION['products']
        ]);
    }
    
    public function create() {
        $this->views('admin/products/create', [
            'title' => 'Add New Product - XING FU CHA'
        ]);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/products');
        }
        
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $category = $_POST['category'] ?? '';
        
        // Handle image upload
        $image = '/assets/images/products/default.jpg'; // Default image
      // Default image
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/products/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            // Check if it's a valid image
            $imageInfo = getimagesize($_FILES['image']['tmp_name']);
            if ($imageInfo !== false) {
                // Move the uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = '/assets/images/products/' . $fileName;
                }
            }
        }
        
        // Validate input
        if (empty($name) || empty($description) || $price <= 0 || empty($category)) {
            // In a real application, you would handle validation errors better
            $_SESSION['error'] = 'Please fill in all required fields';
            $this->redirect('/admin/products/create');
            return;
        }
        
        // In a real application, you would save to a database
        // For demo purposes, we'll use a session array
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = [];
        }
        
        // Generate a new ID
        $newId = 1;
        if (!empty($_SESSION['products'])) {
            $lastProduct = end($_SESSION['products']);
            $newId = $lastProduct['id'] + 1;
        }
        
        // Add the new product
        $_SESSION['products'][] = [
            'id' => $newId,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $category,
            'image' => $image
        ];
        
        $_SESSION['success'] = 'Product added successfully';
        $this->redirect('/admin/products');
    }
    
    public function edit($id) {
        // Find the product by ID
        $product = null;
        if (isset($_SESSION['products'])) {
            foreach ($_SESSION['products'] as $p) {
                if ($p['id'] == $id) {
                    $product = $p;
                    break;
                }
            }
        }
        
        if (!$product) {
            $_SESSION['error'] = 'Product not found';
            $this->redirect('/admin/products');
        }
        
        $this->views('admin/products/edit', [
            'title' => 'Edit Product - XING FU CHA',
            'product' => $product
        ]);
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/products');
        }
        
        // Find the product by ID
        $productIndex = -1;
        if (isset($_SESSION['products'])) {
            foreach ($_SESSION['products'] as $index => $p) {
                if ($p['id'] == $id) {
                    $productIndex = $index;
                    break;
                }
            }
        }
        
        if ($productIndex === -1) {
            $_SESSION['error'] = 'Product not found';
            $this->redirect('/admin/products');
        }
        
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $category = $_POST['category'] ?? '';
        
        // Keep the existing image by default
        $image = $_SESSION['products'][$productIndex]['image'];
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/products/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            // Check if it's a valid image
            $imageInfo = getimagesize($_FILES['image']['tmp_name']);
            if ($imageInfo !== false) {
                // Move the uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = '/assets/images/products/' . $fileName;
                }
            }
        }
        
        // Validate input
        if (empty($name) || empty($description) || $price <= 0 || empty($category)) {
            // In a real application, you would handle validation errors better
            $_SESSION['error'] = 'Please fill in all required fields';
            $this->redirect('/admin/products/edit/' . $id);
            return;
        }
        
        // Update the product
        $_SESSION['products'][$productIndex] = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $category,
            'image' => $image
        ];
        
        $_SESSION['success'] = 'Product updated successfully';
        $this->redirect('/admin/products');
    }
    
    public function delete($id) {
        // Find the product by ID
        $productIndex = -1;
        if (isset($_SESSION['products'])) {
            foreach ($_SESSION['products'] as $index => $p) {
                if ($p['id'] == $id) {
                    $productIndex = $index;
                    break;
                }
            }
        }
        
        if ($productIndex === -1) {
            $_SESSION['error'] = 'Product not found';
            $this->redirect('/admin/products');
        }
        
        // Remove the product
        array_splice($_SESSION['products'], $productIndex, 1);
        
        $_SESSION['success'] = 'Product deleted successfully';
        $this->redirect('/admin/products');
    }
}

