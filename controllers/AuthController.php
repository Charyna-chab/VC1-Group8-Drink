<?php

class AuthController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function showLogin() {
        // Check if user is already logged in
        if (isset($_SESSION['user'])) {
            header('Location: /home');
            exit;
        }
        
        require 'views/auth/login.php';
    }
    
    public function login() {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            // Validate input
            if (empty($email) || empty($password)) {
                $error = 'Please enter both email and password';
                require 'views/auth/login.php';
                return;
            }
            
            // Check if user exists
            $user = $this->db->getUserByEmail($email);
            
            if (!$user || !password_verify($password, $user['password'])) {
                $error = 'Invalid email or password';
                require 'views/auth/login.php';
                return;
            }
            
            // Set session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'avatar' => $user['avatar'],
                'role' => $user['role']
            ];
            
            // Set remember me cookie if requested
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie('remember_token', $token, time() + 30 * 24 * 60 * 60, '/');
                // In a real app, you would store this token in the database
            }
            
            // Redirect to home page
            header('Location: /menu');
            exit;
        }
        
        // If not POST request, show login form
        $this->showLogin();
    }
    
    public function showRegister() {
        // Check if user is already logged in
        if (isset($_SESSION['user'])) {
            header('Location: /home');
            exit;
        }
        
        require 'views/auth/register.php';
    }
    
    public function register() {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $terms = isset($_POST['terms']);
            
            // Validate input
            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                $error = 'Please fill in all fields';
                require 'views/auth/register.php';
                return;
            }
            
            if ($password !== $confirmPassword) {
                $error = 'Passwords do not match';
                require 'views/auth/register.php';
                return;
            }
            
            if (!$terms) {
                $error = 'You must agree to the Terms of Service and Privacy Policy';
                require 'views/auth/register.php';
                return;
            }
            
            // Check if email already exists
            $existingUser = $this->db->getUserByEmail($email);
            if ($existingUser) {
                $error = 'Email already in use';
                require 'views/auth/register.php';
                return;
            }
            
            // Create user
            $userId = $this->db->addUser($name, $email, $password);
            
            // Get the newly created user
            $user = $this->db->getUserById($userId);
            
            // Set session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'avatar' => $user['avatar'],
                'role' => $user['role']
            ];
            
            // Redirect to home page
            header('Location: /menu');
            exit;
        }
        
        // If not POST request, show register form
        $this->showRegister();
    }
    
    public function logout() {
        // Destroy session
        session_unset();
        session_destroy();
        
        // Remove remember me cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // Redirect to splash screen
        header('Location: /splash');
        exit;
    }
    
    public function showForgotPassword() {
        require 'views/auth/forgot-password.php';
    }
    
    public function forgotPassword() {
        // This would be implemented in a real application
        // For demo purposes, we'll just show a message
        $message = 'If your email is registered, you will receive a password reset link.';
        require 'views/auth/forgot-password.php';
    }
    
    // API endpoints for AJAX requests
    public function apiLogin() {
        // Set content type to JSON
        header('Content-Type: application/json');
        
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        
        // Get JSON data
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        
        // Validate input
        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Please enter both email and password']);
            exit;
        }
        
        // Check if user exists
        $user = $this->db->getUserByEmail($email);
        
        if (!$user || !password_verify($password, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
            exit;
        }
        
        // Set session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => $user['avatar'],
            'role' => $user['role']
        ];
        
        // Return success
        echo json_encode(['success' => true, 'redirect' => '/home']);
        exit;
    }
    
    public function apiRegister() {
        // Set content type to JSON
        header('Content-Type: application/json');
        
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        
        // Get JSON data
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? '';
        $terms = $data['terms'] ?? false;
        
        // Validate input
        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            echo json_encode(['success' => false, 'message' => 'Please fill in all fields']);
            exit;
        }
        
        if ($password !== $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            exit;
        }
        
        if (!$terms) {
            echo json_encode(['success' => false, 'message' => 'You must agree to the Terms of Service and Privacy Policy']);
            exit;
        }
        
        // Check if email already exists
        $existingUser = $this->db->getUserByEmail($email);
        if ($existingUser) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            exit;
        }
        
        // Create user
        $userId = $this->db->addUser($name, $email, $password);
        
        // Get the newly created user
        $user = $this->db->getUserById($userId);
        
        // Set session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => $user['avatar'],
            'role' => $user['role']
        ];
        
        // Return success
        echo json_encode(['success' => true, 'redirect' => '/home']);
        exit;
    }
}
?>