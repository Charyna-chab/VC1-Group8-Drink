<div class="section-sidebar">
<aside class="sidebar">
    <div class="children-sidebar">
        <!-- User logo in Sidebar -->
        <div class="branch-order-sidebar">
            <img src="<?php echo isset($branchLogo) ? $branchLogo : '/assets/image/logo/logo.png'; ?>" alt="Branch Logo" class="branch-logo">
        </div>

        <ul class="nav-list">
            <li><a href="/order"><i class="fas fa-mug-hot drink-icon"></i> Order drink</a></li>
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

        <!-- Logout & User/Admin Section -->
        <ul class="nav-list">
            <hr>
            <li><a href="/logout"><i class="fas fa-sign-out-alt logout-icon"></i> Logout</a></li>
            <hr>
            <li><a href="/admin"><i class="fas fa-user-shield"></i> Admin</a></li>
        </ul>
    </div>
</aside>

</div>

