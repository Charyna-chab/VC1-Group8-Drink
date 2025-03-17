<?php
/**
 * Authentication Library
 * 
 * This is the PHP equivalent of the auth.ts file from the Next.js implementation.
 * It handles user authentication, session management, 2FA verification, and password reset.
 */
class Auth {
    private $db;
    
    public function __construct() {
        // In a real application, you would establish a database connection here
        $this->db = null;
    }
    
    /**
     * Get the current session
     */
    public function getSession() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        
        // In a real application, you would verify the session against a database
        return [
            'user' => [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email'] ?? '',
                'name' => $_SESSION['user_name'] ?? '',
                'role' => $_SESSION['user_role'] ?? '',
            ],
            'twoFactorVerified' => $_SESSION['2fa_verified'] ?? false,
            'expires' => $_SESSION['expires'] ?? null,
        ];
    }
    
    /**
     * Login a user
     */
    public function login($email, $password) {
        // In a real application, you would verify credentials against a database
        // For demo purposes, we'll just check against our mock user
        if ($email !== 'admin@email.com') {
            throw new Exception("Invalid email or password");
        }
        
        // In a real application, you would verify the password hash
        // For demo purposes, we'll just check if the password is "password"
        if ($password !== 'vc-drink-08') {
            throw new Exception("Invalid email or password");
        }
        
        // Create a session
        $_SESSION['user_id'] = '1';
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = 'Admin User';
        $_SESSION['user_role'] = 'admin';
        $_SESSION['2fa_verified'] = false;
        $_SESSION['expires'] = time() + (24 * 60 * 60); // 24 hours
        
        // Log the login
        $this->logLoginAttempt($email, 'success', $_SERVER['REMOTE_ADDR']);
        
        return [
            'user' => [
                'id' => '1',
                'email' => $email,
                'name' => 'Admin User',
                'role' => 'admin',
            ],
        ];
    }
    
    /**
     * Logout a user
     */
    public function logout() {
        // Clear session
        session_unset();
        session_destroy();
        
        // Clear remember me cookie if it exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }
    }
    
    /**
     * Verify 2FA code
     */
    public function verify2FA($userId, $code) {
        // In a real application, you would verify the 2FA code against a database
        // For demo purposes, we'll just check if the code is 6 digits
        if (!preg_match('/^\d{6}$/', $code)) {
            throw new Exception("Invalid verification code");
        }
        
        // Check if the code matches the one in the session (for demo purposes)
        if (isset($_SESSION['demo_otp']) && $code !== $_SESSION['demo_otp']) {
            throw new Exception("Invalid verification code");
        }
        
        // Update the session to indicate 2FA is verified
        $_SESSION['2fa_verified'] = true;
        
        return true;
    }
    
    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($email) {
        // In a real application, you would check if the email exists in the database
        if ($email !== 'admin@example.com') {
            // For security reasons, don't reveal that the email doesn't exist
            return [
                'success' => true,
                'message' => "Password reset email sent",
            ];
        }
        
        // Generate a reset token
        $token = bin2hex(random_bytes(16));
        
        // In a real application, you would store this token in a database with an expiry
        // For demo purposes, we'll store it in the session
        $_SESSION['password_reset'] = [
            'email' => $email,
            'token' => $token,
            'expires' => time() + (30 * 60), // 30 minutes
        ];
        
        // Generate reset link
        $resetLink = "http://{$_SERVER['HTTP_HOST']}/reset-password?token=$token";
        
        // In a real application, you would send an email with the reset link
        // For demo purposes, we'll just log it
        error_log("Password reset link for $email: $resetLink");
        
        return [
            'success' => true,
            'message' => "Password reset email sent",
        ];
    }
    
    /**
     * Reset password
     */
    public function resetPassword($token, $newPassword) {
        // In a real application, you would verify the token against a database
        if (!isset($_SESSION['password_reset']) || $_SESSION['password_reset']['token'] !== $token) {
            throw new Exception("Invalid or expired token");
        }
        
        // Check if the token has expired
        if (time() > $_SESSION['password_reset']['expires']) {
            throw new Exception("Token has expired");
        }
        
        // Validate password
        $passwordErrors = $this->validatePasswordStrength($newPassword);
        if (!empty($passwordErrors)) {
            throw new Exception($passwordErrors[0]);
        }
        
        // In a real application, you would update the user's password in the database
        // For demo purposes, we'll just clear the reset token
        unset($_SESSION['password_reset']);
        
        return [
            'success' => true,
            'message' => "Password reset successful",
        ];
    }
    
    /**
     * Validate password strength
     */
    private function validatePasswordStrength($password) {
        $errors = [];
        
        // Check length
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        
        // Check for uppercase
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        
        // Check for lowercase
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }
        
        // Check for number
        if (!preg_match('/\d/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
        
        // Check for special character
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }
        
        return $errors;
    }
    
    /**
     * Log login attempt
     */
    private function logLoginAttempt($email, $status, $ip) {
        // In a real application, you would log to a database
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] Login attempt: Email: $email, Status: $status, IP: $ip";
        error_log($logMessage);
    }
    
    /**
     * Generate and send 2FA code
     */
    public function generate2FACode($userId) {
        // Generate a 6-digit OTP
        $otp = sprintf('%06d', mt_rand(0, 999999));
        
        // In a real application, you would store this in a database with an expiry
        // For demo purposes, we'll store it in the session
        $_SESSION['demo_otp'] = $otp;
        $_SESSION['2fa_code'] = [
            'code' => $otp,
            'expires' => time() + 300, // 5 minutes
        ];
        
        // In a real application, you would send this via email or SMS
        // For demo purposes, we'll just log it
        error_log("2FA code for user $userId: $otp");
        
        return $otp;
    }
    
    /**
     * Check if user is authenticated
     */
    public function isAuthenticated() {
        return isset($_SESSION['user_id']) && isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true;
    }
    
    /**
     * Check if user is logged in (but may not have completed 2FA)
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Check if user has completed 2FA
     */
    public function is2FAVerified() {
        return isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true;
    }
}

