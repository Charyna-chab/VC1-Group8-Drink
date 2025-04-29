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
      position: fixed;
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
      color: rgb(255, 0, 72);
      border: 2px solid #e0e0e0;
    }
    .fa-user-plus {
      background-color: #ffffff;
      color: rgb(255, 0, 72);
    }
    .register-button:hover {
      background-color: rgb(245, 245, 245);
      transform: translateY(-2px);
    }
    .admin-button {
      background-color: rgb(255, 79, 79);
      color: white;
      border: 2px solid rgb(255, 0, 0);
    }
    .fa-user-lock {
      background-color: rgb(255, 79, 79);
      color: white;
    }
    .admin-button:hover {
      background-color: hsl(0, 100.00%, 50.00%);
      transform: translateY(-2px);
    }
    .auth-top-button i {
      margin-right: 8px;
    }
    /* Enhanced Image Preview Styles */
    .image-preview {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
      display: none;
      margin: 15px auto;
      border: 3px solid #ff4f4f;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    /* Improved File Input Styling */
    .custom-file-upload {
      display: inline-block;
      padding: 10px 20px;
      cursor: pointer;
      background-color: #ff4f4f;
      color: white;
      border-radius: 5px;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    .custom-file-upload:hover {
      background-color: #e04444;
      transform: translateY(-2px);
    }
    .custom-file-upload i {
      margin-right: 5px;
    }
    #profile_image {
      display: none;
    }
    /* Profile Display Styles */
    .profile-container {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      z-index: 1000;
      text-align: center;
      width: 400px;
    }
    .profile-container.active {
      display: block;
    }
    .profile-image {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      margin: 0 auto 20px;
      object-fit: cover;
      border: 5px solid #ff4f4f;
    }
    .profile-details {
      margin: 20px 0;
    }
    .profile-details h3 {
      margin: 10px 0;
      color: #333;
    }
    .profile-details p {
      margin: 5px 0;
      color: #666;
    }
    .close-profile {
      background-color: #ff4f4f;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .close-profile:hover {
      background-color: #e04444;
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

        <form action="/login" method="post" class="auth-form" enctype="multipart/form-data">
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

          <div class="form-group">
            <label for="profile_image">Profile Image (Optional)</label>
            <label class="custom-file-upload">
              <i class="fas fa-image"></i> Choose Image
              <input type="file" id="profile_image" name="profile_image" accept="image/*">
            </label>
            <img id="image-preview" class="image-preview" alt="Image Preview">
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

  <!-- Profile Display Modal -->
  <?php if (isset($_SESSION['user'])): ?>
  <div class="profile-container" id="profileModal">
    <img src="<?php echo htmlspecialchars($_SESSION['user']['avatar']); ?>" class="profile-image" alt="Profile Image">
    <div class="profile-details">
      <h3><?php echo htmlspecialchars($_SESSION['user']['name']); ?></h3>
      <p>Email: <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
      <p>Role: <?php echo htmlspecialchars($_SESSION['user']['role']); ?></p>
      <?php if (!empty($_SESSION['user']['phone'])): ?>
        <p>Phone: <?php echo htmlspecialchars($_SESSION['user']['phone']); ?></p>
      <?php endif; ?>
      <?php if (!empty($_SESSION['user']['address'])): ?>
        <p>Address: <?php echo htmlspecialchars($_SESSION['user']['address']); ?></p>
      <?php endif; ?>
    </div>
    <button class="close-profile" onclick="closeProfileModal()">Close</button>
  </div>
  <?php endif; ?>

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

        // Profile modal handling
        const profileModal = document.getElementById('profileModal');
        
        // Show profile on login if user is logged in
        <?php if (isset($_SESSION['user'])): ?>
          profileModal.classList.add('active');
        <?php endif; ?>
    });

    function closeProfileModal() {
      const profileModal = document.getElementById('profileModal');
      profileModal.classList.remove('active');
    }
  </script>
</body>
</html>