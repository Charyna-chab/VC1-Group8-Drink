<?php
namespace YourNamespace\Controllers;
use YourNamespace\BaseController;
require_once 'Database/database.php';

class AuthController extends BaseController {
    private $conn;
    
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize database connection
        $database = new \Database();
        $this->conn = $database->getConnection();
        
        $this->checkRememberMe();
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
                        // Set session variables
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
                            // Create a secure remember me token (in a real app, use a more secure method)
                            $token = bin2hex(random_bytes(32));
                            setcookie('remember_token', $token, time() + (86400 * 30), '/');
                            
                            // Store token in database (in a real app)
                            // $stmt = $this->conn->prepare("UPDATE users SET remember_token = :token WHERE user_id = :user_id");
                            // $stmt->bindParam(':token', $token);
                            // $stmt->bindParam(':user_id', $user['user_id']);
                            // $stmt->execute();
                        }
                        
                        // Redirect based on role
                        if ($user['role'] === 'admin') {
                            $this->redirect('/admin-dashboard');
                        } else {
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
    
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $response = ['success' => false, 'message' => 'An error occurred'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? $_SESSION['user']['name'];
            $email = $_POST['email'] ?? $_SESSION['user']['email'];
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            
            try {
                // Update user in database
                $stmt = $this->conn->prepare(
                    "UPDATE users 
                     SET name = :name, email = :email, phone = :phone, address = :address 
                     WHERE user_id = :user_id"
                );
                
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    // Update session data
                    $_SESSION['user']['name'] = $name;
                    $_SESSION['user']['email'] = $email;
                    $_SESSION['user']['phone'] = $phone;
                    $_SESSION['user']['address'] = $address;
                    
                    $response = [
                        'success' => true, 
                        'message' => 'Profile updated successfully',
                        'user' => [
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'address' => $address
                        ]
                    ];
                } else {
                    $response = ['success' => false, 'message' => 'Failed to update profile'];
                }
            } catch (\PDOException $e) {
                $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
            }
        }
        
        echo json_encode($response);
        exit;
    }
    
    public function updatePassword() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $response = ['success' => false, 'message' => 'An error occurred'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $response = ['success' => false, 'message' => 'All fields are required'];
            } elseif ($newPassword !== $confirmPassword) {
                $response = ['success' => false, 'message' => 'New passwords do not match'];
            } elseif (strlen($newPassword) < 8) {
                $response = ['success' => false, 'message' => 'Password must be at least 8 characters long'];
            } else {
                try {
                    // Verify current password
                    $stmt = $this->conn->prepare("SELECT password FROM users WHERE user_id = :user_id");
                    $stmt->bindParam(':user_id', $_SESSION['user_id']);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                        
                        // In a real app, use password_verify
                        if ($currentPassword === $user['password']) {
                            // Update password
                            // In a real app, hash the new password: $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            
                            $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
                            $stmt->bindParam(':password', $newPassword); // In a real app, use $hashedPassword
                            $stmt->bindParam(':user_id', $_SESSION['user_id']);
                            
                            if ($stmt->execute()) {
                                $response = ['success' => true, 'message' => 'Password updated successfully'];
                            } else {
                                $response = ['success' => false, 'message' => 'Failed to update password'];
                            }
                        } else {
                            $response = ['success' => false, 'message' => 'Current password is incorrect'];
                        }
                    } else {
                        $response = ['success' => false, 'message' => 'User not found'];
                    }
                } catch (\PDOException $e) {
                    $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
                }
            }
        }
        
        echo json_encode($response);
        exit;
    }
    
    public function forgotPassword() {
        $error = null;
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                $error = 'Please enter your email address';
            } else {
                try {
                    // Check if email exists
                    $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        // In a real application, you would:
                        // 1. Generate a reset token
                        // 2. Store it in the database with an expiration time
                        // 3. Send an email with a reset link
                        
                        $message = 'Password reset instructions have been sent to your email.';
                    } else {
                        $error = 'Email not found in our records.';
                    }
                } catch (\PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            }
        }

        $this->views('auth/forgot_password', ['title' => 'Forgot Password - XING FU CHA', 'error' => $error, 'message' => $message]);
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

    public function adminLogin() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
            $this->redirect('/admin-dashboard');
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                // Check if admin exists
                $stmt = $this->conn->prepare("SELECT user_id, name, email, password FROM users WHERE email = :email AND role = 'admin'");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
                    
                    // Verify password (in a real app, use password_verify)
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
                        
                        $this->redirect('/admin-verification');
                    } else {
                        $error = 'Invalid password.';
                    }
                } else {
                    $error = 'Invalid admin credentials.';
                }
            } catch (\PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
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
            // For now, we'll just set a demo user
            try {
                // This is a placeholder. In a real app, you would query the database for the token
                // $stmt = $this->conn->prepare("SELECT user_id, name, email, role FROM users WHERE remember_token = :token");
                // $stmt->bindParam(':token', $_COOKIE['remember_token']);
                // $stmt->execute();
                
                // if ($stmt->rowCount() > 0) {
                //     $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                //     $_SESSION['user_id'] = $user['user_id'];
                //     $_SESSION['user'] = [
                //         'id' => $user['user_id'],
                //         'name' => $user['name'],
                //         'email' => $user['email'],
                //         'role' => $user['role']
                //     ];
                // }
                
                // For demo purposes:
                $_SESSION['user_id'] = 1;
                $_SESSION['user'] = [
                    'id' => 1,
                    'name' => 'Demo User',
                    'email' => 'user@example.com',
                    'avatar' => '/assets/image/placeholder.svg?height=40&width=40',
                    'role' => 'user'
                ];
            } catch (\PDOException $e) {
                // Log error
            }
        }
    }

    public function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    
    public function checkAdminAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/admin-login');
        }
    }
}