<?php
require_once __DIR__ . '/BaseController.php';

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
            $this->redirect('/welcome');
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
                $this->redirect('/welcome');
            } else {
                $error = 'Invalid email or password.';
            }
        }

        $this->views('auth/login', ['title' => 'Login - XING FU CHA', 'error' => $error]);
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/welcome');
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
                // Store user data in session
                $_SESSION['user_id'] = time(); // Using timestamp as a simple ID
                $_SESSION['user'] = [
                    'id' => $_SESSION['user_id'],
                    'name' => $name,
                    'email' => $email,
                    'avatar' => '/assets/images/default-avatar.jpg'
                ];
                
                $_SESSION['register_success'] = true;
                $_SESSION['registered_name'] = $name;
                $_SESSION['registered_email'] = $email;
                
                // Redirect to registration success page
                $this->redirect('/register-success');
            }
        }

        $this->views('auth/register', ['title' => 'Register - XING FU CHA', 'error' => $error]);
    }

    public function registerSuccess() {
        if (!isset($_SESSION['register_success'])) {
            $this->redirect('/register');
        }
        
        $user = [
            'name' => $_SESSION['registered_name'] ?? 'User'
        ];
        
        // Clear the registration success flag but keep the user logged in
        unset($_SESSION['register_success']);
        unset($_SESSION['registered_name']);
        unset($_SESSION['registered_email']);
        
        $this->views('auth/register_success', ['title' => 'Registration Successful - XING FU CHA', 'user' => $user]);
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
        session_unset();
        session_destroy();

        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

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
}

