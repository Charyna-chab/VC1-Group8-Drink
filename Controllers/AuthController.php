<?php
namespace YourNamespace\Controllers;
use YourNamespace\BaseController;
require_once 'Database/database.php';
use YourNamespace\Database\Database;  

class AuthController extends BaseController {
    private $conn;
    private $admin_email = "charyna.chab@student.passerellesnumeriques.org";
    private $admin_password = "ryna!@#1649";
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize database connection
        $database = new Database();
        $this->conn = $database->getConnection();
        
        $this->checkRememberMe();
        $this->ensureAdminExists();
    }

    // Make sure our admin account exists in the database
    private function ensureAdminExists() {
        try {
            // Check if admin exists
            $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->bindParam(':email', $this->admin_email);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                // Admin doesn't exist, create it
                $stmt = $this->conn->prepare(
                    "INSERT INTO users (name, email, phone, address, password, role) 
                     VALUES ('Admin User', :email, '0123456789', 'Admin Address', :password, 'admin')"
                );
                $stmt->bindParam(':email', $this->admin_email);
                $stmt->bindParam(':password', $this->admin_password);
                $stmt->execute();
            } else {
                // Admin exists, make sure role is set to admin
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                $stmt = $this->conn->prepare("UPDATE users SET role = 'admin', password = :password WHERE user_id = :user_id");
                $stmt->bindParam(':password', $this->admin_password);
                $stmt->bindParam(':user_id', $user['user_id']);
                $stmt->execute();
            }
        } catch (\PDOException $e) {
            // Silently fail - we'll try again next time
        }
    }

    public function index() {
        $this->redirect('/login');
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            // If user is already logged in, redirect based on role
            if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
                $this->redirect('/admin-dashboard');
            } else {
                $this->redirect('/order');
            }
        }

        $error = null;
        $success = null;
        
        // Check if redirected from registration
        if (isset($_SESSION['registration_success'])) {
            $success = "Registration successful! Please login with your new account.";
            unset($_SESSION['registration_success']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            // Validate user credentials against database
            try {
                $stmt = $this->conn->prepare("SELECT user_id, name, email, password, role, phone, address, image FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                    
                    // Verify password (in a real app, use password_verify with hashed passwords)
                    if ($password === $user['password']) {
                        // Check if this is an admin trying to login through user login
                        if ($user['role'] === 'admin') {
                            $error = 'Admin users must login through the admin login page.';
                        } else {
                            // Set session variables for regular user
                            $_SESSION['user_id'] = $user['user_id'];
                            $_SESSION['user'] = [
                                'id' => $user['user_id'],
                                'name' => $user['name'],
                                'email' => $user['email'],
                                'avatar' => $user['image'] ? 'data:image/jpeg;base64,' . base64_encode($user['image']) : '/assets/image/placeholder.svg?height=40&width=40',
                                'role' => $user['role'],
                                'phone' => $user['phone'] ?? '',
                                'address' => $user['address'] ?? ''
                            ];
                            
                            if ($remember) {
                                // Create a secure remember me token
                                $token = bin2hex(random_bytes(32));
                                setcookie('remember_token', $token, time() + (86400 * 30), '/');
                            }
                            
                            // Redirect to order page
                            $this->redirect('/order');
                        }
                    } else {
                        $error = 'Invalid password.';
                    }
                } else {
                    $error = 'Email not found.';
                }
            } catch (\PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }

        $this->views('auth/login', [
            'title' => 'Login - XING FU CHA', 
            'error' => $error,
            'success' => $success
        ]);
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            // If user is already logged in, redirect based on role
            if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
                $this->redirect('/admin-dashboard');
            } else {
                $this->redirect('/order');
            }
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $terms = isset($_POST['terms']);
            
            // Basic validation
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = 'Please fill in all required fields';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long';
            } elseif (!$terms) {
                $error = 'You must agree to the Terms of Service.';
            } else {
                try {
                    // Check if email already exists
                    $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        $error = 'Email already registered. Please use a different email.';
                    } else {
                        // In a real application, you would hash the password
                        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        
                        // Insert new user
                        $stmt = $this->conn->prepare(
                            "INSERT INTO users (name, email, phone, address, password, role) 
                             VALUES (:name, :email, :phone, :address, :password, 'user')"
                        );
                        
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':phone', $phone);
                        $stmt->bindParam(':address', $address);
                        $stmt->bindParam(':password', $password); // In a real app, use $hashedPassword
                        
                        if ($stmt->execute()) {
                            // Set a flag to show success message on login page
                            $_SESSION['registration_success'] = true;
                            
                            // Redirect to login page
                            $this->redirect('/login');
                        } else {
                            $error = 'Registration failed. Please try again.';
                        }
                    }
                } catch (\PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            }
        }

        $this->views('auth/register', ['title' => 'Register - XING FU CHA', 'error' => $error]);
    }
    
    public function adminLogin() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
            $this->redirect('/admin-dashboard');
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Check if this is our designated admin email
            if ($email === $this->admin_email) {
                try {
                    // Check if admin exists in database
                    $stmt = $this->conn->prepare("SELECT user_id, name, email, password FROM users WHERE email = :email AND role = 'admin'");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
                        
                        // Verify password
                        if ($password === $admin['password']) {
                            // Generate verification code
                            $verification_code = rand(100000, 999999);
                            
                            // In a real application, you would send this code via email
                            // For demo purposes, we'll store it in the session
                            $_SESSION['admin_email'] = $email;
                            $_SESSION['admin_id'] = $admin['user_id'];
                            $_SESSION['admin_name'] = $admin['name'];
                            $_SESSION['verification_code'] = $verification_code;
                            $_SESSION['verification_time'] = time();
                            
                            // For demo purposes, display the code (in a real app, this would be sent via email)
                            $_SESSION['demo_code'] = $verification_code;
                            
                            // In a real application, you would send an email with the verification code
                            // sendVerificationEmail($email, $verification_code);
                            
                            $this->redirect('/admin-verification');
                        } else {
                            $error = 'Invalid password.';
                        }
                    } else {
                        // Admin doesn't exist in database yet, create it
                        $this->ensureAdminExists();
                        $error = 'Please try logging in again.';
                    }
                } catch (\PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            } else {
                $error = 'Invalid admin credentials.';
            }
        }

        $this->views('auth/admin_login', ['title' => 'Admin Login - XING FU CHA', 'error' => $error]);
    }
    
    public function adminVerification() {
        // Check if admin email is set in session
        if (!isset($_SESSION['admin_email']) || !isset($_SESSION['verification_code'])) {
            $this->redirect('/admin-login');
        }
        
        $error = null;
        $demo_code = $_SESSION['demo_code'] ?? null; // For demo purposes only
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verification_code = $_POST['verification_code'] ?? '';
            
            // Check if verification code is correct and not expired (10 minutes)
            if ($verification_code == $_SESSION['verification_code'] && 
                (time() - $_SESSION['verification_time']) < 600) {
                
                // Set admin session
                $_SESSION['user_id'] = $_SESSION['admin_id'];
                $_SESSION['user'] = [
                    'id' => $_SESSION['admin_id'],
                    'name' => $_SESSION['admin_name'],
                    'email' => $_SESSION['admin_email'],
                    'avatar' => '/assets/image/placeholder.svg?height=40&width=40',
                    'role' => 'admin'
                ];
                
                // Clear verification data
                unset($_SESSION['admin_email']);
                unset($_SESSION['admin_id']);
                unset($_SESSION['admin_name']);
                unset($_SESSION['verification_code']);
                unset($_SESSION['verification_time']);
                unset($_SESSION['demo_code']);
                
                // Redirect to admin dashboard
                $this->redirect('/admin-dashboard');
            } else {
                if ((time() - $_SESSION['verification_time']) >= 600) {
                    $error = 'Verification code has expired. Please try again.';
                    // Clear verification data
                    unset($_SESSION['admin_email']);
                    unset($_SESSION['admin_id']);
                    unset($_SESSION['admin_name']);
                    unset($_SESSION['verification_code']);
                    unset($_SESSION['verification_time']);
                    unset($_SESSION['demo_code']);
                    
                    // Redirect back to admin login
                    $this->redirect('/admin-login');
                } else {
                    $error = 'Invalid verification code. Please try again.';
                }
            }
        }
        
        $this->views('auth/admin_verification', [
            'title' => 'Admin Verification - XING FU CHA', 
            'error' => $error,
            'demo_code' => $demo_code // For demo purposes only
        ]);
    }

    private function checkRememberMe() {
        if (isset($_SESSION['user_id'])) {
            return;
        }

        if (isset($_COOKIE['remember_token'])) {
            // In a real application, you would verify the token against the database
            try {
                // This is a placeholder. In a real app, you would query the database for the token
                $stmt = $this->conn->prepare("SELECT user_id, name, email, role, phone, address, image FROM users WHERE remember_token = :token");
                $stmt->bindParam(':token', $_COOKIE['remember_token']);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user'] = [
                        'id' => $user['user_id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'avatar' => $user['image'] ? 'data:image/jpeg;base64,' . base64_encode($user['image']) : '/assets/image/placeholder.svg?height=40&width=40',
                        'role' => $user['role'],
                        'phone' => $user['phone'] ?? '',
                        'address' => $user['address'] ?? ''
                    ];
                }
            } catch (\PDOException $e) {
                // Log error
            }
        }
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = array();
        
        // Destroy the session
        session_destroy();

        // Delete the remember me cookie if it exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

        // Redirect to login page
        $this->redirect('/login');
    }
}