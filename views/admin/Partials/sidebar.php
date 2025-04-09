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

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $currentPage == 'admin-dashboard' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin-dashboard">
            <i class="fas fa-fw fa-tachometer-alt text-dark"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Customers -->
    <li class="nav-item <?= $currentPage == 'users' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin/users">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Customers</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Products -->
    <li class="nav-item <?= $currentPage == 'product' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/product">
            <i class="fas fa-fw fa-folder"></i>
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
    <li class="nav-item <?= $currentPage == 'receipt' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/receipt">
            <i class="fas fa-receipt"></i>
            <span>Receipts</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Feedback -->
    <li class="nav-item <?= $currentPage == 'feedback' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin/feedback">
            <i class="fas fa-comment-alt feedback-icon"></i>
            <span>Feedback</span>
        </a>
    </li>

    <!-- Nav Item - Order List -->
    <li class="nav-item <?= $currentPage == 'order-list' ? 'active-page' : '' ?>">
        <a class="nav-link" href="/admin/orders">
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
