<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<section class="content">
    <div class="page-header">
        <a href="/order" class="back-link"><i class="fas fa-arrow-left"></i> Back to Menu</a>
        <h2><?php echo $product['name']; ?></h2>
    </div>
    
    <div class="product-details-container">
        <div class="product-details-card">
            <div class="product-details-image">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            
            <div class="product-details-info">
                <h3><?php echo $product['name']; ?></h3>
                <p class="product-description"><?php echo $product['description']; ?></p>
                <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                
                <form id="orderForm" class="order-form">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <div class="form-group">
                        <label>Size</label>
                        <div class="size-options">
                            <label class="size-option">
                                <input type="radio" name="size" value="small" data-price="0">
                                <span class="size-label">Small</span>
                            </label>
                            <label class="size-option">
                                <input type="radio" name="size" value="medium" data-price="0.50" checked>
                                <span class="size-label">Medium</span>
                                <span class="size-price">+$0.50</span>
                            </label>
                            <label class="size-option">
                                <input type="radio" name="size" value="large" data-price="1.00">
                                <span class="size-label">Large</span>
                                <span class="size-price">+$1.00</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Sugar Level</label>
                        <div class="sugar-options">
                            <label class="sugar-option">
                                <input type="radio" name="sugar" value="0">
                                <span class="sugar-label">0%</span>
                            </label>
                            <label class="sugar-option">
                                <input type="radio" name="sugar" value="30">
                                <span class="sugar-label">30%</span>
                            </label>
                            <label class="sugar-option">
                                <input type="radio" name="sugar" value="50" checked>
                                <span class="sugar-label">50%</span>
                            </label>
                            <label class="sugar-option">
                                <input type="radio" name="sugar" value="70">
                                <span class="sugar-label">70%</span>
                            </label>
                            <label class="sugar-option">
                                <input type="radio" name="sugar" value="100">
                                <span class="sugar-label">100%</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Ice Level</label>
                        <div class="ice-options">
                            <label class="ice-option">
                                <input type="radio" name="ice" value="0">
                                <span class="ice-label">No Ice</span>
                            </label>
                            <label class="ice-option">
                                <input type="radio" name="ice" value="30">
                                <span class="ice-label">Less Ice</span>
                            </label>
                            <label class="ice-option">
                                <input type="radio" name="ice" value="100" checked>
                                <span class="ice-label">Regular Ice</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Toppings <span class="optional">(Optional)</span></label>
                        <div class="toppings-options">
                            <?php foreach ($toppings as $topping): ?>
                            <label class="topping-option">
                                <input type="checkbox" name="toppings[]" value="<?php echo $topping['id']; ?>" data-price="<?php echo $topping['price']; ?>">
                                <span class="topping-label"><?php echo $topping['name']; ?></span>
                                <span class="topping-price">+$<?php echo number_format($topping['price'], 2); ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Special Instructions <span class="optional">(Optional)</span></label>
                        <textarea name="instructions" placeholder="Any special requests?"></textarea>
                    </div>
                    
                    <div class="quantity-selector">
                        <label>Quantity</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn minus-btn">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" value="1" min="1" max="10">
                            <button type="button" class="quantity-btn plus-btn">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="total-price">
                        <span class="total-label">Total:</span>
                        <span class="total-value">$<?php echo number_format($product['price'] + 0.50, 2); ?></span>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</main>