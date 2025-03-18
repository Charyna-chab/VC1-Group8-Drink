<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<main class="main-content">
    <section class="content">
        <!-- Favorites Header -->
        <div class="favorites-header">
            <h2>My Favorites</h2>
            <p>Your favorite Xing Fu cha drinks and snacks</p>
        </div>

        <?php if(empty($favorites)): ?>
            <!-- Empty State -->
            <div class="favorites-empty">
                <img src="/assets/images/empty-favorites.svg" alt="No Favorites">
                <h3>No Favorites Yet</h3>
                <p>You haven't added any favorites yet. Browse our menu and add items to your favorites!</p>
                <a href="/menu" class="favorites-browse-btn">Browse Menu</a>
            </div>
        <?php else: ?>
            <!-- Favorites Grid -->
            <div class="favorites-grid">
                <?php foreach($favorites as $favorite): ?>
                    <div class="favorites-card" data-id="<?php echo $favorite['id']; ?>">
                        <!-- Remove Button -->
                        <button class="favorites-remove-btn" data-id="<?php echo $favorite['id']; ?>">
                            <i class="fas fa-times"></i>
                            <span class="sr-only">Remove from favorites</span>
                        </button>

                        <!-- Product Image -->
                        <div class="favorites-image">
                            <img src="<?php echo $favorite['image']; ?>" alt="<?php echo $favorite['name']; ?>">
                        </div>

                        <!-- Product Info -->
                        <div class="favorites-content">
                            <h3 class="favorites-title"><?php echo $favorite['name']; ?></h3>
                            <p class="favorites-description"><?php echo $favorite['description']; ?></p>
                            
                            <div class="favorites-footer">
                                <div class="favorites-price">
                                    $<?php echo number_format($favorite['price'], 2); ?>
                                </div>
                                <button class="favorites-order-btn" 
                                        data-id="<?php echo $favorite['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($favorite['name']); ?>"
                                        data-price="<?php echo $favorite['price']; ?>"
                                        data-image="<?php echo htmlspecialchars($favorite['image']); ?>">
                                    Order Now
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Toast Container for Notifications -->
        <div class="favorites-toast-container"></div>
    </section>
</main>

<script src="/assets/js/favorites.js"></script>