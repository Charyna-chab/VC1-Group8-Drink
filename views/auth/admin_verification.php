<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// If already logged in as admin, redirect to dashboard
if (isset($_SESSION['user_id']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
    header("Location: /admin-dashboard");
    exit();
}
// If verification data is not set, redirect to admin login
if (!isset($_SESSION['admin_email']) || !isset($_SESSION['verification_code'])) {
    header("Location: /admin-login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? htmlspecialchars($title) : 'Admin Verification - XING FU CHA'; ?></title>
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
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
    }
    .main-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    .auth-container {
      max-width: 1000px;
      width: 100%;
      display: flex;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      overflow: hidden;
      background: white;
      min-height: 600px;
    }
    .auth-form-container {
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-width: 400px;
    }
    .auth-header {
      text-align: center;
      margin-bottom: 30px;
    }
    .auth-header img {
      width: 80px;
      margin-bottom: 15px;
    }
    .auth-header h2 {
      font-size: 24px;
      margin-bottom: 10px;
      color: #333;
    }
    .auth-header p {
      color: #666;
    }
    .email-sent-info {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 25px;
      text-align: center;
    }
    .email-sent-info i {
      font-size: 24px;
      color: #4CAF50;
      margin-bottom: 10px;
    }
    .email-sent-info p {
      margin: 5px 0;
      color: #555;
    }
    .email-sent-info .small {
      font-size: 14px;
      color: #777;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #555;
    }
    .form-control {
      width: 100%;
      padding: 15px;
      font-size: 18px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 5px;
      letter-spacing: 5px;
      font-weight: bold;
      box-sizing: border-box;
    }
    .auth-button {
      width: 100%;
      padding: 15px;
      background-color: #ff3e4d;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s;
      box-sizing: border-box;
    }
    .auth-button:hover {
      background-color: #e6323f;
    }
    .resend-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #ff3e4d;
      text-decoration: none;
    }
    .resend-link:hover {
      text-decoration: underline;
    }
    .auth-footer {
      text-align: center;
      margin-top: 30px;
      color: #777;
    }
    .auth-footer a {
      color: #ff3e4d;
      text-decoration: none;
    }
    .auth-footer a:hover {
      text-decoration: underline;
    }
    .auth-image {
      flex: 1;
      background: url('/assets/image/image-admin-form.jpg') no-repeat center center;
      background-size: cover;
      position: relative;
      min-height: 300px;
    }
    .bubble-decoration {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 1;
    }
    .auth-error {
      background-color: #ffebee;
      color: #d32f2f;
      padding: 12px;
      border-radius: 5px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    .auth-error i {
      margin-right: 10px;
      font-size: 18px;
    }
    /* For development purposes - display verification code */
    .dev-code {
      margin-top: 15px;
      padding: 10px;
      background-color: #f8f9fa;
      border: 1px dashed #ddd;
      border-radius: 5px;
      text-align: center;
      font-family: monospace;
    }
    @media (max-width: 768px) {
      .auth-container {
        flex-direction: column;
        min-height: auto;
      }
      .auth-form-container {
        min-width: auto;
        padding: 30px 20px;
      }
      .auth-image {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="auth-container">
      <div class="auth-form-container">
        <div class="auth-header">
          <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
          <h2>Admin Verification</h2>
          <p>Enter the verification code sent to your email</p>
        </div>

        <?php if (isset($error)): ?>
          <div class="auth-error">
            <i class="fas fa-exclamation-circle"></i>
            <span><?php echo htmlspecialchars($error); ?></span>
          </div>
        <?php endif; ?>
        
        <div class="email-sent-info">
          <i class="fas fa-envelope"></i>
          <p>A verification code has been sent to your email</p>
          <?php 
            if (isset($_SESSION['admin_email'])) {
              $email = $_SESSION['admin_email'];
              $parts = explode('@', $email);
              $username = $parts[0];
              $domain = $parts[1];
              
              // Show only first 2 characters and last character of username
              $maskedUsername = substr($username, 0, 2) . str_repeat('*', strlen($username) - 3) . substr($username, -1);
              
              echo "<p><strong>" . htmlspecialchars($maskedUsername) . "@" . htmlspecialchars($domain) . "</strong></p>";
            }
          ?>
          <p class="small">Please check your inbox and spam folder</p>
          <p class="small">Code expires in: <span id="verification-timer" class="fw-bold">10:00</span></p>
        </div>

        <form action="/admin-verification" method="post" class="auth-form">
          <div class="form-group">
            <label for="verification_code">Verification Code</label>
            <input type="text" id="verification_code" name="verification_code" placeholder="Enter 6-digit code" required maxlength="6" pattern="[0-9]{6}" class="form-control">
          </div>

          <button type="submit" class="auth-button">Verify & Login</button>
          
          <a href="/admin-login" class="resend-link">Didn't receive the code? Try again</a>
        </form>

        <?php if (isset($demo_code)): ?>
        <div class="dev-code">
          <p>Development Mode: Verification Code</p>
          <strong><?php echo $demo_code; ?></strong>
        </div>
        <?php endif; ?>

        <div class="auth-footer">
          <p>Not an admin? <a href="/login">User Login</a></p>
        </div>
      </div>
      
      <div class="auth-image">
        <div class="bubble-decoration"></div>
      </div>
    </div>
  </div>

  <script>
    // Auto focus on verification code input
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('verification_code').focus();
      
      // Format verification code input to only accept numbers
      document.getElementById('verification_code').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
      
      // Countdown timer
      let timeLeft = 600; // 10 minutes in seconds
      const timerElement = document.getElementById('verification-timer');
      
      const countdownTimer = setInterval(function() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        
        if (timeLeft <= 0) {
          clearInterval(countdownTimer);
          timerElement.textContent = "Expired";
          timerElement.style.color = "#d32f2f";
          
          // Redirect to login after expiration
          setTimeout(function() {
            window.location.href = "/admin-login";
          }, 3000);
        }
        
        timeLeft--;
      }, 1000);
    });
  </script>
</body>
</html>
