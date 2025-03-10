<aside class="sidebar">
    <div class="user-profile-sidebar">
        <img src="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['avatar'] : '/assets/image/logo/logo.png'; ?>" alt="User Profile">
    </div>
    
    <ul class="nav-list">
        <li>
            <a href="/">
                <i class="fas fa-home dashboard-icon"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="/menu">
                <i class="fas fa-mug-hot drink-icon"></i>
                <span>Our Menu</span>
            </a>
        </li>
        <li>
            <a href="/orders">
                <i class="fas fa-shopping-bag booking-icon"></i>
                <span>My Orders</span>
                <div class="badge" id="bookingBadge">0</div>
            </a>
        </li>
        <li>
            <a href="/favorites">
                <i class="fas fa-heart favorite-icon"></i>
                <span>Favorites</span>
            </a>
        </li>
        <li>
            <a href="/feedback">
                <i class="fas fa-comment-alt feedback-icon"></i>
                <span>Feedback</span>
            </a>
        </li>
        <li>
            <a href="/settings">
                <i class="fas fa-cog setting-icon"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>
    
    <div class="upgrade-box">
        <p>Upgrade to Premium for exclusive discounts and rewards!</p>
        <button>Upgrade Now</button>
    </div>
</aside>

