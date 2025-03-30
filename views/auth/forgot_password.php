<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : 'Forgot Password - XING FU CHA'; ?></title>
  <link rel="icon" type="image/png" href="/assets/image/logo/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
  <div class="main-container">
    <!-- Main Content -->
    <div class="auth-container">
      <!-- Left side - Form -->
      <div class="auth-form-container">
        <div class="auth-header">
          <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
          <h2>Forgot Password</h2>
          <p>Enter your email to reset your password</p>
        </div>

        <?php if(isset($error)): ?>
          <div class="auth-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo $error; ?></span>
          </div>
        <?php endif; ?>

        <?php if(isset($message)): ?>
          <div class="auth-message">
            <i class="fas fa-check-circle"></i>
            <span><?php echo $message; ?></span>
          </div>
        <?php endif; ?>

        <form action="/forgot-password" method="post" class="auth-form">
          <div class="form-group">
            <label for="email">Email</label>
            <div class="input-with-icon">
              <i class="fas fa-envelope"></i>
              <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
          </div>

          <button type="submit" class="auth-button">Reset Password</button>
        </form>

        <div class="auth-footer">
          <p>Remember your password? <a href="/login">Login</a></p>
        </div>
      </div>
      
      <!-- Right side - Image -->
      <div class="auth-image" style="background-image: url('/assets/image/forgot-password-bg.jpg');">
        <div class="bubble-decoration"></div>
        <div class="auth-image-content">
          <img src="/assets/image/logo/logo-white.png" alt="XING FU CHA" class="brand-logo">
        </div>
      </div>
    </div>
  </div>

  <script src="/assets/js/auth.js"></script>
</body>
</html>

