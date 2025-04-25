<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - XING FU CHA</title>
    <link rel="icon" type="image/png" href="/assets/image/logo/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <!-- Prevent caching -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
</head>
<body>
    <div class="main-container">
        <div class="auth-container">
            <div class="auth-form-container">
                <div class="auth-header">
                    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
                    <h2>Oops! Something Went Wrong</h2>
                    <p>
                        <?php echo isset($error_message) ? htmlspecialchars($error_message) : 'You need to be logged in to access this page.'; ?>
                    </p>
                </div>

                <div class="auth-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Please login or register to continue.</span>
                </div>

                <div class="auth-buttons">
                    <a href="/login" class="auth-button">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="/register" class="auth-button">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </div>
            </div>

            <!-- Right side - Image -->
            <div class="auth-image" style="background-image: url('/assets/image/image-admin-form.jpg');">
                <div class="bubble-decoration"></div>
                <div class="auth-image-content">
                    <img src="/assets/image/logo/logo-white.png" alt="" class="brand-logo">
                </div>
            </div>
        </div>
    </div>
</body>
</html>