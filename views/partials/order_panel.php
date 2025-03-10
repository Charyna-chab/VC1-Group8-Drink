<div id="orderPanel" class="order-panel">
    <div class="order-panel-content">
        <button class="close-btn">&times;</button>
        <h3>Customize Your Order</h3>
        
        <div class="product-info">
            <img id="productImage" src="/placeholder.svg?height=120&width=120" alt="Product Image">
            <h4 id="productName">Product Name</h4>
            <p id="productPrice">$0.00</p>
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
                    <option value="50">50% Sugar</option>
                    <option value="75">75% Sugar</option>
                    <option value="100">100% Sugar</option>
                </select>
            </div>

            <div class="option-group">
                <label>TOPPING: ($0.85 each)</label>
                <div id="toppings" class="toppings-grid">
                    <label class="topping-item">
                        Jelly $0.85
                        <input class="option-add"type="checkbox" name="topping" value="jelly" data-price="0.85">
                    </label>
                    <label class="topping-item">
                
                        Cream $0.85
                        <input class="option-add"type="checkbox" name="topping" value="cream" data-price="0.85">
                    </label>
                    <label class="topping-item">
                       
                        Cheese Foam $0.85
                        <input class="option-add"type="checkbox" name="topping" value="cheese_foam" data-price="0.85">
                    </label>
                    <label class="topping-item">
                       
                        Pearl $0.85
                        <input class="option-add"type="checkbox" name="topping" value="pearl" data-price="0.85">
                    </label>
                    <label class="topping-item">
                       
                        Coconut Jelly $0.85
                        <input class="option-add"type="checkbox" name="topping" value="coconut_jelly" data-price="0.85">
                    </label>
                    <label class="topping-item">
                       
                        Chocolate Chips $0.85
                        <input class="option-add"type="checkbox" name="topping" value="chocolate_chips" data-price="0.85">
                    </label>
                    <label class="topping-item">
                       
                        Red Bean $0.85
                        <input class="option-add"type="checkbox" name="topping" value="red_bean" data-price="0.85">
                    </label>
                    <label class="topping-item">
                        Whipped Cream $0.85
                        <input class="option-add"type="checkbox" name="topping" value="whipped_cream" data-price="0.85">
                    </label>
                    <label class="topping-item">
                        
                        Caramel Drizzle $0.85
                        <input class="option-add"type="checkbox" name="topping" value="caramel" data-price="0.85">
                    </label>
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

        <button class="confirm-btn">Add to Cart</button>
    </div>
</div>

