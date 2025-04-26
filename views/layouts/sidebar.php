<?php


// Get cart item count from session
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<div class="section-sidebar">
<aside class="sidebar">
    <div class="children-sidebar">
        <!-- Logo Section -->
        <div class="branch-order-sidebar">
            <img src="<?php echo isset($branchLogo) ? $branchLogo : '/assets/image/logo/logo.png'; ?>" alt="Branch Logo" class="branch-logo">
        </div>

        <!-- Navigation Menu -->
        <ul class="nav-list">
            <li style="margin-bottom: 16px;"><a href="/order"><i class="fas fa-mug-hot" style="color: #ff5e62;"></i> Order drink</a></li>
            <li style="margin-bottom: 16px;"><a href="/booking"><i class="fas fa-calendar-check" style="color: #ff5e62;"></i> Booking</a></li>
            <li style="margin-bottom: 16px;"><a href="/favorites"><i class="fas fa-heart" style="color: #ff5e62;"></i> Favorite</a></li>
            <li style="margin-bottom: 16px;">
                <a href="/checkout">
                    <i class="fas fa-shopping-cart" style="color: #ff5e62;"></i> 
                    Checkout
                    <span class="cart-count-badge" style="<?php echo $cart_count > 0 ? 'display: inline-flex;' : 'display: none;'; ?>">
                        <?php echo $cart_count; ?>
                    </span>
                </a>
            </li>

            <!-- Settings Item with Role Info -->
            <li class="settings-item" style="margin-bottom: 16px;">
                <a href="#" class="settings-trigger">
                    <i class="fas fa-user-cog" style="color: #ff5e62;"></i> Account
                    <i class="fas fa-chevron-down arrow" style="color: #ff5e62;"></i>
                </a>
                <div class="settings-dropdown">
                    <div class="role-info">
                        <p><strong>Access:</strong> 
                            <span class="role-badge <?php echo isset($user_role) ? $user_role : 'guest'; ?>">
                                <?php echo isset($user_role) ? ucfirst($user_role) : 'Guest'; ?>
                            </span>
                        </p>
                        <div class="role-actions">
                            <a href="/logout" class="role-switch-btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            <a href="/admin-login" class="role-switch-btn-admin"><i class="fas fa-user-shield"></i> Admin Login</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <!-- User Greeting Section -->
        <?php if (isset($username)) : ?>
            <div class="user-section">
                <hr>
                <div class="user-container">
                    <p class="user-greeting">Hello, <?php echo htmlspecialchars($username); ?></p>
                    <a href="/logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</aside>
</div>

<style>
    /* Base Sidebar Styles */
    .sidebar {
        width: 250px;
        height: 100vh;
        background: #ffffff;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        padding: 30px 0;
        transition: transform 0.3s ease;
    }

    .children-sidebar {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 0 30px;
    }

    .branch-order-sidebar {
        text-align: center;
        margin-bottom: 55px;
    }

    .sidebar .nav-list a {
        margin-bottom: 20px;
        position: relative;
        bottom: 40px;
    }

    .branch-logo {
        width: 100px;
        height: auto;
        border-radius: 8px;
        transition: transform 0.3s ease;
        position: relative;
        left: 30px;
    }

    .branch-logo:hover {
        transform: scale(1.05);
    }

    /* Navigation List Styles */
    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
    }

    .nav-list li {
        margin-bottom: 16px;
    }

    .nav-list a {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #333333;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-list a:hover {
        background-color: rgba(255, 94, 98, 0.1);
        color: #ff5e62;
        transform: translateX(5px);
    }

    .nav-list a.active {
        background-color: rgba(255, 94, 98, 0.2);
        color: #ff5e62;
        font-weight: 600;
    }

    .nav-list i {
        width: 24px;
        font-size: 16px;
        margin-right: 10px;
        text-align: center;
    }

    /* Cart Count Badge */
    .cart-count-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        background-color: #ff5e62;
        color: white;
        border-radius: 10px;
        font-size: 12px;
        font-weight: bold;
        position: absolute;
        right: 15px;
        padding: 0 6px;
    }

    /* Settings Item Styles */
    .settings-item {
        position: relative;
    }

    .settings-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .settings-trigger .arrow {
        font-size: 12px;
        transition: transform 0.3s ease;
    }

    .settings-dropdown {
        display: none;
        background: #fff5f5;
        border-radius: 0 0 8px 8px;
        margin-top: -8px;
        padding: 15px;
        border: 1px solid #ffd6d6;
        border-top: none;
        animation: fadeIn 0.3s ease;
        position: relative;
        bottom: 40px;
    }

    .settings-item.active .settings-dropdown {
        display: block;
    }

    .settings-item.active .arrow {
        transform: rotate(180deg);
    }

    /* Role Info Styles */
    .role-info {
        font-size: 14px;
    }

    .role-info p {
        margin: 0 0 10px 0;
        display: flex;
        align-items: center;
    }

    .role-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        margin-left: 8px;
    }

    .role-badge.admin {
        background: #ff5e62;
        color: white;
    }

    .role-badge.user {
        background: #ff8a98;
        color: white;
    }

    .role-badge.guest {
        background: #ffb3c1;
        color: white;
    }

    .role-actions {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #ffd6d6;
    }

    .role-actions a {
        display: flex;
        align-items: center;
        color: #ff5e62;
        font-size: 13px;
        text-decoration: none;
        padding: 8px 0;
        transition: all 0.2s;
        margin-bottom: 25px;
    }

    .role-actions a:hover {
        color: #ff2d4d;
        text-decoration: underline;
    }

    .role-actions i {
        margin-right: 8px;
        font-size: 14px;
    }
    .role-switch-btn-logout{
     position: relative;
     top: 0.5px;
    }
    .role-switch-btn-admin{
     position: relative;
     top: 2px;;
    }
    /* User Section Styles */
    .user-section {
        margin-top: auto;
        padding-bottom: 20px;
    }

    .user-greeting {
        margin: 10px 0;
        font-size: 14px;
        color: #555;
        text-align: center;
    }

    /* Logout Button Styles */
    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 10px 15px;
        background-color: #ff5e62;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .logout-btn i {
        margin-right: 8px;
        font-size: 14px;
    }

    .logout-btn:hover {
        background-color: #ff2d4d;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 94, 98, 0.2);
    }

    .logout-btn:active {
        transform: translateY(0);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.active {
            transform: translateX(0);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle settings dropdown
    const settingsTrigger = document.querySelector('.settings-trigger');
    const settingsItem = document.querySelector('.settings-item');
    
    if (settingsTrigger) {
        settingsTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            settingsItem.classList.toggle('active');
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.settings-item')) {
            if (settingsItem) {
                settingsItem.classList.remove('active');
            }
        }
    });

    // Prevent dropdown from closing when clicking inside it
    const settingsDropdown = document.querySelector('.settings-dropdown');
    if (settingsDropdown) {
        settingsDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Handle logout and admin login clicks
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/logout';
        });
    }

    const adminLoginLinks = document.querySelectorAll('a[href="/admin-login"]');
    adminLoginLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/admin-login';
        });
    });

    // Close sidebar on mobile when clicking a link
    const navLinks = document.querySelectorAll('.nav-list a:not(.settings-trigger)');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 992) {
                document.querySelector('.sidebar').classList.remove('active');
            }
        });
    });

    // Set active class based on current URL
    const currentUrl = window.location.pathname.toLowerCase();
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-list a');

    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href').toLowerCase();
        if (currentUrl === href || currentUrl.startsWith(href + '/')) {
            link.classList.add('active');
            link.closest('li').classList.add('active');
        }
    });

    // Ensure checkout is highlighted during checkout
    if (currentUrl.includes('/checkout')) {
        const checkoutLink = document.querySelector('.sidebar .nav-list a[href="/checkout"]');
        if (checkoutLink) {
            checkoutLink.classList.add('active');
            checkoutLink.closest('li').classList.add('active');
        }
    }

    // Initialize cart badge from localStorage
    function updateCartBadge() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const count = cart.length;
        const badge = document.querySelector('.cart-count-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-flex' : 'none';
        }
    }

    // Update badge on cart changes
    document.addEventListener('cartUpdated', updateCartBadge);

    // Initial badge update
    updateCartBadge();
});
</script>