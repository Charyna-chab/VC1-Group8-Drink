<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<section class="content">
    <div class="page-header">
        <h2>Order Drinks</h2>
        <p>Choose from our delicious selection of boba teas and drinks</p>
    </div>
    
    <div class="order-container">
        <div class="product-filters">
            <div class="search-filter">
                <input type="text" id="productSearch" placeholder="Search drinks...">
                <i class="fas fa-search"></i>
            </div>
            
            <div class="category-filter">
                <button class="filter-btn active" data-category="all">All</button>
                <button class="filter-btn" data-category="milk-tea">Milk Tea</button>
                <button class="filter-btn" data-category="fruit-tea">Fruit Tea</button>
                <button class="filter-btn" data-category="smoothie">Smoothies</button>
                <button class="filter-btn" data-category="coffee">Coffee</button>
            </div>
        </div>
        
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
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
                    <a href="/order/details/<?php echo $product['id']; ?>" class="btn-primary order-btn">Order Now</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
</main>