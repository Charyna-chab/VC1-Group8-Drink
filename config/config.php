<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'admin_auth');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application configuration
define('APP_NAME', 'Admin Portal');
define('APP_URL', 'http://localhost');

// Security configuration
define('CSRF_TOKEN_SECRET', 'change-this-to-a-random-string');
define('PASSWORD_PEPPER', 'change-this-to-a-random-string');

// Email configuration
define('MAIL_HOST', 'smtp.example.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'admin@example.com');
define('MAIL_PASSWORD', 'your-password');
define('MAIL_FROM_ADDRESS', 'admin@example.com');
define('MAIL_FROM_NAME', 'Admin Portal');

// 2FA configuration
define('OTP_EXPIRY_SECONDS', 300); // 5 minutes
define('OTP_LENGTH', 6);

// Session configuration
define('SESSION_LIFETIME', 3600); // 1 hour
define('REMEMBER_ME_DAYS', 30); // 30 days

