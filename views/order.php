<!-- filepath: c:\Users\Bopha.Khat\Desktop\VC1-Group8-Drink\views\order.php -->
<div id="orderPanel" class="order-panel">
    <div class="order-panel-content">
        <button class="close-btn">&times;</button>
        <h3>Customize Your Order</h3>
        <div class="product-info">
            <img id="productImage" src="/placeholder.svg" alt="Product Image">
            <h4 id="productName">Product Name</h4>
            <p id="productPrice">$0.00</p>
        </div>
        
        <!-- Customer Details Form -->
        <div class="customer-details">
            <h4>Customer Details</h4>
            <label for="customerPhone">Phone Number:</label>
            <input type="text" id="customerPhone" placeholder="Enter your phone number" required>
            
            <label for="customerId">Customer ID:</label>
            <input type="text" id="customerId" placeholder="Enter your customer ID" required>
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
        
        <div class="customize-options">
            <div class="option-group">
                <label>Size:</label>
                <select id="drinkSize">
                    <option value="small" data-price="0">Small-Size</option>
                    <option value="medium" data-price="0.50">Medium-Size (+$0.50)</option>
                    <option value="large" data-price="1.00">Large-Size (+$1.00)</option>
                </select>
            </div>
            <div class="option-group">
                <label>Sugar Level:</label>
                <select id="sugarLevel">
                    <option value="no">No Sugar</option>
                    <option value="25">25% Sugar</option>
                    <option value="50" selected>50% Sugar</option>
                    <option value="75">75% Sugar</option>
                    <option value="100">100% Sugar</option>
                </select>
            </div>
            <div class="option-group">
                <label>Ice Level:</label>
                <select id="iceLevel">
                    <option value="no">No Ice</option>
                    <option value="less">Less Ice</option>
                    <option value="normal" selected>Normal Ice</option>
                    <option value="extra">Extra Ice</option>
                </select>
            </div>
            <div class="option-group">
                <label>Toppings:</label>
                <div id="toppings" class="toppings-grid">
                    <?php foreach ($toppings as $topping): ?>
                    <label class="topping-item">
                        <input type="checkbox" name="topping" value="<?php echo $topping['name']; ?>" data-price="<?php echo $topping['price']; ?>">
                        <span><?php echo $topping['name']; ?></span>
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