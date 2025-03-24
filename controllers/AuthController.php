<?php
class AuthController extends BaseController {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkRememberMe();
    }

    public function index() {
        $this->redirect('/login');
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/order');
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            $isAdmin = isset($_POST['admin_login']);

            if ($isAdmin) {
                // Redirect to admin login page if user wants to login as admin
                $this->redirect('/admin-login');
                return;
            }

            // In a real application, you would validate against a database
            if ($email === 'user@example.com' && $password === 'password123') {
                $_SESSION['user_id'] = 1;
                $_SESSION['user'] = [
                    'id' => 1,
                    'name' => 'Demo User',
                    'email' => $email,
                    'avatar' => '/assets/images/avatar.jpg',
                    'role' => 'user'
                ];

                if ($remember) {
                    setcookie('remember_token', 'demo_token', time() + (86400 * 30), '/');
                }
                $this->redirect('/order');
            } else {
                $error = 'Invalid email or password.';
            }
        }

        $this->views('auth/login', ['title' => 'Login - XING FU CHA', 'error' => $error]);
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/order');
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $terms = isset($_POST['terms']);

            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = 'Please fill in all required fields';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long';
            } elseif (!$terms) {
                $error = 'You must agree to the Terms of Service.';
            } else {
                // In a real application, you would save the user to the database
                $_SESSION['user_id'] = 2; // New user ID
                $_SESSION['user'] = [
                    'id' => 2,
                    'name' => $name,
                    'email' => $email,
                    'avatar' => '/assets/images/avatar.jpg',
                    'role' => 'user'
                ];
                
                $this->redirect('/register-success');
            }
        }

        $this->views('auth/register', ['title' => 'Register - XING FU CHA', 'error' => $error]);
    }
    
    public function registerSuccess() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $this->views('auth/register_success', [
            'title' => 'Registration Successful - XING FU CHA',
            'user' => $_SESSION['user']
        ]);
    }

    public function forgotPassword() {
        $error = null;
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                $error = 'Please enter your email address';
            } else {
                // In a real application, you would send a password reset email
                $message = 'Password reset instructions have been sent to your email.';
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

            // In a real application, you would validate against a database
            if ($email === 'admin@example.com' && $password === 'admin123') {
                // Generate verification code
                $verification_code = rand(100000, 999999);
                
                // In a real application, you would send this code via email
                // For demo purposes, we'll store it in the session
                $_SESSION['admin_email'] = $email;
                $_SESSION['verification_code'] = $verification_code;
                $_SESSION['verification_time'] = time();
                
                // For demo purposes, display the code (in a real app, this would be sent via email)
                $_SESSION['demo_code'] = $verification_code;
                
                $this->redirect('/admin-verification');
            } else {
                $error = 'Invalid email or password.';
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
                $_SESSION['user_id'] = 999; // Admin ID
                $_SESSION['user'] = [
                    'id' => 999,
                    'name' => 'Admin User',
                    'email' => $_SESSION['admin_email'],
                    'avatar' => '/assets/images/admin-avatar.jpg',
                    'role' => 'admin'
                ];
                
                // Clear verification data
                unset($_SESSION['admin_email']);
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

        if (isset($_COOKIE['remember_token']) && $_COOKIE['remember_token'] === 'demo_token') {
            $_SESSION['user_id'] = 1;
            $_SESSION['user'] = [
                'id' => 1,
                'name' => 'Demo User',
                'email' => 'user@example.com',
                'avatar' => '/assets/images/avatar.jpg',
                'role' => 'user'
            ];
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

