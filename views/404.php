<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - XING FU CHA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 70px);
            text-align: center;
            padding: 40px 20px;
        }
        
        .error-container img {
            width: 200px;
            margin-bottom: 30px;
        }
        
        .error-container h1 {
            font-size: 72px;
            color: #ff5e62;
            margin-bottom: 20px;
        }
        
        .error-container h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .error-container p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            max-width: 600px;
        }
        
        .error-container .buttons {
            display: flex;
            gap: 20px;
        }
        
        .error-container .btn {
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .error-container .btn-primary {
            background: #ff5e62;
            color: white;
            border: none;
        }
        
        .error-container .btn-primary:hover {
            background: #e62e24;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .error-container .btn-secondary {
            background: white;
            color: #333;
            border: 2px solid #ddd;
        }
        
        .error-container .btn-secondary:hover {
            border-color: #ff5e62;
            color: #ff5e62;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php include 'views/partials/header.php'; ?>

    <div class="error-container">
        <img src="/assets/images/logo/logo.png" alt="XING FU CHA Logo">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <div class="buttons">
            <a href="/" class="btn btn-primary">Go to Homepage</a>
            <a href="/menu" class="btn btn-secondary">Browse Menu</a>
        </div>
    </div>

    <script src="/assets/js/app.js"></script>
</body>

</html>

