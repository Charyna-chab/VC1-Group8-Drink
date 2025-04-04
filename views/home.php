<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XING FU CHA - Boba Tea Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <?php include 'views/partials/header.php'; ?>

    <main>
        <?php require 'views/partials/sidebar.php'; ?>

        <section class="content">
            <!-- Discount banner -->
            <div class="discount-banner">
                <h2>Get Discount Voucher Up To 20%</h2>
                <img src="/assets/images/discount-banner.png" alt="Discount 20-50%">
            </div>

            <!-- Category section -->
            <div class="category">
                <div class="category-list">
                    <?php if (!empty($categories) && is_array($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <div class="category-item <?php echo ($category['slug'] === 'all') ? 'active' : ''; ?>"
                                data-category="<?php echo htmlspecialchars($category['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                                <span><?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No categories available.</p>
                    <?php endif; ?>
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
                    <?php if (!empty($featuredProducts) && is_array($featuredProducts)): ?>
                        <?php foreach ($featuredProducts as $product): ?>
                            <div class="dish-item"
                                data-category="<?php echo htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-id="<?php echo (int) $product['id']; ?>">

                                <?php if (!empty($product['discount'])): ?>
                                    <span class="discount"><?php echo htmlspecialchars($product['discount'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <?php endif; ?>

                                <img src="<?php echo htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>">

                                <h4><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                <p><?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></p>

                                <div class="price-group">
                                    <span class="price">$<?php echo number_format((float) $product['price'], 2); ?></span>
                                    <button class="book-btn"
                                        data-id="<?php echo (int) $product['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                                        data-price="<?php echo number_format((float) $product['price'], 2); ?>"
                                        data-image="<?php echo htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>">
                                        Order
                                    </button>
                                </div>

                               
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- No products found message -->
                        <div id="no-product-message">No products found matching your search.</div>
                    <?php endif; ?>
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
</body>

</html>