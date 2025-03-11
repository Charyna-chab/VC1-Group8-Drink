<div class="welcome-banner">
    <h1>Get Discount Voucher Up To 20%</h1>
    <p>Discount 20-50%</p>
</div>

<div class="search-container">
    <input type="text" id="search" placeholder="Search for your favorite drink...">
</div>

<div class="categories">
    <h2>Popular Drinks & Snacks</h2>
    <?php if (isset($categories) && is_array($categories)): ?>
    <ul>
        <?php foreach ($categories as $category): ?>
        <li><?php echo htmlspecialchars($category['name']); ?></li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p>No categories found.</p>
    <?php endif; ?>
</div>

<div class="featured-products">
    <h2>Featured Products</h2>
    <?php if (isset($featuredProducts) && is_array($featuredProducts)): ?>
    <div class="products-list">
        <?php foreach ($featuredProducts as $product): ?>
        <div class="product-item">
            <img src="<?php echo htmlspecialchars($product['image']); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p>$<?php echo number_format($product['price'], 2); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p>No products found matching your search.</p>
    <?php endif; ?>
</div>
</main>