



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Login - XING FU CHA'; ?></title>
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
                    <h2>Welcome Back</h2>
                    <p>Login to your account to continue</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="auth-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo $error; ?></span>
                    </div>
                <?php endif; ?>

                <form action="/login" method="post" class="auth-form">
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

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="/forgot-password" class="forgot-password">Forgot Password?</a>
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
                    <p>Are you an admin? <a href="/admin-login">Admin Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/auth.js"></script>
</body>
</html>