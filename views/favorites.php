<!DOCTYPE html>
<html lang="en">

<main class="main-content">
    <section class="content">
        <!-- Favorites Header -->
        <div class="favorites-header">
            <h2>My Favorites</h2>
            <p>Your favorite Xing Fu Cha drinks and snacks</p>
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

  <main>
      <?php include 'views/partials/sidebar.php'; ?>

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

          <?php 
          // For demo purposes, we'll show some sample favorites
          // In a real app, this would come from the database
          $favorites = [
              [
                  'id' => 1,
                  'name' => 'Taro Milk Tea',
                  'description' => 'Creamy taro milk tea with chewy tapioca pearls',
                  'price' => 4.50,
                  'image' => '/assets/images/products/taro-milk-tea.jpg',
                  'category' => 'milk-tea'
              ],
              [
                  'id' => 3,
                  'name' => 'Matcha Latte',
                  'description' => 'Premium Japanese matcha with creamy milk',
                  'price' => 5.50,
                  'image' => '/assets/images/products/matcha-latte.jpg',
                  'category' => 'milk-tea'
              ],
              [
                  'id' => 6,
                  'name' => 'Mango Smoothie',
                  'description' => 'Refreshing mango smoothie with popping boba',
                  'price' => 5.25,
                  'image' => '/assets/images/products/mango-smoothie.jpg',
                  'category' => 'smoothies'
              ]
          ];
          ?>

          <?php if(empty($favorites)): ?>
              <div class="empty-state">
                  <img src="/assets/images/empty-favorites.png" alt="No Favorites">
                  <h3>No Favorites Yet</h3>
                  <p>You haven't added any favorites yet. Browse our menu and add items to your favorites!</p>
                  <a href="/menu" class="btn-primary">Browse Menu</a>
              </div>
          <?php else: ?>
              <div class="favorites-grid">
                  <?php foreach($favorites as $item): ?>
                      <div class="favorite-card" data-id="<?php echo $item['id']; ?>">
                          <button class="remove-favorite" data-id="<?php echo $item['id']; ?>">
                              <i class="fas fa-times"></i>
                          </button>
                          <div class="favorite-image">
                              <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                          </div>
                          <div class="favorite-content">
                              <h3><?php echo $item['name']; ?></h3>
                              <p><?php echo $item['description']; ?></p>
                              <div class="favorite-footer">
                                  <span class="price">$<?php echo number_format($item['price'], 2); ?></span>
                                  <button class="order-btn" 
                                      data-id="<?php echo $item['id']; ?>" 
                                      data-name="<?php echo $item['name']; ?>" 
                                      data-price="<?php echo $item['price']; ?>" 
                                      data-image="<?php echo $item['image']; ?>">
                                      Order Now
                                  </button>
                              </div>
                          </div>
                      </div>
                  <?php endforeach; ?>
              </div>
          <?php endif; ?>
      </section>
  </main>

  <?php include 'views/partials/order_panel.php'; ?>
  <?php include 'views/partials/notification_panel.php'; ?>
  <?php include 'views/partials/user_menu.php'; ?>
  <?php include 'views/partials/toast.php'; ?>
  <?php include 'views/partials/overlay.php'; ?>

  <script src="/assets/js/app.js"></script>
  <script src="/assets/js/favorites.js"></script>
</body>

</html>

<script src="/assets/js/favorites.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>

