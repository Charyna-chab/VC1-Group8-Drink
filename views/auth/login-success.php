<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : 'Login Successful - XING FU CHA'; ?></title>
  <link rel="icon" type="image/png" href="/assets/image/logo/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
  <div class="main-container">
    <div class="auth-container">
      <!-- Left side - Success message -->
      <div class="auth-form-container">
        <div class="success-container">
          <i class="fas fa-check-circle success-icon"></i>
          <h2 class="success-message">Login Successful!</h2>
          <p class="redirect-message">Welcome back, <?php echo isset($user) && isset($user['name']) ? htmlspecialchars($user['name']) : 'User'; ?>. Redirecting to order page<span class="loading-dots"></span></p>
          <a href="/order" class="auth-button">Go to Order Page</a>
        </div>
      </div>
      
      <!-- Right side - Image -->
      <div class="auth-image" style="background-image: url('/assets/image/order-now-bg.jpg');">
        <div class="bubble-decoration"></div>
        <div class="auth-image-content">
          <img src="/assets/image/logo/logo-white.png" alt="XING FU CHA" class="brand-logo">
        </div>
      </div>
    </div>
  </div>
  
  <script src="/assets/js/auth.js"></script>
  <script>
    // Redirect after 3 seconds
    setTimeout(() => {
      window.location.href = '/order';
    }, 3000);
  </script>
</body>
</html>

