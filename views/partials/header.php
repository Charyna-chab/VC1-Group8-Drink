<header>
    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
    <div class="logo">XING FU CHA</div>
    <nav>
        <ul>
            <li><a href="#">Gift Card</a></li>
            <li><a href="#">Locations</a></li>
            <li><a href="#">Join The Team</a></li>
            <li><a href="#" id="moreMenuBtn">More</a></li>
        </ul>
    </nav>
    <div class="search-bar">
        <input type="text" placeholder="What do you want to eat today...">
    </div>
    <button class="order-btn">Order Now</button>
    
    <!-- Language Selector -->
    <?php include 'views/partials/language_selector.php'; ?>
    
    <!-- User Profile in Header -->
    <div class="user-profile" id="userProfileBtn">
        <img src="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['avatar'] : '/placeholder.svg?height=40&width=40'; ?>" alt="User Profile">
    </div>
    
    <!-- Notification Icon -->
    <div class="notification-icon" id="notificationBtn">
        <i class="fas fa-bell"></i>
        <span class="notification-badge" id="notificationBadge">0</span>
    </div>
</header>

<!-- More Menu Dropdown -->
<div class="more-menu" id="moreMenu">
    <div class="more-menu-items">
        <a href="/about"><i class="fas fa-info-circle"></i> About Us</a>
        <a href="/contact"><i class="fas fa-envelope"></i> Contact Us</a>
        <a href="/careers"><i class="fas fa-briefcase"></i> Careers</a>
        <a href="/franchise"><i class="fas fa-store"></i> Franchise</a>
        <a href="/blog"><i class="fas fa-blog"></i> Blog</a>
        <a href="/faq"><i class="fas fa-question-circle"></i> FAQ</a>
    </div>
</div>

