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

            if ($email === 'user@example.com' && $password === 'password123') {
                $_SESSION['user_id'] = 1;
                $_SESSION['user'] = [
                    'id' => 1,
                    'name' => 'Demo User',
                    'email' => $email,
                    'avatar' => '/assets/images/avatar.jpg'
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
                $_SESSION['user_id'] = 2; // New user ID
                $_SESSION['user'] = [
                    'id' => 2,
                    'name' => $name,
                    'email' => $email,
                    'avatar' => '/assets/images/avatar.jpg'
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
                $message = 'Password reset instructions have been sent.';
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
                'avatar' => '/assets/images/avatar.jpg'
            ];
        }
    }

    public function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    // AuthController.php

    public function adminLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Display the admin login form
            return view('admin_login');
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the admin login form submission
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Verify the admin credentials
            if ($this->verifyAdminCredentials($email, $password)) {
                // Login the admin
                return redirect('/admin-dashboard');
            } else {
                // Display an error message
                return view('admin_login', ['error' => 'Invalid email or password']);
            }
        }
    }
    

}

