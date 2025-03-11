
      <section class="content">
          <div class="page-header">
              <h2>My Favorites</h2>
              <p>Your favorite boba tea drinks and snacks</p>
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



