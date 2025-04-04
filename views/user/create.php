<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Admin Dashboard - XING FU CHA'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar styling */
        #accordionSidebar {
            width: 250px;
            min-height: 100vh;
            background: white;
            transition: all 0.3s;
            position: fixed;
            z-index: 1000;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .sidebar-brand-text {
            font-size: 1.2rem;
            font-weight: 800;
        }

        .sidebar-divider {
            margin: 10px 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .nav-item {
            margin: 5px 0;
        }

        .nav-link {
            padding: 10px 15px;
            color: #333;
            border-radius: 5px;
            margin: 0 10px;
        }

        .nav-link:hover {
            background-color: #f8f9fa;
        }

        .nav-link.active {
            background-color: #4e73df;
            color: white !important;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main content styling */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
            transition: all 0.3s;
        }

        /* Card styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 10px 10px 0 0 !important;
        }

        /* Table styling */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom-width: 1px;
            font-weight: 600;
            color: #4e73df;
            vertical-align: middle;
        }

        .table td,
        .table th {
            padding: 12px 15px;
            vertical-align: middle;
        }



        /* Button styling */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #3a5bc7;
            border-color: #3a5bc7;
        }

        /* Search input styling */
        .input-group {
            width: 250px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #accordionSidebar {
                margin-left: -250px;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .input-group {
                width: 100% !important;
                margin-top: 10px;
            }

            #accordionSidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon rotate-n-15">
        <img src="/placeholder.svg" alt="">
    </div>
    <div class="sidebar-brand-text mx-3 text-dark">XING FU CHA</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="/admin-dashboard">
        <i class="fas fa-fw fa-tachometer-alt text-dark"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Customers -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/admin/users">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span>Customers</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Products -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/admin/products">
        <i class="fas fa-fw fa-folder"></i>
        <span>Products</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Receipts -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/admin/receipts">
        <i class="fas fa-receipt"></i>
        <span>Receipts</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Feedback -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-comment-alt feedback-icon"></i>
        <span>Feedback</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Settings -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-cogs setting-icon"></i>
        <span>Settings</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a href="/logout" class="role-switch-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</li>
</ul>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="/admin/users/store" method="POST" enctype="multipart/form-data" class="border border-2 rounded p-4 shadow-sm bg-white">
                    <h3 class="mb-4 text-center text-primary">User Information</h3>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Address</label>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Enter your address" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="" selected disabled>Select your role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Profile Picture</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>