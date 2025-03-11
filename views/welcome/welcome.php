<section class="content">
    <!-- Discount banner -->
    <div class="discount-banner">
        <h2>Get Discount Voucher Up To 20%</h2>
        <img src="/assets/images/discount-banner.png" alt="Discount 20-50%">
    </div>

    <!-- Category section -->
    <div class="category">
        <div class="category-list">
            <?php foreach ($categories as $category): ?>
            <div class="category-item <?php echo $category['slug'] === 'all' ? 'active' : ''; ?>"
                data-category="<?php echo $category['slug']; ?>">
                <span><?php echo $category['name']; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="search-container">
            <input type="text" name="search" id="search" placeholder="Search for your favorite drink...">
            <i class="fa fa-search" aria-hidden="true"></i>
        </div>
    </div>

    <!-- Popular dishes section -->
    <div class="popular-dishes">
        <h3>Popular Drinks & Snacks</h3>
        <div class="dishes-list" id="dishes-container">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="dish-item" data-category="<?php echo $product['category']; ?>"
                data-id="<?php echo $product['id']; ?>">
                <?php if (!empty($product['discount'])): ?>
                <span class="discount"><?php echo $product['discount']; ?></span>
                <?php endif; ?>
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h4><?php echo $product['name']; ?></h4>
                <p><?php echo $product['description']; ?></p>
                <div class="price-group">
                    <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                    <button class="book-btn" data-id="<?php echo $product['id']; ?>"
                        data-name="<?php echo $product['name']; ?>" data-price="<?php echo $product['price']; ?>"
                        data-image="<?php echo $product['image']; ?>">
                        Order
                    </button>
                </div>
                <button class="fav-btn">❤</button>
            </div>
            <?php endforeach; ?>

            <!-- No products found message -->
            <div id="no-product-message">No products found matching your search.</div>
        </div>
    </div>
</section>
</main>