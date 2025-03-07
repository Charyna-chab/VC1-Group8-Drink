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
            <a href="/orders"><i class="fas fa-shopping-bag"></i> My Orders</a>
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

