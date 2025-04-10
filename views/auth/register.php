<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? htmlspecialchars($title) : 'Register - XING FU CHA'; ?></title>
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
    <!-- Login Button at Top Right -->
    <div class="login-redirect-container">
  <a href="/login" class="login-redirect-button">
    <i class="fas fa-sign-in-alt"></i> Login
  </a>
</div>

    
    <!-- Main Content -->
    <div class="auth-container register-container">
      <!-- Form Container -->
      <div class="auth-form-container">
        <div class="auth-header">
          <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
          <h2>Create Account</h2>
          <p>Join us and enjoy our delicious boba tea</p>
        </div>

        <?php if(isset($error)): ?>
          <div class="auth-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo htmlspecialchars($error); ?></span>
          </div>
        <?php endif; ?>

        <form action="/register" method="post" class="auth-form">
          <div class="form-group">
            <label for="name">Full Name</label>
            <div class="input-with-icon">
              <i class="fas fa-user"></i>
              <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <div class="input-with-icon">
              <i class="fas fa-envelope"></i>
              <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
          </div>

          <div class="form-group">
            <label for="phone">Phone Number</label>
            <div class="input-with-icon">
              <i class="fas fa-phone"></i>
              <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
            </div>
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <div class="input-with-icon">
              <i class="fas fa-map-marker-alt"></i>
              <input type="text" id="address" name="address" placeholder="Enter your address">
            </div>
          </div>
          
          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-with-icon">
              <i class="fas fa-lock"></i>
              <input type="password" id="password" name="password" placeholder="Create a password" required>
              <i class="fas fa-eye toggle-password"></i>
            </div>
          </div>

          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <div class="input-with-icon">
              <i class="fas fa-lock"></i>
              <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
              <i class="fas fa-eye toggle-password"></i>
            </div>
          </div>

          <div class="form-options">
            <label class="terms-checkbox">
              <input type="checkbox" name="terms" required>
              <span>I agree to the <a href="/terms">Terms of Service</a></span>
            </label>
          </div>

          <button type="submit" class="auth-button">Create Account</button>

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
    </div>
  </div>

  <style>
.login-redirect-container {
  position: absolute;
  top: 20px;
  right: 20px;
}

.login-redirect-button {
  display: inline-flex;
  align-items: center;
  padding: 10px 20px;
  background-color: #ff0000;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-weight: 500;
  transition: background-color 0.3s;
  gap: 8px;
}

.login-redirect-button:hover {
  background-color: #cc0000;
}


.login-redirect-button i {
  font-size: 14px;
}
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        
        togglePasswordButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const passwordField = this.previousElementSibling;
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        });
    });
  </script>
</body>
</html>