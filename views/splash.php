<body class="splash-body">
    <div class="splash-container">
        <div class="splash-logo">
            <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
            <h1 class="splash-title">XING FU CHA</h1>
            <p class="splash-tagline">Premium Boba Tea Experience</p>
        </div>
        
        <div class="splash-bubbles">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>
        
        <div class="splash-actions">
            <button id="loginBtn" class="splash-btn login-splash">Login</button>
            <button id="registerBtn" class="splash-btn register-splash">Register</button>
            <!-- Continue as Guest -->
            <button id="guestBtn" class="splash-btn guest-splash">Continue as Guest</button>
        </div>
    </div>

    <script>
    // Update the guest button to go directly to the menu
    document.addEventListener("DOMContentLoaded", function() {
        const guestBtn = document.getElementById('guestBtn');
        if (guestBtn) {
            guestBtn.addEventListener('click', function() {
                window.location.href = '/menu';
            });
        }
    });
    </script>
    
    <!-- Login Modal -->
    <div id="loginModal" class="auth-modal">
        <div class="auth-modal-content">
            <span class="close-modal">&times;</span>
            <div class="auth-header">
                <img src="/assets/images/logo/logo-small.png" alt="XING FU CHA Logo">
                <h2>Welcome Back</h2>
                <p>Login to your account to continue</p>
            </div>
            
            <div id="loginError" class="auth-error" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <span>Error message will appear here</span>
            </div>
            
            <form id="loginForm" class="auth-form">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="loginEmail" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                
                <button type="submit" class="auth-button">Login</button>
                
                <div class="social-login">
                    <p>Or login with</p>
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
                </div>
            </form>
            
            <div class="auth-footer">
                <p>Don't have an account? <a href="#" id="switchToRegister">Register</a></p>
            </div>
        </div>
    </div>
    
    <!-- Register Modal -->
    <div id="registerModal" class="auth-modal">
        <div class="auth-modal-content">
            <span class="close-modal">&times;</span>
            <div class="auth-header">
                <img src="/assets/images/logo/logo-small.png" alt="XING FU CHA Logo">
                <h2>Create Account</h2>
                <p>Join us and enjoy our delicious boba tea</p>
            </div>
            
            <div id="registerError" class="auth-error" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <span>Error message will appear here</span>
            </div>
            
            <form id="registerForm" class="auth-form">
                <div class="form-group">
                    <label for="registerName">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="registerName" name="name" placeholder="Enter your full name" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="registerEmail">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="registerEmail" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="registerPassword" name="password" placeholder="Create a password" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="registerConfirmPassword">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="registerConfirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="terms-checkbox">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a></span>
                    </label>
                </div>
                
                <button type="submit" class="auth-button">Create Account</button>
                
                <div class="social-login">
                    <p>Or register with</p>
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
                </div>
            </form>
            
            <div class="auth-footer">
                <p>Already have an account? <a href="#" id="switchToLogin">Login</a></p>
            </div>
        </div>
    </div>
    
    <script src="/assets/js/splash.js"></script>
</body>


