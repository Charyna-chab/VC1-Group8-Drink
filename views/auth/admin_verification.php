<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
    <title>Admin Verification - XING FU CHA</title>
    <link rel="icon" type="image/png" href="/assets/image/logo/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .auth-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .auth-header img {
            width: 50px;
            margin-bottom: 8px;
        }
        .auth-header h2 {
            font-size: 18px;
            color: #333;
            margin: 8px 0;
        }
        .code-display {
            margin: 15px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            letter-spacing: 2px;
        }
        .form-group {
            margin: 15px 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .code-input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        .code-input:focus {
            border-color: #ff3e4d;
            box-shadow: 0 0 5px rgba(255, 62, 77, 0.3);
        }
        .code-input:disabled {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }
        .auth-button {
            width: 100%;
            padding: 10px;
            background-color: #ff3e4d;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .auth-button:hover {
            background-color: #e6323f;
        }
        .resend-link {
            display: block;
            margin-top: 10px;
            color: #ff3e4d;
            text-decoration: none;
            font-size: 13px;
        }
        .resend-link:hover {
            text-decoration: underline;
        }
        .auth-error {
            background-color: #ffebee;
            color: #d32f2f;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }
        .auth-error i {
            margin-right: 6px;
        }
        .timer {
            font-size: 13px;
            color: #555;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
            <h2>Admin Verification</h2>
        </div>
        <?php if (isset($error)): ?>
            <div class="auth-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>
        <div class="code-display">
            Verification Code: <strong><?php echo htmlspecialchars($_SESSION['verification_code']); ?></strong>
        </div>
        <div class="timer">Code expires in: <span id="verification-timer">1:00</span></div>
        <form action="/admin-verification" method="post" class="auth-form">
            <div class="form-group">
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" required>
                <input type="hidden" id="verification_code" name="verification_code">
            </div>
            <button type="submit" class="auth-button">Verify</button>
            <a href="/admin-login" class="resend-link">Request New Code</a>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.code-input');
            const hiddenInput = document.getElementById('verification_code');
            const timerElement = document.getElementById('verification-timer');
            let timeLeft = 60; // 1 minute in seconds

            inputs[0].focus();

            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    if (/^[0-9]$/.test(value)) {
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                        updateHiddenInput();
                    } else {
                        e.target.value = '';
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function(e) {
                    if (index === 0) {
                        e.preventDefault();
                        const pasteData = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                        if (pasteData.length <= 6) {
                            for (let i = 0; i < pasteData.length && i < inputs.length; i++) {
                                inputs[i].value = pasteData[i];
                            }
                            const nextFocus = pasteData.length < inputs.length ? pasteData.length : inputs.length - 1;
                            inputs[nextFocus].focus();
                            updateHiddenInput();
                        }
                    }
                });
            });

            function updateHiddenInput() {
                const code = Array.from(inputs).map(input => input.value).join('');
                hiddenInput.value = code;
            }

            document.querySelector('.auth-form').addEventListener('submit', function(e) {
                const code = hiddenInput.value;
                if (code.length !== 6 || !/^[0-9]{6}$/.test(code)) {
                    e.preventDefault();
                    alert('Please enter a valid 6-digit code.');
                }
            });

            const countdownTimer = setInterval(function() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    timerElement.textContent = "Expired";
                    timerElement.style.color = "#d32f2f";
                    inputs.forEach(input => input.disabled = true);
                    setTimeout(() => window.location.href = "/admin-login", 2000);
                }
                timeLeft--;
            }, 1000);
        });
    </script>
</body>
</html>