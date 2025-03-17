

    <div class="auth-container">
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
                <div class="auth-message" style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
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
    </div>



