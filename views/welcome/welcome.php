
<header>
    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
    <nav>
        <ul>
            <li><a href="/gift-card">Gift Card</a></li>
            <li><a href="/locations">Locations</a></li>
            <li><a href="/join-the-team">Join The Team</a></li>
            <li><a href="#" id="moreMenuBtn">More</a></li>
        </ul>
    </nav>
    <div class="search-bar">
        <input type="text" placeholder="What do you want to eat today...">
    </div>
    <button class="order-search">Order Now</button>
    <div class="language-selector">
        <div class="selected-language">
            <img src="/assets/image/flags/en.png" alt="English" id="currentLanguageFlag">
            <span id="currentLanguage">English</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="language-dropdown">
            <a href="/lang/en" class="language-option" data-lang="en">
                <img src="/assets/image/flags/en.png" alt="English">
                <span>English</span>
            </a>
            <a href="/lang/zh" class="language-option" data-lang="zh">
                <img src="/assets/image/flags/zh.png" alt="Chinese">
                <span>中文</span>
            </a>
            <a href="/lang/es" class="language-option" data-lang="es">
                <img src="/assets/image/flags/es.png" alt="Spanish">
                <span>Español</span>
            </a>
            <a href="/lang/fr" class="language-option" data-lang="fr">
                <img src="/assets/image/flags/fr.png" alt="French">
                <span>Français</span>
            </a>
            <a href="/lang/ja" class="language-option" data-lang="ja">
                <img src="/assets/image/flags/ja.png" alt="Japanese">
                <span>日本語</span>
            </a>
        </div>
    </div>
    <div class="user-profile" id="userProfileBtn">
        <img src="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['avatar'] : '/assets/image/placeholder.svg?height=40&width=40'; ?>" alt="User Profile">
    </div>
    <div class="notification-icon" id="notificationBtn">
        <a href="/"></a><i class="fas fa-bell"></i>
        <span class="notification-badge" id="notificationBadge">0</span>
    </div>
</header>
<section class="content">
    
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1>Welcome to <span class="brand-name">XING FU CHA</span></h1>
            <p>Experience the authentic taste of premium bubble tea and refreshing drinks</p>
            <div class="hero-buttons">
                <button class="btn-primary explore-btn">Explore Menu</button>
                <button class="btn-outline order-now-btn">Order Now</button>
            </div>
        </div>
        <div class="hero-image">
            <img src="/assets/image/hero-bubble-tea.png" alt="Xing Fu Cha Bubble Tea">
        </div>
    </div>


    <!-- Category Section -->
    <div class="category-section">
        <div class="category-list">
            <div class="category-item active" data-category="all">All</div>
            <div class="category-item" data-category="milk-tea">Milk Tea</div>
            <div class="category-item" data-category="fruit-tea">Fruit Tea</div>
            <div class="category-item" data-category="smoothie">Smoothies</div>
            <div class="category-item" data-category="coffee">Coffee</div>
            <div class="category-item" data-category="snacks">Snacks</div>
        </div>
        <div class="search-container">
            <input type="text" id="productSearch" placeholder="Search for your favorite drink...">
            <i class="fas fa-search"></i>
        </div>
    </div>

    <!-- Popular dishes section -->
    <div class="popular-dishes">
        <h3>Popular Drinks & Snacks</h3>
        <div class="dishes-list" id="dishes-container">
            <!-- Product Cards (Dynamic Product List) -->
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/milk-tea-macha.png" alt="Strawberry Smoothie">
                </div>
                <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                <div class="product-info">
                    <h4>Strawberry Smoothie</h4>
                    <p class="description">Delicious strawberry smoothie with a creamy texture.</p>
                    <div class="product-price">$4.99</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="9">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/Almond Puff 55baht.png" alt="Mango Smoothie">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Almond Puff</h4>
                    <p class="description">A refreshing mango smoothie for your hot day.</p>
                    <div class="product-price">$5.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="10">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/image/products/coffee-cream.png" alt="Classic Milk Tea">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Classic Milk Tea</h4>
                    <p class="description">Our signature milk tea with premium black tea and creamy milk.</p>
                    <div class="product-price">$4.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="1">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/image/products/1.png" alt="Taro Milk Tea">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h4>Taro Milk Tea</h4>
                    <p class="description">Creamy taro flavor blended with our premium milk tea.</p>
                    <div class="product-price">$5.00</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="2">Order Now</button>
                </div>
            </div>
            
            <!-- No products found message -->
            <div id="no-product-message" style="display: none;">No products found matching your search.</div>
        </div>
    </div>
</section>

<!-- Login Redirect Modal -->
<div class="modal-overlay" id="loginRedirectModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Login Required</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="login-redirect-content">
                <i class="fas fa-user-lock"></i>
                <p>Please login to continue with your order</p>
                <div class="login-redirect-buttons">
                    <a href="/login" class="btn-primary">Login</a>
                    <a href="/register" class="btn-outline">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div class="modal-overlay" id="orderModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Customize Your Drink</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="product-details">
                <img src="/placeholder.svg?height=100&width=100" alt="" class="modal-product-image">
                <div class="modal-product-info">
                    <h4 class="modal-product-name"></h4>
                    <p class="modal-product-description"></p>
                    <div class="modal-product-price"></div>
                </div>
            </div>
            
            <hr class="modal-divider">
            
            <form id="customizeForm">
                <input type="hidden" name="product_id" id="product_id">
                
                <div class="form-group">
                    <label>Size</label>
                    <div class="option-buttons size-buttons">
                        <label class="option-button">
                            <input type="radio" name="size" value="small" data-price="0">
                            <span>Small</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="medium" data-price="0.50" checked>
                            <span>Medium</span>
                            <small>+$0.50</small>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="large" data-price="1.00">
                            <span>Large</span>
                            <small>+$1.00</small>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Sugar Level</label>
                    <div class="option-buttons sugar-buttons">
                        <label class="option-button">
                            <input type="radio" name="sugar" value="0">
                            <span>0%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="30">
                            <span>30%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="50" checked>
                            <span>50%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="70">
                            <span>70%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="100">
                            <span>100%</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" id="cancelOrder">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div class="toast-container" id="toastContainer"></div>

<script src="/assets/js/welcome.js"></script>

