<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<section class="content">
    <div class="page-header">
        <a href="/booking" class="back-link"><i class="fas fa-arrow-left"></i> Back to Bookings</a>
        <h2>Order Details</h2>
    </div>
    
    <div class="booking-details-container">
        <div class="booking-details-card">
            <div class="booking-details-header">
                <div class="order-info">
                    <h3>Order #<?php echo $booking['order_number']; ?></h3>
                    <p class="order-date">
                        <i class="fas fa-calendar-alt"></i>
                        <?php echo date('M d, Y', strtotime($booking['date'])); ?> at <?php echo $booking['time']; ?>
                    </p>
                </div>
                <div class="order-status <?php echo strtolower($booking['status']); ?>">
                    <?php echo $booking['status']; ?>
                </div>
            </div>
            
            <div class="booking-details-content">
                <div class="details-section">
                    <h4>Order Items</h4>
                    <div class="order-items">
                        <?php foreach ($booking['items'] as $item): ?>
                        <div class="order-item">
                            <div class="item-details">
                                <h5><?php echo $item['name']; ?></h5>
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
                    
                    <div class="order-total">
                        <span>Total:</span>
                        <span class="total-price">$<?php echo number_format($booking['total'], 2); ?></span>
                    </div>
                </div>
                
                <div class="details-section">
                    <h4>Delivery Information</h4>
                    <div class="delivery-info">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h5>Delivery Address</h5>
                                <p><?php echo $booking['delivery_address']; ?></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h5>Contact Number</h5>
                                <p><?php echo $booking['contact']; ?></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-credit-card"></i>
                            <div>
                                <h5>Payment Method</h5>
                                <p><?php echo $booking['payment_method']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="details-section">
                    <h4>Order Timeline</h4>
                    <div class="order-timeline">
                        <div class="timeline-item active">
                            <div class="timeline-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Order Placed</h5>
                                <p><?php echo date('M d, Y', strtotime($booking['date'])); ?> at <?php echo $booking['time']; ?></p>
                            </div>
                        </div>
                        <div class="timeline-item <?php echo ($booking['status'] != 'Cancelled') ? 'active' : ''; ?>">
                            <div class="timeline-icon">
                                <?php echo ($booking['status'] != 'Cancelled') ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>'; ?>
                            </div>
                            <div class="timeline-content">
                                <h5>Order Confirmed</h5>
                                <p><?php echo date('M d, Y', strtotime($booking['date'] . ' +5 minutes')); ?> at <?php echo date('H:i', strtotime($booking['time'] . ' +5 minutes')); ?></p>
                            </div>
                        </div>
                        <div class="timeline-item <?php echo ($booking['status'] == 'Completed') ? 'active' : ''; ?>">
                            <div class="timeline-icon">
                                <?php echo ($booking['status'] == 'Completed') ? '<i class="fas fa-check"></i>' : '<i class="fas fa-clock"></i>'; ?>
                            </div>
                            <div class="timeline-content">
                                <h5>Order Completed</h5>
                                <p><?php echo ($booking['status'] == 'Completed') ? date('M d, Y', strtotime($booking['date'] . ' +30 minutes')) . ' at ' . date('H:i', strtotime($booking['time'] . ' +30 minutes')) : 'Pending'; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="booking-details-footer">
                <?php if ($booking['status'] === 'Processing'): ?>
                <button class="btn-outline-danger cancel-booking-btn" data-id="<?php echo $booking['id']; ?>">
                    <i class="fas fa-times"></i>
                    Cancel Order
                </button>
                <?php endif; ?>
                <a href="/order" class="btn-primary">
                    <i class="fas fa-shopping-bag"></i>
                    Order Again
                </a>
            </div>
        </div>
    </div>
</section>
</main>