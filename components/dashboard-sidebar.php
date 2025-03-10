<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
        </div>
        <h2>Dashboard</h2>
    </div>
    
    <div class="user-profile">
        <?php 
        $user = isset($_SESSION['user_id']) ? Database::getInstance()->getUserById($_SESSION['user_id']) : null;
        if ($user): 
        ?>
            <div class="user-avatar">
                <img src="<?php echo $user['profile_image']; ?>" alt="<?php echo $user['name']; ?>">
            </div>
            <div class="user-info">
                <h3><?php echo $user['name']; ?></h3>
                <span class="membership-badge"><?php echo $user['membership']; ?></span>
            </div>
        <?php else: ?>
            <div class="user-avatar">
                <img src="/assets/image/users/default-avatar.png" alt="Guest">
            </div>
            <div class="user-info">
                <h3>Guest</h3>
                <a href="/login" class="login-link">Login</a>
            </div>
        <?php endif; ?>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li class="<?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
                <a href="/dashboard">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php echo $currentPage === 'orders' ? 'active' : ''; ?>">
                <a href="/dashboard/orders">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Orders</span>
                    <?php 
                    if (isset($_SESSION['user_id'])) {
                        $pendingOrders = count(array_filter(Database::getInstance()->getOrdersByUserId($_SESSION['user_id']), function($order) {
                            return $order['status'] === 'pending';
                        }));
                        if ($pendingOrders > 0): 
                    ?>
                        <span class="badge"><?php echo $pendingOrders; ?></span>
                    <?php endif; } ?>
                </a>
            </li>
            <li class="<?php echo $currentPage === 'bookings' ? 'active' : ''; ?>">
                <a href="/dashboard/bookings">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Bookings</span>
                    <?php 
                    if (isset($_SESSION['user_id'])) {
                        $pendingBookings = count(array_filter(Database::getInstance()->getBookingsByUserId($_SESSION['user_id']), function($booking) {
                            return $booking['status'] === 'pending';
                        }));
                        if ($pendingBookings > 0): 
                    ?>
                        <span class="badge"><?php echo $pendingBookings; ?></span>
                    <?php endif; } ?>
                </a>
            </li>
            <li class="<?php echo $currentPage === 'favorites' ? 'active' : ''; ?>">
                <a href="/dashboard/favorites">
                    <i class="fas fa-heart"></i>
                    <span>Favorites</span>
                    <?php 
                    if (isset($_SESSION['user_id'])) {
                        $favoritesCount = count(Database::getInstance()->getFavoritesByUserId($_SESSION['user_id']));
                        if ($favoritesCount > 0): 
                    ?>
                        <span class="badge"><?php echo $favoritesCount; ?></span>
                    <?php endif; } ?>
                </a>
            </li>
            <li class="<?php echo $currentPage === 'feedback' ? 'active' : ''; ?>">
                <a href="/dashboard/feedback">
                    <i class="fas fa-comment-alt"></i>
                    <span>Feedback</span>
                </a>
            </li>
            <li class="<?php echo $currentPage === 'settings' ? 'active' : ''; ?>">
                <a href="/dashboard/settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
            <li>
                <a href="/logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <p>&copy; <?php echo date('Y'); ?> XING FU CHA</p>
    </div>
</div>