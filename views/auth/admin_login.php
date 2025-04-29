<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
    header("Location: /admin-dashboard");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? htmlspecialchars($title) : 'Admin Login - XING FU CHA'; ?></title>
  <link rel="icon" type="image/png" href="/assets/image/logo/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .login-card {
      display: flex;
      max-width: 1200px;
      width: 100%;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      height: 600px;
      position: relative;
    }
    .form-side {
      width: 40%;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .image-side {
      width: 60%;
      position: relative;
    }
    .bg-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .image-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.03);
    }
    .image-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      text-align: center;
      width: 80%;
    }
    .brand-logo {
      max-width: 100%;
      border-radius: 8px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
      font-size: 16px;
    }
    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      background: none;
      border: none;
      color: #888;
      font-size: 16px;
    }
    .auth-button {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 12px;
      font-weight: 600;
      width: 100%;
      border-radius: 8px;
      font-size: 16px;
      margin-top: 20px;
    }
    .auth-button:hover {
      background-color: #ff5252;
    }
    .login-header {
      margin-bottom: 30px;
      text-align: center;
    }
    .login-header img {
      width: 70px;
      margin-bottom: 15px;
    }
    .login-header h2 {
      font-size: 22px;
      margin-bottom: 10px;
    }
    .login-header p {
      font-size: 15px;
    }
    .form-control {
      font-size: 15px;
      padding: 10px 15px 10px 40px;
      height: auto;
      width: 100%;
      margin-bottom: 15px;
    }
    .form-label {
      font-size: 15px;
      margin-bottom: 8px;
      font-weight: 500;
    }
    .form-group {
      width: 100%;
      margin-bottom: 20px;
    }
    .user-login-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: #dc3545;
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      font-weight: 500;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      z-index: 10;
      border: none;
    }
    .user-login-btn:hover {
      background-color: #bb2d3b;
      color: white;
      transform: translateY(-2px);
    }
    .user-login-btn i {
      margin-right: 5px;
    }
    .image-preview {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      display: none;
      margin: 10px auto;
    }
    @media (max-width: 992px) {
      .login-card {
        flex-direction: column;
        height: auto;
      }
      .form-side, .image-side {
        width: 100%;
      }
      .form-side {
        padding: 30px;
      }
      .image-side {
        height: 400px;
      }
      .user-login-btn {
        position: relative;
        top: auto;
        right: auto;
        display: block;
        margin: 0 auto 20px;
        width: fit-content;
      }
    }
  </style>
</head>
<body>
  <a href="/login" class="user-login-btn">
    <i class="fas fa-sign-in-alt"></i> User Login
  </a>
  <div class="login-card">
    <div class="form-side">
      <div class="login-header">
        <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
        <h2 class="fw-bold">Admin Login</h2>
        <p class="text-muted">Login to your admin account to continue</p>
      </div>
      <?php if(isset($error)): ?>
        <div class="alert alert-danger d-flex align-items-center mb-3 py-2">
          <i class="fas fa-exclamation-circle me-2"></i>
          <span><?php echo htmlspecialchars($error); ?></span>
        </div>
      <?php endif; ?>
      <form action="/admin-login" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <div class="position-relative">
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your admin email" required>
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <div class="position-relative">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            <button type="button" class="password-toggle">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <div class="form-group">
          <label for="profile_image" class="form-label">Profile Image (Optional)</label>
          <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
          <img id="image-preview" class="image-preview" alt="Image Preview">
        </div>
        <button type="submit" class="btn auth-button">Continue to Verification</button>
      </form>
      <div class="text-center footer-links">
        <p class="text-muted">Forgot Password? <a href="/forgot-password" class="text-danger text-decoration-none">Reset Password</a></p>
      </div>
    </div>
    <div class="image-side">
      <div class="image-overlay"></div>
      <div class="image-content">
        <img src="/assets/image/image-admin-form.jpg" alt="XING FU CHA" class="brand-logo">
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('.password-toggle').forEach(function(button) {
      button.addEventListener('click', function() {
        const passwordInput = this.closest('.position-relative').querySelector('input');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
          passwordInput.type = 'password';
          icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
      });
    });

    // Image preview
    document.getElementById('profile_image').addEventListener('change', function(e) {
      const file = e.target.files[0];
      const preview = document.getElementById('image-preview');
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = '';
        preview.style.display = 'none';
      }
    });
  </script>
</body>
</html>
