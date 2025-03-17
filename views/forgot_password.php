<?php
// Assuming these variables are set elsewhere in your application
// $error - contains error message if any
// $success - boolean indicating if the reset link was sent successfully
// $csrf_token - CSRF token for form security
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFF5E1;
        }
        .card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }
        .reset-btn {
            background-color: #FFA726;
        }
        .reset-btn:hover {
            background-color: #FB8C00;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="card p-8 space-y-6">
                <!-- Logo -->
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center">
                        <img src="" alt="XINGCHA Logo" class="w-12 h-12">
                    </div>
                </div>
                
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Reset your password
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Enter your email address and we'll send<br>
                        you a link to reset your password
                    </p>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="text-sm text-red-700"><?php echo $error; ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($success) && $success): ?>
                    <div class="space-y-6">
                        <div class="rounded-md bg-green-50 p-4">
                            <div class="text-sm text-green-700">
                                We've sent a password reset link to your email. Please check your inbox.
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="/login" class="text-sm font-medium text-gray-600 hover:text-gray-800">
                                Back to login
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <form method="POST" action="/forgot-password" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="block w-full rounded-md bg-gray-100 border-gray-200 px-4 py-3 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                placeholder="Enter your email"
                            >
                        </div>
                        
                        <div>
                            <button
                                type="submit"
                                class="reset-btn w-full py-3 px-4 text-sm font-medium text-white rounded-md hover:shadow-md transition duration-200"
                            >
                                send reset link
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <a href="/login" class="text-sm font-medium text-gray-600 hover:text-gray-800">
                                Back to login
                            </a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>