<?php
// views/order_details.php
require_once __DIR__ . '/../views/layouts/header.php';
require_once __DIR__ . '/../views/layouts/sidebar.php';
?>

<section class="content">
    <div class="product-details-container">
        <div class="product-details-header">
            <a href="/order" class="back-link"><i class="fas fa-arrow-left"></i> Back to Menu</a>
            <h2>Customize Your Drink</h2>
        </div>
        
        <div class="product-details-content">
            <div class="product-details-image">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            
            <div class="product-details-info">
                <h3><?php echo $product['name']; ?></h3>
                <p class="product-description"><?php echo $product['description']; ?></p>
                <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                
                <form id="customizeForm" action="/order/add-to-cart" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <div class="form-group">
                        <label>Size:</label>
                        <div class="option-buttons">
                            <label class="option-button">
                                <input type="radio" name="size" value="small" data-price="0" checked>
                                <span>Small</span>
                                <small>Regular size</small>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="size" value="medium" data-price="0.50">
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
                        <label>Sugar Level:</label>
                        <div class="option-buttons">
                            <label class="option-button">
                                <input type="radio" name="sugar" value="0" checked>
                                <span>0%</span>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="sugar" value="25">
                                <span>25%</span>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="sugar" value="50">
                                <span>50%</span>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="sugar" value="75">
                                <span>75%</span>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="sugar" value="100">
                                <span>100%</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Ice Level:</label>
                        <div class="option-buttons">
                            <label class="option-button">
                                <input type="radio" name="ice" value="0" checked>
                                <span>No Ice</span>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="ice" value="30">
                                <span>Less Ice</span>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="ice" value="70">
                                <span>Normal</span>
                            </label>
                            <label class="option-button">
                                <input type="radio" name="ice" value="100">
                                <span>Extra Ice</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Toppings: <span class="optional">(Optional)</span></label>
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
                    
                    <hr class="modal-divider">
                    
                    <div class="form-group">
                        <label>Special Instructions: <span class="optional">(Optional)</span></label>
                        <textarea name="instructions" placeholder="Any special requests for your drink..."></textarea>
                    </div>
                    
                    <div class="quantity-control">
                        <label>Quantity:</label>
                        <div class="quantity-buttons">
                            <button type="button" class="quantity-btn minus-btn"><i class="fas fa-minus"></i></button>
                            <input type="number" name="quantity" value="1" min="1" max="10">
                            <button type="button" class="quantity-btn plus-btn"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    
                    <div class="total-price">
                        <span>Total:</span>
                        <span class="price-value">$<?php echo number_format($product['price'], 2); ?></span>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" id="cancelOrder" class="btn-secondary"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn-primary"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script src="/assets/js/order_details.js"></script>

