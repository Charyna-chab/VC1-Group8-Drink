<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<section class="content">
    <div class="page-header">
        <h2>My Bookings</h2>
        <p>View and manage your orders</p>
    </div>
    
    <div class="booking-container">
        <div class="booking-filters">
            <div class="filter-tabs">
                <button class="filter-tab active" data-status="all">All Orders</button>
                <button class="filter-tab" data-status="processing">Processing</button>
                <button class="filter-tab" data-status="completed">Completed</button>
                <button class="filter-tab" data-status="cancelled">Cancelled</button>
            </div>
            
            <div class="search-filter">
                <input type="text" id="bookingSearch" placeholder="Search by order number...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        
        <div class="bookings-list">
            <?php if (empty($bookings)): ?>
            <div class="empty-state">
                <img src="/assets/images/empty-orders.svg" alt="No Orders">
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet. Start ordering your favorite drinks!</p>
                <a href="/order" class="btn-primary">Order Now</a>
            </div>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                <div class="booking-card" data-status="<?php echo strtolower($booking['status']); ?>">
                    <div class="booking-header">
                        <div class="booking-info">
                            <h3>Order #<?php echo $booking['order_number']; ?></h3>
                            <p class="booking-date">
                                <i class="fas fa-calendar-alt"></i>
                                <?php echo date('M d, Y', strtotime($booking['date'])); ?> at <?php echo $booking['time']; ?>
                            </p>
                        </div>
                        <div class="booking-status <?php echo strtolower($booking['status']); ?>">
                            <?php echo $booking['status']; ?>
                        </div>
                    </div>
                    
                    <div class="booking-items">
                        <?php foreach ($booking['items'] as $item): ?>
                        <div class="booking-item">
                            <div class="item-details">
                                <h4><?php echo $item['name']; ?></h4>
                                <p>
                                    Size: <?php echo $item['size']; ?> | 
                                    Sugar: <?php echo $item['sugar']; ?> | 
                                    Ice: <?php echo $item['ice']; ?>
                                </p>
                                <?php if (!empty($item['toppings'])): ?>
                                <p>Toppings: <?php echo implode(', ', $item['toppings']); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="item-price">
                                $<?php echo number_format($item['price'], 2); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="booking-footer">
                        <div class="booking-total">
                            <span>Total:</span>
                            <span class="total-price">$<?php echo number_format($booking['total'], 2); ?></span>
                        </div>
                        <div class="booking-actions">
                            <a href="/booking/details/<?php echo $booking['id']; ?>" class="btn-secondary">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                            <?php if ($booking['status'] === 'Processing'): ?>
                            <button class="btn-outline-danger cancel-booking-btn" data-id="<?php echo $booking['id']; ?>">
                                <i class="fas fa-times"></i>
                                Cancel Order
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
</main>