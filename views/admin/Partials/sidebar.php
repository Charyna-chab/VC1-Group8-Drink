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
    <li class="nav-item active" style="background: #ff5e62">
        <a class="nav-link" href="/admin-dashboard" style="color: white !important;">
            <i class="fas fa-fw fa-tachometer-alt" style="color: white !important;"></i>
            <span style="color: white !important;">Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Customers -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/admin/users">
            <i class="fa fa-user" aria-hidden="true" style="color: black !important;"></i>
            <span>Customers</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Products -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-folder" style="color: black !important;"></i>
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

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Receipts -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="/receipt">
            <i class="fas fa-receipt" style="color: black !important;"></i>
            <span>Receipts</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Feedback -->
    <li class="nav-item">
        <a class="nav-link" href="/admin/feedback">
            <i class="fas fa-comment-alt feedback-icon" style="color: black !important;"></i>
            <span>Feedback</span></a>
    </li>

    <!-- Nav Item - Order List -->
    <li class="nav-item">
        <a class="nav-link" href="/admin/order-list">
            <i class="fas fa-list order-list-icon" style="color: black !important;"></i>
            <span>Order List</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Settings -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-cogs setting-icon" style="color: black !important;"></i>
            <span>Settings</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="/logout" class="role-switch-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </li>
</ul>