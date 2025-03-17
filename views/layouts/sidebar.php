<main class="main-content">
<aside class="sidebar">
    <!-- User logo in Sidebar -->
    <div class="branch-order-sidebar">
        <img src="<?php echo isset($branchLogo) ? $branchLogo : '/assets/image/logo/logo.png'; ?>" alt="Branch Logo" class="branch-logo">
    </div>

    <ul class="nav-list">
        <li><a href="/order"><i class="fas fa-mug-hot drink-icon"></i> Order drink</a></li>
        <li><a href=""><i class="fas fa-tachometer-alt dashboard-icon"></i> Dashboard</a></li>
        <li>
            <a href="/booking">
                <i class="fas fa-calendar-check booking-icon"></i> Booking
                <span class="badge booking-badge" id="bookingBadge">0</span>
            </a>
        </li>
        <li><a href="/favorites"><i class="fas fa-heart favorite-icon"></i> Favorite</a></li>
        <li><a href="/feedback"><i class="fas fa-comment-alt feedback-icon"></i> Feedback</a></li>
        <li><a href="/settings"><i class="fas fa-cogs setting-icon"></i> Setting</a></li>
    </ul>

    <div class="upgrade-box">
        <p>Upgrade your Account to Get Free Voucher</p>
        <button>Upgrade</button>
    </div>

    <!-- Logout Option -->
    <ul class="nav-list">
        <hr>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt logout-icon"></i> Logout</a></li>
    </ul>
</aside>
<div class="user-menu" id="userMenu">
    <div class="user-menu-header">
        <img src="/placeholder.svg?height=60&width=60" alt="User Profile">
        <div>
            <h4><?php echo isset($_SESSION['user']) ? $_SESSION['user']['name'] : 'Guest'; ?></h4>
            <p><?php echo isset($_SESSION['user']) ? $_SESSION['user']['email'] : 'Not logged in'; ?></p>
        </div>
    </div>
    <div class="user-menu-items">
        <?php if(isset($_SESSION['user'])): ?>
            <a href="/profile"><i class="fas fa-user"></i> My Profile</a>
            <a href="/booking"><i class="fas fa-shopping-bag"></i> My Orders</a>
            <a href="/favorites"><i class="fas fa-heart"></i> Favorites</a>
            <a href="/settings"><i class="fas fa-cog"></i> Settings</a>
            <div class="divider"></div>
            <a href="/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php else: ?>
            <a href="/login" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="/register" class="register-btn"><i class="fas fa-user-plus"></i> Register</a>
        <?php endif; ?>
    </div>
</div>