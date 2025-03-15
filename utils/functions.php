<?php
/**
 * Generate a CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

/**
 * Hash a password
 */
function hash_password($password) {
    // Add pepper to password before hashing
    $password = $password . PASSWORD_PEPPER;
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify a password
 */
function verify_password($password, $hash) {
    // Add pepper to password before verifying
    $password = $password . PASSWORD_PEPPER;
    return password_verify($password, $hash);
}

/**
 * Generate a random token
 */
function generate_token($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Generate a random OTP
 */
function generate_otp($length = OTP_LENGTH) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= mt_rand(0, 9);
    }
    return $otp;
}

/**
 * Send an email
 */
function send_email($to, $subject, $message) {
    // In a real application, you would use a library like PHPMailer
    // For demonstration purposes, we'll just return true
    
    // Example with PHPMailer (commented out)
    /*
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = MAIL_PORT;
        
        $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $mail->addAddress($to);
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
    */
    
    return true;
}

/**
 * Redirect to a URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if 2FA is verified
 */
function is_2fa_verified() {
    return isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true;
}

/**
 * Check if user is authenticated (logged in and 2FA verified)
 */
function is_authenticated() {
    return is_logged_in() && is_2fa_verified();
}

/**
 * Check if user is admin
 */
function is_admin() {
    return is_authenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Sanitize input
 */
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Log an action
 */
function log_action($action, $user_id = null, $status = 'success', $details = '') {
    // In a real application, you would log to a database or file
    // For demonstration purposes, we'll just log to the error log
    
    $user_id = $user_id ?? ($_SESSION['user_id'] ?? 'guest');
    $ip = $_SERVER['REMOTE_ADDR'];
    $timestamp = date('Y-m-d H:i:s');
    
    $log_message = "[$timestamp] [$status] [$ip] User ID: $user_id, Action: $action, Details: $details";
    error_log($log_message);
}

/**
 * Validate password strength
 */
function validate_password_strength($password) {
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

