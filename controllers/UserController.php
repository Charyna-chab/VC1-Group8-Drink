<?php
namespace YourNamespace\Controllers;
use YourNamespace\Database\Database; 
use YourNamespace\BaseController;

class UserController extends BaseController {
    private $conn;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize database connection
        $database = new Database();
        $this->conn = $database->getConnection();
        
        // Check admin authentication for admin routes
        if (strpos($_SERVER['REQUEST_URI'], '/admin/') === 0) {
            $this->checkAdminAuth();
        }
    }
    
    private function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/admin-login');
        }
    }

    public function index() {
        try {
            // Fetch all users from the database (remove the role='user' filter)
            $stmt = $this->conn->prepare("SELECT * FROM users ORDER BY user_id DESC");
            $stmt->execute();
            $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $this->views('user/list', ['users' => $users, 'title' => 'User Management - XING FU CHA']);
        } catch (\PDOException $e) {
            $this->views('user/list', ['users' => [], 'error' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function create() {
        $this->views('user/create', ['title' => 'Create User - XING FU CHA']);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
            return;
        }
    
        // Initialize variables
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';
        $image = null;
    
        // Basic validation
        if (empty($name) || empty($email) || empty($password)) {
            $this->views('user/create', [
                'error' => 'Name, email and password are required fields',
                'title' => 'Create User - XING FU CHA'
            ]);
            return;
        }
    
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/user/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($fileExt, $allowedTypes)) {
                $this->views('user/create', [
                    'error' => 'Only JPG, PNG, and GIF images are allowed',
                    'title' => 'Create User - XING FU CHA'
                ]);
                return;
            }
    
            // Generate unique filename
            $fileName = uniqid() . '.' . $fileExt;
            $uploadFile = $uploadDir . $fileName;
    
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = $uploadFile;
            }
        }
    
        try {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Check if email already exists
            $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $this->views('user/create', [
                    'error' => 'Email already exists',
                    'title' => 'Create User - XING FU CHA'
                ]);
                return;
            }
    
            // Insert new user
            $stmt = $this->conn->prepare(
                "INSERT INTO users (name, email, phone, address, password, role, image) 
                 VALUES (:name, :email, :phone, :address, :password, :role, :image)"
            );
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':image', $image);
            
            if ($stmt->execute()) {
                $this->redirect('/admin/users');
            } else {
                $this->views('user/create', [
                    'error' => 'Failed to create user',
                    'title' => 'Create User - XING FU CHA'
                ]);
            }
        } catch (\PDOException $e) {
            $this->views('user/create', [
                'error' => 'Database error: ' . $e->getMessage(),
                'title' => 'Create User - XING FU CHA'
            ]);
        }
    }

    public function edit($id) {
        try {
            // Fetch user from database
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                $this->views('user/edit', ['user' => $user, 'title' => 'Edit User - XING FU CHA']);
            } else {
                $this->redirect('/admin/users');
            }
        } catch (\PDOException $e) {
            $this->views('user/edit', [
                'error' => 'Database error: ' . $e->getMessage(),
                'title' => 'Edit User - XING FU CHA'
            ]);
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
            return;
        }
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $role = $_POST['role'] ?? 'user';
        
        // Basic validation
        if (empty($name) || empty($email)) {
            $this->views('user/edit', [
                'error' => 'Name and email are required fields',
                'title' => 'Edit User - XING FU CHA',
                'user' => ['user_id' => $id]
            ]);
            return;
        }
        
        try {
            // Check if email already exists for another user
            $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = :email AND user_id != :id");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $this->views('user/edit', [
                    'error' => 'Email already exists for another user',
                    'title' => 'Edit User - XING FU CHA',
                    'user' => ['user_id' => $id]
                ]);
                return;
            }
            
            // Handle image upload if present
            $imageClause = '';
            $params = [
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':address' => $address,
                ':role' => $role,
                ':id' => $id
            ];
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/user/';
                
                // Create directory if it doesn't exist
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imageClause = ', image = :image';
                    $params[':image'] = $uploadFile;
                }
            }
            
            // Update user
            $stmt = $this->conn->prepare(
                "UPDATE users 
                 SET name = :name, email = :email, phone = :phone, address = :address, role = :role $imageClause
                 WHERE user_id = :id"
            );
            
            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $value);
            }
            
            if ($stmt->execute()) {
                $this->redirect('/user');
            } else {
                $this->views('user/edit', [
                    'error' => 'Failed to update user',
                    'title' => 'Edit User - XING FU CHA',
                    'user' => ['user_id' => $id]
                ]);
            }
        } catch (\PDOException $e) {
            $this->views('user/edit', [
                'error' => 'Database error: ' . $e->getMessage(),
                'title' => 'Edit User - XING FU CHA',
                'user' => ['user_id' => $id]
            ]);
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = :id");
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                $this->redirect('/admin/users');
            } else {
                $this->redirect('/admin/users?error=Failed to delete user');
            }
        } catch (\PDOException $e) {
            $this->redirect('/admin/users?error=Database error: ' . urlencode($e->getMessage()));
        }
    }
}
