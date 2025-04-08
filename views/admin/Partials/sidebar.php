<?php
$currentPage = basename($_SERVER['REQUEST_URI']);
?>

<ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="/placeholder.svg" alt="">
        </div>
        <div class="sidebar-brand-text mx-3 text-dark">XING FU CHA</div>
    </a>
<<<<<<< HEAD
    
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active" style="background: #ff5e62">
        <a class="nav-link" href="/admin-dashboard" style="color: white !important;">
            <i class="fas fa-fw fa-tachometer-alt" style="color: white !important;"></i>
            <span style="color: white !important;">Dashboard</span>
=======

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $currentPage == 'admin-dashboard' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin-dashboard">
            <i class="fas fa-fw fa-tachometer-alt text-dark"></i>
            <span>Dashboard</span>
>>>>>>> fe0c7aa96ac9744f359c6247f37e9be1060f6d1c
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Customers -->
<<<<<<< HEAD
    <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/users">
            <i class="fa fa-user" aria-hidden="true" style="color: black !important;"></i>
=======
    <li class="nav-item <?= $currentPage == 'users' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin/users">
            <i class="fa fa-user" aria-hidden="true"></i>
>>>>>>> fe0c7aa96ac9744f359c6247f37e9be1060f6d1c
            <span>Customers</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Products -->
<<<<<<< HEAD
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-folder" style="color: black !important;"></i>
=======
    <li class="nav-item <?= $currentPage == 'product' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/product">
            <i class="fas fa-fw fa-folder"></i>
>>>>>>> fe0c7aa96ac9744f359c6247f37e9be1060f6d1c
            <span>Products</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/product">Products</a>
                <a class="collapse-item" href="/topping">Toppings</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="/order">
            <i class="fas fa-shopping-cart" style="color: black !important;"></i>
            <span>Orders</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Receipts -->
<<<<<<< HEAD
    <li class="nav-item">
        <a class="nav-link collapsed" href="/receipt">
            <i class="fas fa-receipt" style="color: black !important;"></i>
=======
    <li class="nav-item <?= $currentPage == 'receipt' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/receipt">
            <i class="fas fa-receipt"></i>
>>>>>>> fe0c7aa96ac9744f359c6247f37e9be1060f6d1c
            <span>Receipts</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Feedback -->
    <li class="nav-item <?= $currentPage == 'feedback' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin/feedback">
<<<<<<< HEAD
            <i class="fas fa-comment-alt feedback-icon" style="color: black !important;"></i>
            <span>Feedback</span></a>
=======
            <i class="fas fa-comment-alt feedback-icon"></i>
            <span>Feedback</span>
        </a>
>>>>>>> fe0c7aa96ac9744f359c6247f37e9be1060f6d1c
    </li>

    <!-- Nav Item - Order List -->
    <li class="nav-item <?= $currentPage == 'order-list' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin/order-list">
            <i class="fas fa-list order-list-icon" style="color: black !important;"></i>
            <span>Order List</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Settings -->
    <li class="nav-item <?= $currentPage == 'logout' ? 'active-page' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-cogs setting-icon" style="color: black !important;"></i>
            <span>Settings</span>
        </a>
        <div id="collapsePages" class="collapse <?= $currentPage == 'logout' ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="/logout" class="role-switch-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </li>
</ul>
