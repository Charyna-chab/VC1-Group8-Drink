<?php
// views/order.php
require_once __DIR__ . '/../views/layouts/header.php';
require_once __DIR__ . '/../views/layouts/sidebar.php';
?>

<section class="content">

    <!-- Discount banner -->
    <div class="discount-banner">
        <div class="banner-content">
            <h2>Get Discount Voucher Up To 20%</h2>
            <p>Use code: <strong>BOBA20</strong> at checkout</p>
            <button class="btn-primary">Get Voucher</button>
        </div>
        <img src="/assets/images/discount-banner.png" alt="Discount 20-50%">
    </div>
    
    <!-- Menu categories -->
    <div class="menu-categories">
        <button class="category-btn active" data-category="all">All Drinks</button>
        <button class="category-btn" data-category="milk-tea">Milk Tea</button>
        <button class="category-btn" data-category="fruit-tea">Fruit Tea</button>
        <button class="category-btn" data-category="smoothie">Smoothies</button>
        <button class="category-btn" data-category="coffee">Coffee</button>
        <button class="category-btn" data-category="snacks">Snacks</button>
    </div>
    
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
            <div class="product-card" data-category="<?php echo $product['category']; ?>">
                <div class="product-image">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <button class="favorite-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="product-info">
                    <h3><?php echo $product['name']; ?></h3>
                    <p><?php echo $product['description']; ?></p>
                    <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="<?php echo $product['id']; ?>">Order Now</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

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
            <label for="size">Size</label>
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

        <div class="form-group">
            <label>Ice Level</label>
            <div class="option-buttons ice-buttons">
                <label class="option-button">
                    <input type="radio" name="ice" value="0">
                    <span>No Ice</span>
                </label>
                <label class="option-button">
                    <input type="radio" name="ice" value="30">
                    <span>Less Ice</span>
                </label>
                <label class="option-button">
                    <input type="radio" name="ice" value="100" checked>
                    <span>Regular Ice</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="toppings">Toppings <span class="optional">(Optional, +$0.75 each)</span></label>
            <div class="toppings-grid">
                <?php foreach ($toppings as $topping): ?>
                <label class="topping-option">
                    <input type="checkbox" name="toppings[]" value="<?php echo $topping['id']; ?>" data-price="<?php echo $topping['price']; ?>">
                    <span><?php echo $topping['name']; ?></span>
                    <small>+$<?php echo number_format($topping['price'], 2); ?></small>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="instructions">Special Instructions <span class="optional">(Optional)</span></label>
            <textarea name="instructions" id="instructions" placeholder="Any special requests?"></textarea>
        </div>
        <div class="quantity-control">
            <label for="quantity">Quantity</label>
            <div class="quantity-buttons">
                <button type="button" class="quantity-btn minus-btn">
                    <i class="fas fa-minus"></i>
                </button>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                <button type="button" class="quantity-btn plus-btn">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="total-price">
            <span>Total:</span>
            <span class="price-value">$0.00</span>
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
<!-- Notification Toast -->
<div class="toast-container" id="toastContainer"></div>

</section>

<script src="/assets/js/order.js"></script>
