<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : 'Admin Verification - XING FU CHA'; ?></title>
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
          <h2>Admin Verification</h2>
          <p>Enter the verification code sent to your email</p>
        </div>

        <?php if(isset($error)): ?>
          <div class="auth-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo $error; ?></span>
          </div>
        <?php endif; ?>
        
        <?php if(isset($demo_code)): ?>
          <div class="demo-code">
            <p>For demo purposes, your verification code is:</p>
            <strong><?php echo $demo_code; ?></strong>
            <p>(In a real application, this would be sent to your email)</p>
          </div>
        <?php endif; ?>

        <form action="/admin-verification" method="post" class="auth-form">
          <div class="form-group">
            <label for="verification_code">Verification Code</label>
            <input type="text" id="verification_code" name="verification_code" placeholder="Enter 6-digit code" required maxlength="6" pattern="[0-9]{6}" class="form-control" style="width: 100%; padding: 12px; font-size: 18px; text-align: center;">
          </div>

          <button type="submit" class="auth-button">Verify & Login</button>
          
          <a href="/admin-login" class="resend-link">Resend Code</a>
        </form>

        <div class="auth-footer">
          <p>Not an admin? <a href="/login">User Login</a></p>
        </div>
      </div>
      
      <!-- Right side - Image -->
      <div class="auth-image" style="background-image: url('/assets/image/verification-bg.jpg');">
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

