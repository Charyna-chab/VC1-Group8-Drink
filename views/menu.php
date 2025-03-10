<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - XING FU CHA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
</head>

<body>
    <?php include 'views/partials/header.php'; ?>

    <main>
        <?php include 'views/partials/sidebar.php'; ?>

        <section class="content">
            <div class="menu-header">
                <h2>Our Menu</h2>
                <p>Discover our delicious selection of premium boba teas and snacks</p>
            </div>

            <!-- Category filter -->
            <div class="category">
                <div class="category-list">
                    <?php foreach ($categories as $category): ?>
                        <div class="category-item <?php echo $category['slug'] === 'all' ? 'active' : ''; ?>" data-category="<?php echo $category['slug']; ?>">
                            <span><?php echo $category['name']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="search-container">
                    <input type="text" name="search" id="search" placeholder="Search for your favorite drink...">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </div>

            <!-- Menu items grid -->
            <div class="menu-grid" id="menu-container">
                <?php foreach ($products as $product): ?>
                    <div class="menu-item" data-category="<?php echo $product['category']; ?>" data-id="<?php echo $product['id']; ?>">
                        <?php if (!empty($product['discount'])): ?>
                            <span class="discount"><?php echo $product['discount']; ?></span>
                        <?php endif; ?>
                        <div class="menu-item-image">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="menu-item-content">
                            <h3><?php echo $product['name']; ?></h3>
                            <p><?php echo $product['description']; ?></p>
                            <div class="menu-item-footer">
                                <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                                <button class="book-btn" 
                                    data-id="<?php echo $product['id']; ?>" 
                                    data-name="<?php echo $product['name']; ?>" 
                                    data-price="<?php echo $product['price']; ?>" 
                                    data-image="<?php echo $product['image']; ?>">
                                    Order Now
                                </button>
                            </div>
                        </div>
                        <button class="fav-btn" data-id="<?php echo $product['id']; ?>">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                <?php endforeach; ?>

                <!-- No products found message -->
                <div id="no-product-message" style="display: none;">
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>No products found</h3>
                        <p>Try adjusting your search or filter to find what you're looking for.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'views/partials/order_panel.php'; ?>
    <?php include 'views/partials/notification_panel.php'; ?>
    <?php include 'views/partials/user_menu.php'; ?>
    <?php include 'views/partials/toast.php'; ?>
    <?php include 'views/partials/overlay.php'; ?>

    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/menu.js"></script>
</body>

</html>

