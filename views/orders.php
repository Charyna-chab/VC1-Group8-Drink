<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders - XING FU CHA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/orders.css">
</head>

<body>
  <?php include 'views/partials/header.php'; ?>

  <main>
      <?php include 'views/partials/sidebar.php'; ?>

      <section class="content">
          <div class="page-header">
              <h2>My Orders</h2>
              <p>Track and manage your orders</p>
          </div>

          <?php if(empty($orders)): ?>
              <div class="empty-state">
                  <img src="/assets/images/empty-orders.png" alt="No Orders">
                  <h3>No Orders Yet</h3>
                  <p>You haven't placed any orders yet. Browse our menu and place your first order!</p>
                  <a href="/menu" class="btn-primary">Browse Menu</a>
              </div>
          <?php else: ?>
              <div class="orders-filter">
                  <div class="filter-tabs">
                      <button class="filter-tab active" data-status="all">All Orders</button>
                      <button class="filter-tab" data-status="processing">Processing</button>
                      <button class="filter-tab" data-status="completed">Completed</button>
                      <button class="filter-tab" data-status="cancelled">Cancelled</button>
                  </div>
                  <div class="search-container">
                      <input type="text" id="orderSearch" placeholder="Search orders...">
                      <i class="fas fa-search"></i>
                  </div>
              </div>

              <div class="orders-list">
                  <?php foreach($orders as $order): 
                      $product = $db->getProductById($order['product_id']);
                  ?>
                      <div class="order-card" data-status="<?php echo $order['status']; ?>">
                          <div class="order-image">
                              <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                          </div>
                          <div class="order-details">
                              <div class="order-header">
                                  <h3><?php echo $product['name']; ?></h3>
                                  <span class="order-status <?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span>
                              </div>
                              <div class="order-info">
                                  <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                                  <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                                  <p><strong>Size:</strong> <?php echo ucfirst($order['size']); ?></p>
                                  <p><strong>Sugar Level:</strong> <?php echo $order['sugar_level']; ?></p>
                                  <?php if(!empty($order['toppings'])): ?>
                                      <p><strong>Toppings:</strong> <?php echo implode(', ', $order['toppings']); ?></p>
                                  <?php endif; ?>
                                  <p><strong>Total:</strong> $<?php echo number_format($order['price'], 2); ?></p>
                              </div>
                          </div>
                          <div class="order-actions">
                              <a href="/order?id=<?php echo $order['id']; ?>" class="btn-outline">View Details</a>
                              <?php if($order['status'] == 'processing'): ?>
                                  <button class="btn-outline cancel-order" data-id="<?php echo $order['id']; ?>">Cancel Order</button>
                              <?php elseif($order['status'] == 'completed'): ?>
                                  <button class="btn-outline reorder" data-id="<?php echo $order['id']; ?>">Reorder</button>
                              <?php endif; ?>
                          </div>
                      </div>
                  <?php endforeach; ?>
              </div>
          <?php endif; ?>
      </section>
  </main>

  <?php include 'views/partials/notification_panel.php'; ?>
  <?php include 'views/partials/user_menu.php'; ?>
  <?php include 'views/partials/toast.php'; ?>
  <?php include 'views/partials/overlay.php'; ?>

  <script src="/assets/js/app.js"></script>
  <script src="/assets/js/orders.js"></script>
</body>

</html>

