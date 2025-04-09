<?php
// Start session (MUST BE AT VERY TOP)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? htmlspecialchars($title) : 'XING FU CHA'; ?></title>
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
  <!-- MAIN CONTENT -->
  <div class="main-container">
    <div class="auth-container">
      <!-- Left side - Form -->
      <div class="auth-form-container">
        <div class="auth-header">
          <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
          <h2>Welcome Back</h2>
          <p>Login to your account to continue</p>
        </div>

        <?php if(isset($error)): ?>
          <div class="auth-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo htmlspecialchars($error); ?></span>
          </div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
          <div class="auth-success">
            <i class="fas fa-check-circle"></i>
            <span><?php echo htmlspecialchars($success); ?></span>
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

          <div class="divider">
            <span class="divider-text">Or login with</span>
          </div>

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
        </form>

        <div class="auth-footer">
          <p>Don't have an account? <a href="/register">Register</a></p>
          <p>Are you an admin? <a href="/admin-login">Admin Login</a></p>
        </div>
      </div>
      
      <!-- Right side - Image -->
      <div class="auth-image" style="background-image: url('assets/image/image-admin-form.jpg');">
        <div class="bubble-decoration"></div>
        <div class="auth-image-content">
          <img src="/assets/image/logo/logo-white.png" alt="" class="brand-logo">
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.querySelector('.toggle-password');
        const password = document.querySelector('#password');
        
        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        }
    });
  </script>
</body>
</html>
