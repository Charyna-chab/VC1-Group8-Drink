<?php
namespace YourNamespace\Controllers;
use YourNamespace\BaseController;

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
            $isAdmin = isset($_POST['admin_login']);

            if ($isAdmin) {
                // Redirect to admin login page if user wants to login as admin
                $this->redirect('/admin-login');
                return;
            }

            // In a real application, you would validate against a database
            // For now, check if it's the demo user or a registered user
            if (($email === 'user@example.com' && $password === 'password123') || 
                (isset($_SESSION['registered_users']) && $this->validateUser($email, $password))) {
                
                // If it's a registered user, get their data
                if (isset($_SESSION['registered_users']) && $this->validateUser($email, $password)) {
                    $userData = $_SESSION['registered_users'][$email];
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['user'] = [
                        'id' => $userData['id'],
                        'name' => $userData['name'],
                        'email' => $email,
                        'avatar' => $userData['avatar'] ?? '/assets/images/avatar.jpg',
                        'role' => 'user',
                        'phone' => $userData['phone'] ?? '',
                        'birthday' => $userData['birthday'] ?? ''
                    ];
                } else {
                    // Demo user
                    $_SESSION['user_id'] = 1;
                    $_SESSION['user'] = [
                        'id' => 1,
                        'name' => 'Demo User',
                        'email' => $email,
                        'avatar' => '/assets/images/avatar.jpg',
                        'role' => 'user',
                        'phone' => '',
                        'birthday' => ''
                    ];
                }

                if ($remember) {
                    setcookie('remember_token', 'demo_token', time() + (86400 * 30), '/');
                }
                
                // Redirect to order page for regular users
                $this->redirect('/order');
            } else {
                $error = 'Invalid email or password.';
            }
        }

        $this->views('auth/login', [
            'title' => 'Login - XING FU CHA', 
            'error' => $error,
            'success' => $success
        ]);
    }

    private function validateUser($email, $password) {
        if (!isset($_SESSION['registered_users']) || !isset($_SESSION['registered_users'][$email])) {
            return false;
        }
        
        $userData = $_SESSION['registered_users'][$email];
        // In a real app, you would use password_verify() to check hashed passwords
        return $userData['password'] === $password;
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
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $terms = isset($_POST['terms']);
            
            // Handle profile image upload
            $avatar = '/assets/images/default-avatar.jpg'; // Default avatar
            
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/';
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['profile_image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                // Check if it's a valid image
                $imageInfo = getimagesize($_FILES['profile_image']['tmp_name']);
                if ($imageInfo !== false) {
                    // Move the uploaded file
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                        $avatar = '/assets/images/uploads/' . $fileName;
                    } else {
                        $error = 'Failed to upload profile image. Please try again.';
                    }
                } else {
                    $error = 'The uploaded file is not a valid image.';
                }
            }

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
                // For now, we'll store the registration data in the session
                
                // Initialize registered_users array if it doesn't exist
                if (!isset($_SESSION['registered_users'])) {
                    $_SESSION['registered_users'] = [];
                }
                
                // Check if email already exists
                if (isset($_SESSION['registered_users'][$email])) {
                    $error = 'Email already registered. Please use a different email.';
                } else {
                    // Generate a unique ID for the user
                    $userId = count($_SESSION['registered_users']) + 2; // Start from 2 since demo user is 1
                    
                    // Store user data
                    $_SESSION['registered_users'][$email] = [
                        'id' => $userId,
                        'name' => $name,
                        'email' => $email,
                        'password' => $password, // In a real app, this would be hashed
                        'avatar' => $avatar,
                        'role' => 'user',
                        'phone' => '',
                        'birthday' => ''
                    ];
                    
                    // Set a flag to show success message on login page
                    $_SESSION['registration_success'] = true;
                    
                    // Redirect to login page
                    $this->redirect('/login');
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
            $birthday = $_POST['birthday'] ?? '';
            
            // Handle profile image upload
            $avatar = $_SESSION['user']['avatar']; // Keep existing avatar by default
            
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/uploads/';
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = uniqid() . '_' . basename($_FILES['profile_image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                // Check if it's a valid image
                $imageInfo = getimagesize($_FILES['profile_image']['tmp_name']);
                if ($imageInfo !== false) {
                    // Move the uploaded file
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                        $avatar = '/assets/images/uploads/' . $fileName;
                    } else {
                        $response = ['success' => false, 'message' => 'Failed to upload profile image'];
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = ['success' => false, 'message' => 'The uploaded file is not a valid image'];
                    echo json_encode($response);
                    exit;
                }
            }
            
            // Update user data in session
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['birthday'] = $birthday;
            $_SESSION['user']['avatar'] = $avatar;
            
            // In a real application, you would update the database here
            // For now, update the registered_users array if the user exists there
            if (isset($_SESSION['registered_users']) && isset($_SESSION['registered_users'][$_SESSION['user']['email']])) {
                $oldEmail = $_SESSION['user']['email'];
                
                // If email changed, update the key in the array
                if ($email !== $oldEmail) {
                    $userData = $_SESSION['registered_users'][$oldEmail];
                    unset($_SESSION['registered_users'][$oldEmail]);
                    $_SESSION['registered_users'][$email] = $userData;
                }
                
                // Update user data
                $_SESSION['registered_users'][$email]['name'] = $name;
                $_SESSION['registered_users'][$email]['phone'] = $phone;
                $_SESSION['registered_users'][$email]['birthday'] = $birthday;
                $_SESSION['registered_users'][$email]['avatar'] = $avatar;
            }
            
            $response = [
                'success' => true, 
                'message' => 'Profile updated successfully',
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'birthday' => $birthday,
                    'avatar' => $avatar
                ]
            ];
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
            
            // In a real application, you would verify the current password against the database
            // For demo purposes, we'll use a hardcoded password or check against registered_users
            $validCurrentPassword = false;
            
            if ($_SESSION['user']['email'] === 'user@example.com' && $currentPassword === 'password123') {
                $validCurrentPassword = true;
            } elseif (isset($_SESSION['registered_users']) && isset($_SESSION['registered_users'][$_SESSION['user']['email']])) {
                $userData = $_SESSION['registered_users'][$_SESSION['user']['email']];
                if ($userData['password'] === $currentPassword) {
                    $validCurrentPassword = true;
                }
            }
            
            if (!$validCurrentPassword) {
                $response = ['success' => false, 'message' => 'Current password is incorrect'];
            } elseif (empty($newPassword)) {
                $response = ['success' => false, 'message' => 'New password cannot be empty'];
            } elseif ($newPassword !== $confirmPassword) {
                $response = ['success' => false, 'message' => 'New passwords do not match'];
            } elseif (strlen($newPassword) < 8) {
                $response = ['success' => false, 'message' => 'Password must be at least 8 characters long'];
            } else {
                // In a real application, you would update the password in the database
                // For now, update the registered_users array if the user exists there
                if (isset($_SESSION['registered_users']) && isset($_SESSION['registered_users'][$_SESSION['user']['email']])) {
                    $_SESSION['registered_users'][$_SESSION['user']['email']]['password'] = $newPassword;
                }
                
                $response = ['success' => true, 'message' => 'Password updated successfully'];
            }
        }
        
        echo json_encode($response);
        exit;
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

            // Use the specific admin credentials provided by the user
            if ($email === 'vandaleng@student.passerellesnumeriques.org' && $password === 'vanda,123') {
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
                    'role' => 'admin',
                    'phone' => '',
                    'birthday' => ''
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
                'role' => 'user',
                'phone' => '',
                'birthday' => ''
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