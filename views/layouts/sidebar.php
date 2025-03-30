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
        <ul class="nav-list">
            <hr>
            <li class="logout-container">
                <a href="#" class="logout-trigger">
                    <i class="fas fa-sign-out-alt logout-icon"></i> Logout
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
                <div class="logout-dropdown">
                    <div class="logout-header">
                        <span>Switch Account Type</span>
                    </div>
                    <a href="/logout?type=admin" class="logout-option admin-option">
                        <i class="fas fa-user-shield"></i> Logout as Admin
                        <?php if (isset($user_role) && $user_role === 'admin') : ?>
                            <span class="current-role-badge">Current</span>
                        <?php endif; ?>
                    </a>
                    <a href="/logout?type=user" class="logout-option user-option">
                        <i class="fas fa-user"></i> Logout as User
                        <?php if (isset($user_role) && $user_role === 'user') : ?>
                            <span class="current-role-badge">Current</span>
                        <?php endif; ?>
                    </a>
                    <div class="logout-confirm">
                        <span>Are you sure?</span>
                        <div class="logout-buttons">
                            <a href="/logout" class="confirm-logout">Yes, Logout</a>
                            <button class="cancel-logout">Cancel</button>
                        </div>
                    </div>
                </div>
            </li>
            <hr>
            <!-- Show Admin section only if the user has an admin role -->
            <?php if (isset($user_role) && $user_role === 'admin') : ?>
                <li><a href="/admin"><i class="fas fa-user-shield admin-icon"></i> Admin Panel</a></li>
                <li><a href="/admin/users"><i class="fas fa-users"></i> Manage Users</a></li>
                <li><a href="/admin/reports"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <?php else : ?>
                <li><a href="/user"><i class="fas fa-user user-icon"></i> User Profile</a></li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
</div>

<style>
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
    
    /* Logout dropdown styling */
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
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 100;
        padding: 10px;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease, opacity 0.2s ease;
    }
    
    .logout-container.active .logout-dropdown {
        display: block;
        opacity: 1;
        transform: translateY(0);
        animation: dropdownSlide 0.4s forwards;
    }
    
    .logout-container.active .dropdown-arrow {
        transform: rotate(180deg);
    }
    
    .logout-header {
        padding: 5px 0;
        font-weight: bold;
        border-bottom: 1px solid #eee;
        margin-bottom: 5px;
        color: #555;
    }
    
    .logout-option {
        display: block;
        padding: 8px 10px;
        margin: 5px 0;
        border-radius: 4px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        transform-origin: left center;
    }
    
    .logout-option:hover {
        background: #f5f5f5;
        transform: scale(1.02);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .admin-option {
        color: #dc3545;
    }
    
    .user-option {
        color: #000;
    }
    
    .current-role-badge {
        float: right;
        background: #28a745;
        color: white;
        padding: 2px 5px;
        border-radius: 3px;
        font-size: 10px;
        animation: bounce 1s infinite alternate;
    }
    
    .logout-confirm {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
        text-align: center;
        animation: fadeIn 0.5s ease;
    }
    
    .logout-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 8px;
        gap: 5px;
    }
    
    .confirm-logout {
        background: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s ease;
        flex: 1;
    }
    
    .confirm-logout:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
    }
    
    .cancel-logout {
        background: #6c757d;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
        flex: 1;
    }
    
    .cancel-logout:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(108, 117, 125, 0.3);
    }
    
    /* Admin/user icons */
    .admin-icon {
        color: #dc3545;
    }
    
    .user-icon {
        color: rgb(0, 0, 0);
    }
    
    /* Animations */
    @keyframes dropdownSlide {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
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
    
    @keyframes bounce {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-3px);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
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
    
    // Cancel button functionality
    const cancelBtn = document.querySelector('.cancel-logout');
    cancelBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        logoutContainer.classList.remove('active');
    });
    
    // Smooth hover effects
    const logoutOptions = document.querySelectorAll('.logout-option');
    logoutOptions.forEach(option => {
        option.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });
        option.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>