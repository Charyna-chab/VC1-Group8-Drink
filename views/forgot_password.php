<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-600">
                    <span class="text-xl font-bold text-white">A</span>
                </div>
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">
                    Reset your password
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Enter your email address and we'll send you a link to reset your password
                </p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="rounded-md bg-red-50 p-4">
                    <div class="text-sm text-red-700"><?php echo $error; ?></div>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="mt-8 space-y-6">
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="text-sm text-green-700">
                            We've sent a password reset link to your email. Please check your inbox.
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="/login" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Return to login
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <form method="POST" action="/forgot-password" class="mt-8 space-y-6">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                                placeholder="admin@example.com"
                            >
                        </div>
                    </div>
                    
                    <div>
                        <button
                            type="submit"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Send reset link
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <a href="/login" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Back to login
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

