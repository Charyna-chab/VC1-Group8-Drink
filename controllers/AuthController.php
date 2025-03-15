<?php
class AuthController extends BaseController {
    public function login() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: /order');
            exit;
        }
        
        $error = null;
        
        // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            // Validate inputs
            if (empty($email) || empty($password)) {
                $error = 'Please enter both email and password';
            } else {
                // In a real application, you would validate against database
                // For demo purposes, we'll use a hardcoded user
                if ($email === 'user@example.com' && $password === 'password123') {
                    // Set session variables
                    $_SESSION['user_id'] = 1;
                    $_SESSION['user'] = [
                        'id' => 1,
                        'name' => 'Demo User',
                        'email' => $email,
                        'avatar' => '/assets/images/avatar.jpg'
                    ];
                    
                    // Set remember me cookie if checked
                    if ($remember) {
                        setcookie('remember_token', 'demo_token', time() + (86400 * 30), '/'); // 30 days
                    }
                    
                    // Redirect to order page
                    header('Location: /order');
                    exit;
                } else {
                    $error = 'Invalid email or password';
                }
            }
        }
        
        $this->view('login', [
            'title' => 'Login - XING FU CHA',
            'error' => $error
        ]);
    }
    
    public function register() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: /order');
            exit;
        }
        
        $error = null;
        
        // Handle register form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $terms = isset($_POST['terms']);
            
            // Validate inputs
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = 'Please fill in all required fields';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long';
            } elseif (!$terms) {
                $error = 'You must agree to the Terms of Service and Privacy Policy';
            } else {
                // In a real application, you would save to database
                // For demo purposes, we'll just redirect to success page
                
                // Set session variables for auto-login after registration
                $_SESSION['user_id'] = 2; // New user ID
                $_SESSION['user'] = [
                    'id' => 2,
                    'name' => $name,
                    'email' => $email,
                    'avatar' => '/assets/images/default-avatar.jpg'
                ];
                
                // Redirect to registration success page
                header('Location: /register-success');
                exit;
            }
        }
        
        $this->view('register', [
            'title' => 'Register - XING FU CHA',
            'error' => $error
        ]);
    }
    
    public function registerSuccess() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $this->view('register_success', [
            'title' => 'Registration Successful - XING FU CHA'
        ]);
    }
    
    public function forgotPassword() {
        $error = null;
        $message = null;
        
        // Handle forgot password form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            // Validate email
            if (empty($email)) {
                $error = 'Please enter your email address';
            } else {
                // In a real application, you would send a password reset email
                // For demo purposes, we'll just show a success message
                $message = 'Password reset instructions have been sent to your email';
            }
        }
        
        $this->view('forgot_password', [
            'title' => 'Forgot Password - XING FU CHA',
            'error' => $error,
            'message' => $message
        ]);
    }
    
    public function logout() {
        // Clear session
        session_unset();
        session_destroy();
        
        // Clear remember me cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // Redirect to login page
        header('Location: /login');
        exit;
    }
    
    public function checkAuth() {
        // Check if user is logged in via session
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        
        // Check if user has remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            // In a real application, you would validate the token against database
            // For demo purposes, we'll just set session variables
            if ($_COOKIE['remember_token'] === 'demo_token') {
                $_SESSION['user_id'] = 1;
                $_SESSION['user'] = [
                    'id' => 1,
                    'name' => 'Demo User',
                    'email' => 'user@example.com',
                    'avatar' => '/assets/images/avatar.jpg'
                ];
                return true;
            }
        }
        
        return false;
    }
}