<aside class="sidebar">
    <!-- User Profile in Sidebar -->
    <div class="user-profile-sidebar">
        <img src="<?php echo isset($user) ? $user['profile_image'] : '/assets/images/default-user.jpg'; ?>" alt="User Profile">
        <div>
            <h4><?php echo isset($user) ? $user['name'] : 'Guest User'; ?></h4>
            <p><?php echo isset($user) ? $user['membership'] : 'Sign in to order'; ?></p>
        </div>
    </div>
    
    <ul class="nav-list">
        <li><a href="/"><i class="fas fa-mug-hot drink-icon"></i> Order drink</a></li>
        <li><a href="/dashboard"><i class="fas fa-tachometer-alt dashboard-icon"></i> Dashboard</a></li>
        <li>
            <a href="/orders">
                <i class="fas fa-calendar-check booking-icon"></i> Booking
                <span class="badge" id="bookingBadge">0</span>
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
        <li><a href="logout.php"><i class="fas fa-sign-out-alt logout-icon"></i> Logout</a></li>
    </ul>
</aside>
