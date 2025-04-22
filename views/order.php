<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/navbar.php';
require_once __DIR__ . '/layouts/sidebar.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Please log in to place an order';
    header('Location: /login');
    exit;
}
?>

<section class="content">
    <!-- Discount Banner -->
    <div class="discount-banner">
        <div class="banner-content">
            <h2>Get Discount Voucher Up To 20%</h2>
            <p>Use code: <strong>BOBA20</strong> at checkout</p>
            <button class="btn-primary">Get Voucher</button>
        </div>
        <img src="/assets/image/logo/logo.png" alt="Discount 20-50%">
    </div>

    <!-- Menu Categories -->
    <div class="menu-categories">
        <button class="category-btn active" data-category="all">All Drinks</button>
        <button class="category-btn" data-category="milk-tea">Milk Tea</button>
        <button class="category-btn" data-category="fruit-tea">Fruit Tea</button>
        <button class="category-btn" data-category="smoothie">Smoothies</button>
        <button class="category-btn" data-category="coffee">Coffee</button>
        <button class="category-btn" data-category="snack">Snacks</button>
    </div>

    <!-- Order Container -->
    <div class="order-container">
        <div class="product-filters">
            <div class="search-filter">
                <input type="text" id="productSearch" placeholder="Search drinks...">
                <i class="fas fa-search"></i>   
            </div>
        </div>
        <h3>Order Drinks & Snacks</h3>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card" data-category="<?php echo htmlspecialchars($product['category']); ?>">
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                </div>
                <div class="product-actions">
                    <button class="order-btn" data-product-id="<?php echo $product['id']; ?>">Order Now</button>
                </div>
            </div>
            <?php endforeach; ?>
            <div id="no-product-message">No products found matching your criteria.</div>
        </div>
    </div>
</section>

<!-- Product Detail Modal -->
<div id="productDetailModal" class="product-detail-modal">
    <div class="product-detail-content">
        <button class="close-btn">×</button>
        <div class="product-detail-image">
            <img id="detailProductImage" src="/placeholder.svg" alt="Product Image">
        </div>
        <div class="product-detail-info">
            <h3 id="detailProductName">Product Name</h3>
            <p id="detailProductDescription" class="product-detail-desc">Product description goes here.</p>
            <div class="product-detail-price">$<span id="detailProductPrice">0.00</span></div>
            <div class="product-detail-category">
                <span>Category: </span>
                <span id="detailProductCategory">Category</span>
            </div>
            <div class="product-detail-actions">
                <button id="customizeOrderBtn" class="btn-primary">
                    <i class="fas fa-mug-hot"></i> Customize Order
                </button>
                <button id="addToFavoritesBtn" class="btn-outline">
                    <i class="far fa-heart"></i> Add to Favorites
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Order Panel -->
<div id="orderPanel" class="order-panel">
    <div class="order-panel-content">
        <button class="close-btn">×</button>
        <h3>Customize Your Order</h3>
        <div class="product-info">
            <img id="productImage" src="/placeholder.svg" alt="Product Image">
            <h4 id="productName">Product Name</h4>
            <p id="productPrice">$0.00</p>
        </div>
        
        <!-- Quantity Control -->
        <div class="quantity-control">
            <label>Quantity:</label>
            <div class="quantity-control-inner">
                <button class="quantity-btn minus">-</button>
                <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="10">
                <button class="quantity-btn plus">+</button>
            </div>
        </div>
        
        <div class="customize-options" id="customizeOptions">
            <div class="option-group" id="sizeGroup">
                <label>Size:</label>
                <select id="drinkSize">
                    <option value="small" data-price="0">Small-Size</option>
                    <option value="medium" data-price="0.50">Medium-Size (+$0.50)</option>
                    <option value="large" data-price="1.00">Large-Size (+$1.00)</option>
                </select>
            </div>
            <div class="option-group" id="sugarGroup">
                <label>Sugar Level:</label>
                <select id="sugarLevel">
                    <option value="no">No Sugar</option>
                    <option value="25">25% Sugar</option>
                    <option value="50" selected>50% Sugar</option>
                    <option value="75">75% Sugar</option>
                    <option value="100">100% Sugar</option>
                </select>
            </div>
            <div class="option-group" id="iceGroup">
                <label>Ice Level:</label>
                <select id="iceLevel">
                    <option value="no">No Ice</option>
                    <option value="less">Less Ice</option>
                    <option value="normal" selected>Normal Ice</option>
                    <option value="extra">Extra Ice</option>
                </select>
            </div>
            <div class="option-group" id="toppingsGroup">
                <label>Toppings:</label>
                <div id="toppings" class="toppings-grid">
                    <?php foreach ($toppings as $topping): ?>
                    <label class="topping-item">
                        <input type="checkbox" name="topping" value="<?php echo htmlspecialchars($topping['name']); ?>" data-price="<?php echo $topping['price']; ?>">
                        <span><?php echo htmlspecialchars($topping['name']); ?></span>
                        <span class="topping-price">$<?php echo number_format($topping['price'], 2); ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="order-summary">
            <h4>Order Summary</h4>
            <div class="summary-item">
                <span>Base Price:</span>
                <span id="basePrice">$0.00</span>
            </div>
            <div class="summary-item">
                <span>Size:</span>
                <span id="sizePrice">$0.00</span>
            </div>
            <div class="summary-item">
                <span>Toppings:</span>
                <span id="toppingsPrice">$0.00</span>
            </div>
            <div class="summary-item total">
                <span>Total:</span>
                <span id="totalPrice">$0.00</span>
            </div>
        </div>
        <button class="add-to-cart-btn">
            <i class="fas fa-cart-plus"></i> Add to Cart
        </button>
    </div>
</div>

<!-- Cart Panel -->
<div id="cartPanel" class="cart-panel">
    <div class="cart-panel-content">
        <button class="close-btn">×</button>
        <h3>Your Cart</h3>
        <div id="cartItems" class="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-summary">
            <div class="summary-item">
                <span>Subtotal:</span>
                <span id="cartSubtotal">$0.00</span>
            </div>
            <div class="summary-item">
                <span>Tax (8%):</span>
                <span id="cartTax">$0.00</span>
            </div>
            <div class="summary-item total">
                <span>Total:</span>
                <span id="cartTotal">$0.00</span>
            </div>
        </div>
        <div class="cart-actions">
            <button id="clearCartBtn" class="btn-outline">
                <i class="fas fa-trash"></i> Clear Cart
            </button>
            <button id="checkoutBtn" class="btn-primary">
                <i class="fas fa-check"></i> Checkout
            </button>
        </div>
        <!-- Hidden input for user_id -->
        <input type="hidden" id="userId" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
    </div>
</div>

<!-- Notification Panel -->
<div id="notificationPanel" class="notification-panel">
    <div class="notification-header">
        <h3>Notifications</h3>
        <button class="close-btn">×</button>
    </div>
    <div id="notificationList" class="notification-list">
        <div class="empty-notification">
            <i class="fas fa-bell-slash"></i>
            <p>No notifications yet</p>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="overlay"></div>

<!-- Include CSS files -->
<link rel="stylesheet" href="/assets/css/order-panel.css">
<link rel="stylesheet" href="/assets/css/cart.css">
<link rel="stylesheet" href="/assets/css/notification.css">

<!-- Include JavaScript files -->
<script src="/assets/js/cart.js"></script>
<script src="/assets/js/order.js"></script>
<script src="/assets/js/notification.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>