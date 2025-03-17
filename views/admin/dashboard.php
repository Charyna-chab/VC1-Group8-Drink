<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include 'views/partials/header.php'; ?>
    
    <main class="flex-1 p-6">
        <div class="mx-auto max-w-7xl">
            <h1 class="mb-6 text-3xl font-bold">Admin Dashboard</h1>
            
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-lg border bg-white p-6 shadow-sm">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-medium">Users</h3>
                        <p class="text-sm text-gray-500">Manage user accounts</p>
                        <div class="mt-4 text-3xl font-bold">1,234</div>
                        <p class="text-xs text-gray-500">+12% from last month</p>
                        <a href="/admin/users" class="mt-4 inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-medium text-white" style="background-color: #FFB233; hover:bg-opacity-90;">
                            View Users
                        </a>

                    </div>
                </div>
                
                <div class="rounded-lg border bg-white p-6 shadow-sm">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-medium">Products</h3>
                        <p class="text-sm text-gray-500">Manage product catalog</p>
                        <div class="mt-4 text-3xl font-bold">567</div>
                        <p class="text-xs text-gray-500">+5% from last month</p>
                        <a href="#" class="mt-4 inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-medium text-white" style="background-color: #FFB233; hover:bg-opacity-90;">
                            View Products
                        </a>
                    </div>
                </div>
                
                <div class="rounded-lg border bg-white p-6 shadow-sm">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-medium">Orders</h3>
                        <p class="text-sm text-gray-500">Manage customer orders</p>
                        <div class="mt-4 text-3xl font-bold">892</div>
                        <p class="text-xs text-gray-500">+18% from last month</p>
                        <a href="#" class="mt-4 inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-medium text-white" style="background-color: #FFB233; hover:bg-opacity-90;">
                            View Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'views/partials/footer.php'; ?>
</body>
</html>

