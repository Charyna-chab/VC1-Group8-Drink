<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<main class="main-content">
    <section class="content">
        <!-- Favorites Header -->
        <div class="favorites-header">
            <div class="favorites-header-content">
                <h2>My Favorites</h2>
                <p>Your favorite Xing Fu Cha drinks and snacks</p>
                <div class="sparkle-icon">✨</div>
            </div>
        </div>

        <!-- Empty State (initially hidden if there are favorites) -->
        <div class="favorites-empty" style="<?php echo !empty($favorites) ? 'display: none;' : ''; ?>">
            <img src="/assets/image/empty-favorites.svg" alt="No Favorites">
            <h3>No Favorites Yet</h3>
            <p>You haven't added any favorites yet. Browse our menu and add items to your favorites!</p>
            <a href="/order" class="favorites-browse-btn">Browse Menu</a>
        </div>

        <!-- Favorites Grid (initially hidden if there are no favorites) -->
        <div class="favorites-grid" style="<?php echo empty($favorites) ? 'display: none;' : ''; ?>">
            <?php if(!empty($favorites)): ?>
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
            <?php endif; ?>
        </div>

        <!-- Toast Container for Notifications -->
        <div class="favorites-toast-container"></div>
    </section>
</main>

<link rel="stylesheet" href="/assets/css/favorites.css">
<script src="/assets/js/favorites.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>