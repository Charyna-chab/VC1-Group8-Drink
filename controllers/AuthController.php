<?php
// In AuthController.php
class AuthController extends BaseController {

    public function __construct() {
        // Start the session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkRememberMe(); // Check for the remember me cookie
    }

    public function index() {
        $this->redirect('/login');
    }

    public function login() {
        // If the user is already logged in, redirect to the welcome page
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/welcome');
        }

        $error = null; // Initialize the error variable

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get email, password, and remember me status from the POST request
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            // Check user credentials (simple hardcoded check for demo purposes)
            if ($email === 'user@example.com' && $password === 'password123') {
                $_SESSION['user_id'] = 1;
                $_SESSION['user'] = [
                    'id' => 1,
                    'name' => 'Demo User',
                    'email' => $email,
                    'avatar' => '/assets/images/avatar.jpg'
                ];

                // If the user opted to be remembered, set a remember me cookie
                if ($remember) {
                    setcookie('remember_token', 'demo_token', time() + (86400 * 30), '/');
                }

                $this->redirect('/welcome'); // Redirect to the welcome page upon successful login
            } else {
                $error = 'Invalid email or password.'; // Set error message if login fails
            }
        }

        // Render the login view and pass the error message
        $this->views('auth/login', ['title' => 'Login - XING FU CHA', 'error' => $error]);
    }

    // Register method
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
                $_SESSION['register_success'] = true;
                $_SESSION['registered_name'] = $name;
                $_SESSION['registered_email'] = $email;
                $this->redirect('/order');
            }
        }

        // Render register view
        $this->views('auth/register', ['title' => 'Register - XING FU CHA', 'error' => $error]);
    }

    // Forgot password method
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

        // Render forgot password view
        $this->views('auth/forgot_password', ['title' => 'Forgot Password - XING FU CHA', 'error' => $error, 'message' => $message]);
    }

    // Logout method
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

    // Check authentication status (e.g., for protected pages)
    public function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}
?>

