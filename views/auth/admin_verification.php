<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Admin Verification - XING FU CHA'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <style>
        .verification-code {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .verification-code input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0 5px;
        }
        
        .verification-code input:focus {
            outline: none;
            border-color: #ff7f50;
            box-shadow: 0 0 0 2px rgba(255, 127, 80, 0.2);
        }
        
        .demo-code {
            background-color: #f8f9fa;
            border: 1px dashed #ddd;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 5px;
        }
        
        .demo-code p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .demo-code strong {
            font-size: 24px;
            color: #333;
            display: block;
            margin-top: 5px;
        }
        
        .resend-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #ff7f50;
            text-decoration: none;
        }
        
        .resend-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Main Content -->
        <div class="auth-container">
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
        </div>
    </div>

    <script src="/assets/js/auth.js"></script>
    <script>
        // Auto-focus and auto-tab for verification code inputs
        document.addEventListener('DOMContentLoaded', function() {
            const verificationInput = document.getElementById('verification_code');
            if (verificationInput) {
                verificationInput.focus();
            }
        });
    </script>
</body>
</html>

