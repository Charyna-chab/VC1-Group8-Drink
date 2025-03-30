<div class="section-sidebar">
<aside class="sidebar">
    <div class="children-sidebar">
        <!-- User logo in Sidebar -->
        <div class="branch-order-sidebar">
            <img src="<?php echo isset($branchLogo) ? $branchLogo : '/assets/image/logo/logo.png'; ?>" alt="Branch Logo" class="branch-logo">
            
            <!-- Display user role -->
            <div class="user-role-display">
                <?php if (isset($user_role)) : ?>
                    <span class="role-badge <?php echo $user_role; ?>">
                        <?php echo ucfirst($user_role); ?>
                    </span>
                <?php endif; ?>
            </div>
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
        <ul class="nav-list logout-section">
            <hr>
            <li class="logout-container">
                <a href="#" class="logout-trigger">
                    <i class="fas fa-sign-out-alt logout-icon"></i> Logout
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
                <div class="logout-dropdown">
                    <div class="logout-header">
                        <span>Account Options</span>
                    </div>
                    <a href="/admin-login" class="logout-option admin-login-option">
                        <i class="fas fa-user-shield admin-icon"></i> Login as Admin
                    </a>
                    <a href="/login" class="logout-option user-login-option">
                        <i class="fas fa-user user-icon"></i> Login as User
                    </a>
                    <div class="logout-divider"></div>
                    <a href="/logout" class="logout-option logout-now">
                        <i class="fas fa-sign-out-alt logout-icon"></i> Logout Now
                    </a>
                </div>
            </li>
            <hr>
        </ul>
    </div>
</aside>
</div>

<style>
    /* Sidebar Styles */
    .sidebar {
        width: 260px;
        height: 100vh;
        background-color: #fff;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 200;
        transition: transform 0.3s ease-in-out;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        padding-top: 15px;
    }

    .children-sidebar {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 20px;
    }

    .branch-order-sidebar {
        text-align: center;
        margin-bottom: 25px;
    }

    .branch-logo {
        width: 110px;
        height: auto;
        border-radius: 10px;
    }

    /* Navigation List */
    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-list li {
        margin-bottom: 12px;
    }

    .nav-list li a {
        display: flex;
        align-items: center;
        padding: 12px 18px;
        border-radius: 8px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .nav-list li a:hover {
        background-color: rgba(255, 94, 98, 0.1);
        color: #ff5e62;
        transform: translateX(5px);
    }

    .nav-list li a i {
        margin-right: 12px;
        font-size: 18px;
        width: 22px;
        text-align: center;
    }

    /* Sidebar Icons */
    .drink-icon {
        color: #ff9800;
    }

    .booking-icon {
        color: #4caf50;
    }

    .favorite-icon {
        color: #f44336;
    }

    .feedback-icon {
        color: #2196f3;
    }

    .setting-icon {
        color: #607d8b;
    }

    .logout-icon {
        color: #f44336;
    }

    /* Notification Badge */
    .badge {
        background-color: #ff5e62;
        color: white;
        font-size: 10px;
        font-weight: 600;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: auto;
    }

    /* Upgrade Box */
    .upgrade-box {
        background: linear-gradient(135deg, #ff9a9e 0%, #ff5e62 100%);
        border-radius: 10px;
        padding: 16px;
        color: white;
        margin-bottom: 20px;
        text-align: center;
    }

    .upgrade-box p {
        margin: 0 0 12px;
        font-size: 14px;
    }

    .upgrade-box button {
        background-color: white;
        color: #ff5e62;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upgrade-box button:hover {
        background-color: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Separator Line */
    hr {
        border: none;
        border-top: 1px solid #eee;
        margin: 15px 0;
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
    
    /* Role badge styling */
    .user-role-display {
        text-align: center;
        margin-top: 10px;
    }
    
    .role-badge {
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        animation: pulse 2s infinite;
    }
    
    .role-badge.admin {
        background-color: #dc3545;
        color: white;
    }
    
    .role-badge.user {
        background-color: rgb(0, 0, 0);
        color: white;
    }
    
    /* Logout section styling */
    .logout-section {
        margin-top: auto;
        position: relative;
        bottom: 100px;

    }
    
    .logout-container {
        position: relative;
    }
    
    .logout-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .logout-trigger:hover {
        transform: translateX(5px);
    }
    
    .dropdown-arrow {
        font-size: 12px;
        transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    }
    
    .logout-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 100;
        padding: 0;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease, opacity 0.2s ease;
        overflow: hidden;
    }
    
    .logout-container.active .logout-dropdown {
        display: block;
        opacity: 1;
        transform: translateY(5px);
        animation: dropdownSlide 0.4s forwards;
    }
    
    .logout-container.active .dropdown-arrow {
        transform: rotate(180deg);
    }
    
    .logout-header {
        padding: 10px;
        font-weight: bold;
        border-bottom: 1px solid #eee;
        color: #555;
        background-color: #f8f9fa;
        text-align: center;
    }
    
    .logout-option {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f1f1;
    }
    
    .logout-option:last-child {
        border-bottom: none;
    }
    
    .logout-option:hover {
        background: #f5f5f5;
        padding-left: 20px;
    }
    
    .logout-option i {
        margin-right: 10px;
        font-size: 16px;
        width: 20px;
        text-align: center;
    }
    
    .admin-icon {
        color: #dc3545;
    }
    
    .user-icon {
        color: #000;
    }
    
    .logout-divider {
        height: 1px;
        background-color: #eee;
        margin: 5px 0;
    }
    
    .logout-now {
        background-color: #f8f9fa;
        font-weight: 500;
    }
    
    .logout-now:hover {
        background-color: #dc3545;
        color: white;
    }
    
    .logout-now:hover i {
        color: white;
    }
    
    /* Animations */
    @keyframes dropdownSlide {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(5px);
        }
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(220, 53, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle logout dropdown
    const logoutTrigger = document.querySelector('.logout-trigger');
    const logoutContainer = document.querySelector('.logout-container');
    
    logoutTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        logoutContainer.classList.toggle('active');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.logout-container')) {
            logoutContainer.classList.remove('active');
        }
    });
    
    // Add hover effects for menu items
    const logoutOptions = document.querySelectorAll('.logout-option');
    logoutOptions.forEach(option => {
        option.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.2s ease';
        });
        option.addEventListener('mouseleave', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });
});
</script>

