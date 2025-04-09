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
        // Check if user is already logged in
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
                                
                                // Store token in database (in a real app)
                                // $stmt = $this->conn->prepare("UPDATE users SET remember_token = :token WHERE user_id = :user_id");
                                // $stmt->bindParam(':token', $token);
                                // $stmt->bindParam(':user_id', $user['user_id']);
                                // $stmt->execute();
                                
                                // Set cookie with token
                                setcookie('remember_token', $token, time() + (86400 * 30), '/', '', false, true);
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
        // Check if user is already logged in
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
        // Check if admin is already logged in
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
                            
                            // Store verification data in session
                            $_SESSION['admin_email'] = $email;
                            $_SESSION['admin_id'] = $admin['user_id'];
                            $_SESSION['admin_name'] = $admin['name'];
                            $_SESSION['verification_code'] = $verification_code;
                            $_SESSION['verification_time'] = time();
                            
                            // For development purposes, store the code in session
                            // This will allow login without email in case email sending fails
                            $_SESSION['demo_code'] = $verification_code;
                            
                            // Try to send verification code via email
                            $emailSent = $this->sendVerificationEmail($email, $verification_code, $admin['name']);
                            
                            // Log the attempt
                            error_log("Admin login attempt: Email sending " . ($emailSent ? "successful" : "failed"));
                            error_log("Verification code: " . $verification_code); // For debugging
                            
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
    
    private function sendVerificationEmail($email, $code, $name) {
        try {
            // Email subject
            $subject = 'XING FU CHA Admin Verification Code';
            
            // Email message
            $message = '
            <html>
            <head>
                <title>Admin Verification Code</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                    .header { text-align: center; padding: 20px 0; border-bottom: 1px solid #eee; }
                    .content { padding: 20px 0; }
                    .code { font-size: 32px; font-weight: bold; text-align: center; padding: 15px; background-color: #f5f5f5; border-radius: 5px; letter-spacing: 5px; margin: 20px 0; }
                    .footer { text-align: center; padding-top: 20px; font-size: 12px; color: #777; border-top: 1px solid #eee; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h2>XING FU CHA Admin Verification</h2>
                    </div>
                    <div class="content">
                        <p>Hello ' . htmlspecialchars($name) . ',</p>
                        <p>You are receiving this email because you attempted to log in to the XING FU CHA admin panel.</p>
                        <p>Please use the following verification code to complete your login:</p>
                        <div class="code">' . $code . '</div>
                        <p>This code will expire in 10 minutes.</p>
                        <p>If you did not attempt to log in, please ignore this email or contact support.</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date('Y') . ' XING FU CHA. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ';
            
            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: XING FU CHA <no-reply@xingfucha.com>" . "\r\n";
            
            // Try to send email
            $mailSent = mail($email, $subject, $message, $headers);
            
            // Log the attempt
            error_log("Email sending attempt to $email: " . ($mailSent ? "Success" : "Failed"));
            
            return $mailSent;
        } catch (\Exception $e) {
            error_log("Error sending email: " . $e->getMessage());
            return false;
        }
    }
    
    public function adminVerification() {
        // Check if admin email is set in session
        if (!isset($_SESSION['admin_email']) || !isset($_SESSION['verification_code'])) {
            $this->redirect('/admin-login');
        }
        
        $error = null;
        $demo_code = $_SESSION['demo_code'] ?? null; // For development purposes
        
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
            'demo_code' => $demo_code // For development purposes
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
        // Store temporary redirect URL if needed
        $redirect = isset($_SESSION['redirect_after_logout']) ? $_SESSION['redirect_after_logout'] : '/login';

        // Clear all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Clear authentication cookies
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/');
        }
        if (isset($_COOKIE['user_token'])) {
            setcookie('user_token', '', time() - 3600, '/');
        }

        // Clear admin-specific cookies
        if (isset($_COOKIE['admin_ID'])) {
            setcookie('admin_ID', '', time() - 3600, '/');
        }
        if (isset($_COOKIE['user_id'])) {
            setcookie('user_id', '', time() - 3600, '/');
        }

        // Destroy the session
        session_destroy();

        // Force browser to clear cache for this page
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Redirect to login page
        $this->redirect($redirect);
    }
}
