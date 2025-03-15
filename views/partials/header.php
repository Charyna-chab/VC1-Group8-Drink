<header>
    <img src="./assets/image/logo/logo.png" alt="XING FU CHA Logo">
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

<header class="sticky top-0 z-50 border-b bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6">
        <div class="flex items-center">
            <a href="/admin/dashboard" class="flex items-center">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
                    <span class="text-sm font-bold text-white">A</span>
                </div>
                <span class="ml-2 text-lg font-bold">Admin Portal</span>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex md:items-center md:space-x-4">
            <a href="/admin/dashboard" class="text-sm font-medium <?php echo $path === '/admin/dashboard' ? 'text-blue-600' : 'text-gray-700'; ?>">
                Dashboard
            </a>
            <a href="/admin/users" class="text-sm font-medium <?php echo $path === '/admin/users' ? 'text-blue-600' : 'text-gray-700'; ?>">
                Users
            </a>
            <a href="/admin/settings" class="text-sm font-medium <?php echo $path === '/admin/settings' ? 'text-blue-600' : 'text-gray-700'; ?>">
                Settings
            </a>
        </nav>

        <div class="flex items-center space-x-4">
            <div class="relative">
                <button class="rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <span class="absolute right-1 top-1 flex h-2 w-2 rounded-full bg-red-500"></span>
            </div>

            <div class="relative">
                <button id="userMenuButton" class="flex items-center rounded-full bg-white text-sm focus:outline-none">
                    <span class="sr-only">Open user menu</span>
                    <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center">
                        <span class="text-sm font-bold text-white"><?php echo substr($_SESSION['user_name'] ?? 'A', 0, 1); ?></span>
                    </div>
                </button>
                
                <!-- User dropdown menu -->
                <div id="userMenu" class="absolute right-0 mt-2 hidden w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="/admin/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <div class="border-t border-gray-100"></div>
                    <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log out</a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobileMenuButton" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="/admin/dashboard" class="block rounded-md px-3 py-2 text-base font-medium <?php echo $path === '/admin/dashboard' ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                Dashboard
            </a>
            <a href="/admin/users" class="block rounded-md px-3 py-2 text-base font-medium <?php echo $path === '/admin/users' ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                Users
            </a>
            <a href="/admin/settings" class="block rounded-md px-3 py-2 text-base font-medium <?php echo $path === '/admin/settings' ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'; ?>">
                Settings
            </a>
            <a href="/logout" class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                Log out
            </a>
        </div>
    </div>
</header>

<script>
    // Toggle user menu
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');
    
    userMenuButton?.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });
    
    // Close user menu when clicking outside
    document.addEventListener('click', (event) => {
        if (!userMenuButton?.contains(event.target) && !userMenu?.contains(event.target)) {
            userMenu?.classList.add('hidden');
        }
    });
    
    // Toggle mobile menu
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    
    mobileMenuButton?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

