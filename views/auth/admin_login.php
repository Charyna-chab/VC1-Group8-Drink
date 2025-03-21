

<?php

// admin_login.php

// Check if the admin has submitted the login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the admin's email and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Generate a verification code
    $verification_code = rand(100000, 999999);

    // Send the verification code to the admin's email
    $to = $email;
    $subject = 'Verification Code for Admin Login';
    $message = 'Your verification code is: ' . $verification_code;
    $headers = 'From: your_email@example.com' . "\r\n" .
        'Reply-To: your_email@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    // Store the verification code in the session
    $_SESSION['verification_code'] = $verification_code;

    // Redirect the admin to the verification code page
    header('Location: admin_login_verification.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Admin Login - XING FU CHA'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
    <div class="main-container">
        <!-- Main Content -->
        <div class="auth-container">
            <div class="auth-form-container">
                <div class="auth-header">
                    <img src="/assets/images/logo.png" alt="XING FU CHA Logo">
                    <h2>Admin Login</h2>
                    <p>Login to your admin account to continue</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="auth-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <form action="/admin-login" method="post" class="auth-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <i class="fas fa-eye toggle-password"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="verification_code">Verification Code</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="text" id="verification_code" name="verification_code" placeholder="Enter verification code" required>
                        </div>
                    </div>

                    <button type="submit" class="auth-button">Login</button>

                    <div class="social-login">
                        <p>Or login with</p>
                        <div class="social-buttons">
                            <button type="button" class="social-button google">
                                <i class="fab fa-google"></i>
                                <span>Google</span>
                            </button>
                            <button type="button" class="social-button facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="/register">Register</a></p>
                    <p>Forgot Password? <a href="/forgot-password">Reset Password</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/auth.js"></script>
</body>
</html>
