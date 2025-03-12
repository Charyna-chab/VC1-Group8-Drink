<section class="content">
    <!-- Discount banner -->
<!-- Discount Banner -->
    <div class="discount-banner">
        <h2>Get Discount Voucher Up To 20%</h2>
        <img src="/assets/images/discount-banner.png" alt="Discount 20-50%">
    </div>

    <!-- Category Section -->
    <div class="category">
        <div class="category-list">
            <div class="category-item" onclick="showCategory('milk-tea')">Milk Tea</div>
            <div class="category-item" onclick="showCategory('fruit-tea')">Fruit Tea</div>
            <div class="category-item" onclick="showCategory('bread')">Bread</div>
            <div class="category-item" onclick="showCategory('coffee')">Coffee</div>
            <div class="category-item" onclick="showCategory('others')">Others</div>
        </div>
        <div class="search-container">
            <input type="text" name="search" id="search" placeholder="Search for your favorite drink...">
            <i class="fa fa-search" aria-hidden="true"></i>
        </div>

        <!-- Category Content -->
        <div id="milk-tea" class="category-content" style="display: none;">Milk Tea items...</div>
        <div id="fruit-tea" class="category-content" style="display: none;">Fruit Tea items...</div>
        <div id="bread" class="category-content" style="display: none;">Bread items...</div>
        <div id="coffee" class="category-content" style="display: none;">Coffee items...</div>
        <div id="others" class="category-content" style="display: none;">Other items...</div>
    </div>

    <!-- Popular dishes section -->
    <div class="popular-dishes">
        <h3>Popular Drinks & Snacks</h3>
        <div class="dishes-list" id="dishes-container">
            <!-- Product Cards (Dynamic Product List) -->
            <div class="product-card">
                <img src="/assets/images/drink1.jpg" alt="Drink 1" class="product-image">
                <div class="product-info">
                    <h4>Strawberry Smoothie</h4>
                    <p class="description">Delicious strawberry smoothie with a creamy texture.</p>
                    <p class="price">$4.99</p>
                    <button class="order-btn" onclick="orderDrink('Strawberry Smoothie')">Order Drink</button>
                </div>
            </div>
            <div class="product-card">
                <img src="/assets/images/drink2.jpg" alt="Drink 2" class="product-image">
                <div class="product-info">
                    <h4>Mango Shake</h4>
                    <p class="description">A refreshing mango shake for your hot day.</p>
                    <p class="price">$5.50</p>
                    <button class="order-btn" onclick="orderDrink('Mango Shake')">Order Drink</button>
                </div>
            </div>
            <!-- Add more 28 product cards here, similar to above -->

            <!-- No products found message -->
            <div id="no-product-message">No products found matching your search.</div>
        </div>
    </div>
</section>

<!-- Modal for ordering drink -->
<div id="order-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Customize Your Drink</h3>
        <form id="order-form">
            <label for="size">Size:</label>
            <select id="size" name="size">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>

            <label for="sugar">Sugar:</label>
            <select id="sugar" name="sugar">
                <option value="regular">Regular</option>
                <option value="less">Less Sugar</option>
                <option value="none">No Sugar</option>
            </select>

            <label for="topping">Topping:</label>
            <select id="topping" name="topping">
                <option value="cream">Cream</option>
                <option value="jelly">Jelly</option>
                <option value="none">No Topping</option>
            </select>

            <button type="submit" class="order-btn">Confirm Order</button>
        </form>
    </div>
</div>
