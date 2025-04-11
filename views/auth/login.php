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
  <style>
    /* NEW IMPROVED STYLES FOR TOP BUTTONS */
    .auth-top-buttons {
      position: fixed; /* Changed from absolute to fixed */
      top: 20px;
      right: 20px;
      display: flex;
      gap: 15px;
      z-index: 1000;
    }
    .auth-top-button {
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 15px;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .register-button {
      background-color: #ffffff;
      color:rgb(255, 0, 72) ;
      border: 2px solid #e0e0e0;
    }
    .fa-user-plus {
      background-color: #ffffff;
      color:rgb(255, 0, 72) ;
      
    }
    .register-button:hover {
      background-color:rgb(245, 245, 245);
      transform: translateY(-2px);
    }
    .admin-button {
      background-color:rgb(255, 79, 79);
      color: white;
      border: 2px solidrgb(255, 0, 0);
    }
    .fa-user-lock {
      background-color:rgb(255, 79, 79);
      color: white;
      
    }

    .admin-button:hover {
      background-color:hsl(0, 100.00%, 50.00%);
      transform: translateY(-2px);
    }
    .auth-top-button i {
      margin-right: 8px;
    }
  </style>
</head>
<body>
  <!-- IMPROVED BUTTONS - NOW VISIBLE IN TOP RIGHT -->
  <div class="auth-top-buttons">
    <a href="/register" class="auth-top-button register-button">
      <i class="fas fa-user-plus"></i> Register
    </a>

    <a href="/admin-login" class="auth-top-button admin-button">
  <i class="fas fa-user-lock"></i> Admin Login
</a>


  </div>

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