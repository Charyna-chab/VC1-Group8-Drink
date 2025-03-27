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
                    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
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
                            <input type="email" id="email" name="email" placeholder="Enter your admin email" required>
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

                    <button type="submit" class="auth-button">Continue to Verification</button>
                </form>

                <div class="auth-footer">
                    <p>Not an admin? <a href="/login">User Login</a></p>
                    <p>Forgot Password? <a href="/forgot-password">Reset Password</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/auth.js"></script>
</body>
</html>

