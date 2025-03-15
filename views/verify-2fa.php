<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5EB;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }
        .input-field {
            background-color: #F5F5F5;
            border: none;
            border-radius: 8px;
            padding: 12px 16px;
            width: 100%;
            margin-bottom: 1rem;
        }
        .login-button {
            background-color: #FFA726;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .login-button:hover {
            background-color: #FB8C00;
        }
        .social-login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #E0E0E0;
            border-radius: 8px;
            padding: 8px;
            width: 100%;
            margin-bottom: 0.5rem;
            background: white;
            transition: background-color 0.2s;
        }
        .social-login-button:hover {
            background-color: #F5F5F5;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1rem 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #E0E0E0;
        }
        .divider span {
            padding: 0 10px;
            color: #9E9E9E;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-card">
        <div class="text-center mb-6">
            <img src="/assets/images/logo.png" alt="Logo" class="mx-auto h-16 w-16 mb-4">
            <h2 class="text-2xl font-bold mb-2">Two-Factor Authentication</h2>
            <p class="text-gray-600 text-sm">Login to your account</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-700 p-3 rounded-lg mb-4 text-sm">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($demo_otp)): ?>
            <div class="bg-yellow-50 text-yellow-700 p-3 rounded-lg mb-4 text-sm">
                <strong>Demo Mode:</strong> Your verification code is <strong><?php echo $demo_otp; ?></strong>
            </div>
        <?php endif; ?>

        <form method="POST" action="/verify-2fa">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <input
                type="text"
                name="code"
                placeholder="Password confirmation"
                required
                class="input-field"
                maxlength="6"
            >
            
            <button type="submit" class="login-button mb-4">
                Login
            </button>
        </form>

        <div class="text-right mb-4">
            <a href="/forgot-password" class="text-sm text-gray-600 hover:text-gray-800">
                Forgot password?
            </a>
        </div>

        <button class="social-login-button mb-2">
            <img src="/assets/images/apple-logo.png" alt="Apple" class="h-5 w-5 mr-2">
            Login with Apple
        </button>

        <button class="social-login-button">
            <img src="/assets/images/google-logo.png" alt="Google" class="h-5 w-5 mr-2">
            Login with Google
        </button>

        <div class="divider">
            <span>or</span>
        </div>

        <a href="/phone-login" class="text-center block text-sm text-gray-600 hover:text-gray-800">
            Login with phone number
        </a>
    </div>

    <script>
        // Timer functionality (if needed)
        function startTimer(duration, display) {
            let timer = duration;
            let minutes, seconds;
            
            const interval = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                
                display.textContent = minutes + ":" + seconds;
                
                if (--timer < 0) {
                    clearInterval(interval);
                    display.textContent = "00:00";
                }
            }, 1000);
        }
        
        // Initialize timer if needed
        window.onload = function() {
            const timeLeft = <?php echo $time_left; ?>;
            if (timeLeft > 0) {
                const display = document.querySelector('#timer');
                if (display) {
                    startTimer(timeLeft, display);
                }
            }
        };
    </script>
</body>
</html>

