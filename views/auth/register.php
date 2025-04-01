<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : 'Register - XING FU CHA'; ?></title>
  <link rel="icon" type="image/png" href="/assets/image/logo/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
  <div class="main-container">
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
            <span><?php echo $error; ?></span>
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

          <div class="divider">
              class="auth-button">Create Account</button>

          <div class="divider">
            <span class="divider-text">Or register with</span>
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
          <p>Already have an account? <a href="/login">Login</a></p>
        </div>
      </div>
    </div>
  </div>

  <script src="/assets/js/auth.js"></script>
</body>
</html>