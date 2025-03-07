<div class="booking-panel" id="bookingPanel">
    <button class="close-btn" onclick="closeBookingPanel()">×</button>
    <h3>Customize Your Order</h3>
    <img id="productImage" src="/assets/images/placeholder.jpg" alt="Product">
    <h4 id="productName"></h4>
    <p id="productPrice"></p>
    <hr>

    <label for="drinkSize">Size:</label>
    <select id="drinkSize" onchange="updateTotalPrice()">
        <option value="Small" data-price="0">Small-Size</option>
        <option value="Medium" data-price="0.50">Medium-Size (+$0.50)</option>
        <option value="Large" data-price="1.00">Large-Size (+$1.00)</option>
    </select>

    <label for="sugarLevel">Sugar Level:</label>
    <select id="sugarLevel">
        <option value="No Sugar">No Sugar</option>
        <option value="30%">30% Sugar</option>
        <option value="50%">50% Sugar</option>
        <option value="70%">70% Sugar</option>
        <option value="100%">100% Sugar</option>
    </select>
    <hr>

    <label class="main-label-topping">TOPPING: ($0.85 each)</label>
    <div id="toppings">
        <?php 
        $toppings = Database::getInstance()->getAllToppings();
        foreach ($toppings as $topping): 
        ?>
        <div class="topping-option">
            <label for="topping<?php echo $topping['id']; ?>"><?php echo $topping['name']; ?></label>
            <span class="topping-price">$<?php echo number_format($topping['price'], 2); ?></span>
            <input type="checkbox" id="topping<?php echo $topping['id']; ?>" name="toppings" value="<?php echo $topping['name']; ?>" onchange="updateTotalPrice()">
        </div>
        <?php endforeach; ?>
    </div>

    <div class="order-summary">
        <h4>Order Summary</h4>
        <div class="order-summary-item">
            <span>Base Price:</span>
            <span id="basePrice">$0.00</span>
        </div>
        <div class="order-summary-item">
            <span>Size Upgrade:</span>
            <span id="sizePrice">$0.00</span>
        </div>
        <div class="order-summary-item">
            <span>Toppings:</span>
            <span id="toppingsPrice">$0.00</span>
        </div>
        <div class="order-total">
            <span>Total:</span>
            <span id="totalPrice">$0.00</span>
        </div>
    </div>

    <button class="confirm-btn" onclick="placeOrder()">Place Order</button>
</div>

