<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<section class="content">
    <div class="page-header">
        <h2>Our Products</h2>
        <p>Browse our selection of freshly baked breads and cakes</p>
    </div>

    <!-- New Drinks Collection Section -->
    <div class="new-drinks-collection">
        <h3>New Drinks Collection</h3>
        <div class="new-drinks-grid">
            <?php if (empty($newDrinks)): ?>
                <div class="no-new-drinks">
                    <p>No new drinks available at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($newDrinks as $drink): ?>
                    <div class="new-drink-card" data-id="<?php echo $drink['id']; ?>">
                        <div class="new-drink-image">
                            <img src="<?php echo $drink['image']; ?>" alt="<?php echo $drink['name']; ?>">
                        </div>
                        <div class="new-drink-content">
                            <h4><?php echo $drink['name']; ?></h4>
                            <p class="price">$<?php echo number_format($drink['price'], 2); ?></p>
                            <p class="description">New arrival!</p>
                            <button class="btn-primary order-btn" data-product-id="<?php echo $drink['id']; ?>">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="product-categories">
        <button class="category-btn" data-category="breads">Breads</button>
        <button class="category-btn" data-category="cakes">Cakes</button>
    </div>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card <?php echo strtolower($product['category']); ?>">
                <div class="product-image">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="product-content">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <p class="availability <?php echo $product['availability'] ? 'available' : 'out-of-stock'; ?>">
                        <?php echo $product['availability'] ? 'Freshly Baked Today' : 'Out of Stock'; ?>
                    </p>
                    <?php if ($product['availability']): ?>
                        <button class="order-btn" data-id="<?php echo $product['id']; ?>">Order Now</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryButtons = document.querySelectorAll(".category-btn");
        const productCards = document.querySelectorAll(".product-card");

        categoryButtons.forEach(button => {
            button.addEventListener("click", function() {
                const category = this.getAttribute("data-category");
                productCards.forEach(card => {
                    if (card.classList.contains(category)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        });
    });
</script>
