<?php
class AuthController {
    private $userModel;
    private $auth;
    
    public function __construct() {
        $this->userModel = new UserModel();
        $this->auth = new Auth();
    }
    
    /**
     * Login page
     */
    public function login() {
        $error = '';
        
        // Process login form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid form submission. Please try again.';
            } else {
                // Get form data
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'] ?? '';
                $remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] === 'on';
                
                // Validate form data
                if (empty($email) || empty($password)) {
                    $error = 'Please enter both email and password.';
                } else {
                    try {
                        // Attempt to login
                        $this->auth->login($email, $password);
                        
                        // Set remember me cookie if requested
                        if ($remember_me) {
                            $token = generate_token();
                            $expiry = time() + (REMEMBER_ME_DAYS * 24 * 60 * 60);
                            setcookie('remember_token', $token, $expiry, '/', '', true, true);
                        }
                        
                        // Generate and send 2FA code
                        $otp = $this->auth->generate2FACode($_SESSION['user_id']);
                        
                        // Redirect to 2FA verification page
                        redirect('/verify-2fa');
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                    }
                }
            }
        }
        
        // Generate CSRF token
        $csrf_token = generate_csrf_token();
        
        // Include login view
        include 'views/adminlogin.php';
    }
    
    /**
     * Logout
     */
    public function logout() {
        $this->auth->logout();
        redirect('/login');
    }
    
    /**
     * 2FA verification page
     */
    public function verify2fa() {
        $error = '';
        $user_id = $_SESSION['user_id'];
        
        // Process 2FA form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid form submission. Please try again.';
            } else {
                // Get form data
                $code = $_POST['code'] ?? '';
                
                // Validate form data
                if (empty($code)) {
                    $error = 'Please enter the verification code.';
                } else {
                    try {
                        // Verify 2FA code
                        $this->auth->verify2FA($user_id, $code);
                        
                        // Log successful 2FA verification
                        log_action('2fa_verification', $user_id, 'success');
                        
                        // Redirect to dashboard
                        redirect('/admin/dashboard');
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                        
                        // Log failed 2FA verification
                        log_action('2fa_verification', $user_id, 'failed', $e->getMessage());
                    }
                }
            }
        }
        
        // For demonstration purposes, show the OTP
        $demo_otp = $_SESSION['demo_otp'] ?? '';
        
        // Calculate time left
        $time_left = 0;
        if (isset($_SESSION['2fa_code'])) {
            $time_left = max(0, $_SESSION['2fa_code']['expires'] - time());
        }
        
        // Generate CSRF token
        $csrf_token = generate_csrf_token();
        
        // Include 2FA verification view
        include 'views/verify_2fa.php';
    }
    
    /**
     * Forgot password page
     */
    public function forgotPassword() {
        $error = '';
        $success = false;
        
        // Process forgot password form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid form submission. Please try again.';
            } else {
                // Get form data
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                
                // Validate form data
                if (empty($email)) {
                    $error = 'Please enter your email address.';
                } else {
                    try {
                        // Send password reset email
                        $this->auth->sendPasswordResetEmail($email);
                        $success = true;
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                    }
                }
            }
        }
        
        // Generate CSRF token
        $csrf_token = generate_csrf_token();
        
        // Include forgot password view
        include 'views/forgot_password.php';
    }
    
    /**
     * Reset password page
     */
    public function resetPassword() {
        $error = '';
        $success = false;
        
        // Get token from query string
        $token = $_GET['token'] ?? '';
        
        // Process reset password form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid form submission. Please try again.';
            } else {
                // Get form data
                $password = $_POST['password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';
                $token = $_POST['token'] ?? $token;
                
                // Validate form data
                if (empty($password) || empty($confirm_password)) {
                    $error = 'Please enter both password and confirm password.';
                } elseif ($password !== $confirm_password) {
                    $error = 'Passwords do not match.';
                } else {
                    try {
                        // Reset password
                        $this->auth->resetPassword($token, $password);
                        $success = true;
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                    }
                }
            }
        }
        
        // Generate CSRF token
        $csrf_token = generate_csrf_token();
        
        // Include reset password view
        include 'views/reset_password.php';
    }
}

