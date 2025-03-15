<?php
class UserModel {
    private $db;
    
    public function __construct() {
        // In a real application, you would establish a database connection here
        // For demonstration purposes, we'll use a mock database
        $this->db = null;
    }
    
    /**
     * Get user by email
     */
    public function getUserByEmail($email) {
        // In a real application, you would query the database
        // For demonstration purposes, we'll return a mock user
        
        if ($email === 'admin@example.com') {
            return [
                'id' => 1,
                'email' => 'admin@example.com',
                'password' => hash_password('password'), // In a real app, this would be stored in the DB
                'name' => 'Admin User',
                'role' => 'admin',
                'created_at' => '2023-01-01 00:00:00',
                'updated_at' => '2023-01-01 00:00:00'
            ];
        }
        
        return null;
    }
    
    /**
     * Get user by ID
     */
    public function getUserById($id) {
        // In a real application, you would query the database
        // For demonstration purposes, we'll return a mock user
        
        if ($id === 1) {
            return [
                'id' => 1,
                'email' => 'admin@example.com',
                'password' => hash_password('password'), // In a real app, this would be stored in the DB
                'name' => 'Admin User',
                'role' => 'admin',
                'created_at' => '2023-01-01 00:00:00',
                'updated_at' => '2023-01-01 00:00:00'
            ];
        }
        
        return null;
    }
    
    /**
     * Create 2FA code
     */
    public function create2FACode($user_id) {
        // Generate OTP
        $otp = generate_otp();
        
        // Set expiry time
        $expiry = time() + OTP_EXPIRY_SECONDS;
        
        // In a real application, you would store this in the database
        // For demonstration purposes, we'll store it in the session
        $_SESSION['2fa_code'] = [
            'code' => $otp,
            'expiry' => $expiry
        ];
        
        return $otp;
    }
    
    /**
     * Verify 2FA code
     */
    public function verify2FACode($user_id, $code) {
        // In a real application, you would query the database
        // For demonstration purposes, we'll check the session
        
        if (!isset($_SESSION['2fa_code'])) {
            return false;
        }
        
        $stored_code = $_SESSION['2fa_code']['code'];
        $expiry = $_SESSION['2fa_code']['expiry'];
        
        // Check if code has expired
        if (time() > $expiry) {
            return false;
        }
        
        // Check if code matches
        return $code === $stored_code;
    }
    
    /**
     * Create password reset token
     */
    public function createPasswordResetToken($user_id) {
        // Generate token
        $token = generate_token();
        
        // Set expiry time (30 minutes)
        $expiry = time() + (30 * 60);
        
        // In a real application, you would store this in the database
        // For demonstration purposes, we'll store it in the session
        $_SESSION['password_reset'] = [
            'user_id' => $user_id,
            'token' => $token,
            'expiry' => $expiry
        ];
        
        return $token;
    }
    
    /**
     * Verify password reset token
     */
    public function verifyPasswordResetToken($token) {
        // In a real application, you would query the database
        // For demonstration purposes, we'll check the session
        
        if (!isset($_SESSION['password_reset'])) {
            return false;
        }
        
        $stored_token = $_SESSION['password_reset']['token'];
        $expiry = $_SESSION['password_reset']['expiry'];
        $user_id = $_SESSION['password_reset']['user_id'];
        
        // Check if token has expired
        if (time() > $expiry) {
            return false;
        }
        
        // Check if token matches
        if ($token !== $stored_token) {
            return false;
        }
        
        return $user_id;
    }
    
    /**
     * Update user password
     */
    public function updatePassword($user_id, $password) {
        // In a real application, you would update the database
        // For demonstration purposes, we'll just return true
        
        // Hash the password
        $hashed_password = hash_password($password);
        
        // Clear password reset token
        unset($_SESSION['password_reset']);
        
        return true;
    }
    
    /**
     * Log login attempt
     */
    public function logLoginAttempt($email, $status, $ip) {
        // In a real application, you would log to the database
        // For demonstration purposes, we'll just log to the error log
        
        $timestamp = date('Y-m-d H:i:s');
        $log_message = "[$timestamp] Login attempt: Email: $email, Status: $status, IP: $ip";
        error_log($log_message);
    }
}

