<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - XING FU CHA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <style>
        .success-container {
            text-align: center;
            padding: 40px 20px;
        }
        
        .success-icon {
            font-size: 80px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .success-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .redirect-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }
        
        .loading-dots {
            display: inline-block;
        }
        
        .loading-dots::after {
            content: '.';
            animation: dots 1.5s steps(5, end) infinite;
        }
        
        @keyframes dots {
            0%, 20% {
                content: '.';
            }
            40% {
                content: '..';
            }
            60% {
                content: '...';
            }
            80%, 100% {
                content: '';
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-form-container">
            <div class="success-container">
                <i class="fas fa-check-circle success-icon"></i>
                <h2 class="success-message">Registration Successful!</h2>
                <p class="redirect-message">Welcome to XING FU CHA, <?php echo isset($user) && isset($user['name']) ? htmlspecialchars($user['name']) : 'User'; ?>. Redirecting to order page<span class="loading-dots"></span></p>
                <a href="/order" class="auth-button">Go to Order Page</a>
            </div>
        </div>
    </div>

    <script>
        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = '/order';
        }, 3000);
    </script>
</body>
</html>