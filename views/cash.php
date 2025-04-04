<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<section class="content">
    <div class="cash-payment-container">
        <div class="payment-header">
            <h2>Cash on Delivery Payment</h2>
            <p>Order #<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'New Order'; ?></p>
        </div>

        <div class="payment-content">
            <!-- Order Summary Section -->
            <div class="order-summary-section">
                <h3>Order Summary</h3>
                <div class="order-items">
                    <?php if (isset($orderItems) && !empty($orderItems)): ?>
                        <?php foreach ($orderItems as $item): ?>
                        <div class="order-item">
                            <div class="item-image">
                                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                            </div>
                            <div class="item-details">
                                <h4><?php echo $item['name']; ?></h4>
                                <p>Size: <?php echo $item['size']['name']; ?> | Sugar: <?php echo $item['sugar']['name']; ?> | Ice: <?php echo $item['ice']['name']; ?></p>
                                <p>Toppings: <?php echo !empty($item['toppings']) ? implode(', ', array_column($item['toppings'], 'name')) : 'None'; ?></p>
                                <div class="item-quantity-price">
                                    <span>Qty: <?php echo $item['quantity']; ?></span>
                                    <span>$<?php echo number_format($item['totalPrice'], 2); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-order">
                            <p>No items in this order.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span>$<?php echo isset($subtotal) ? number_format($subtotal, 2) : '0.00'; ?></span>
                    </div>
                    <div class="total-row">
                        <span>Tax (8%):</span>
                        <span>$<?php echo isset($tax) ? number_format($tax, 2) : '0.00'; ?></span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total:</span>
                        <span>$<?php echo isset($total) ? number_format($total, 2) : '0.00'; ?></span>
                    </div>
                </div>
            </div>

            <!-- Cash Payment Instructions -->
            <div class="cash-payment-section">
                <h3>Cash on Delivery Instructions</h3>
                
                <div class="cash-payment-info">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="info-content">
                            <h4>Payment on Delivery</h4>
                            <p>You will pay when your order is delivered to your address or when you pick it up at our store.</p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="info-content">
                            <h4>Exact Amount</h4>
                            <p>Please prepare the exact amount: <strong>$<?php echo isset($total) ? number_format($total, 2) : '0.00'; ?></strong></p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Receipt</h4>
                            <p>You will receive a receipt upon payment. Please keep it for any future reference.</p>
                        </div>
                    </div>
                </div>
                
                <div class="delivery-address">
                    <h4>Delivery Address</h4>
                    <div class="address-form">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" placeholder="Enter your delivery address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="notes">Delivery Notes (Optional)</label>
                            <textarea id="notes" placeholder="Any special instructions for delivery"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-actions">
            <a href="/booking" class="btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <button id="confirm-cash-payment" class="btn-primary">
                <i class="fas fa-check"></i> Confirm Order
            </button>
        </div>
    </div>

    <!-- Payment Success Modal -->
    <div id="paymentSuccessModal" class="payment-success-modal">
        <div class="payment-success-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>Order Confirmed!</h3>
            <p>Your cash on delivery order has been confirmed successfully.</p>
            <div class="order-details">
                <div class="order-number">
                    <span>Order Number:</span>
                    <span id="order-number">#<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'New Order'; ?></span>
                </div>
                <div class="order-total">
                    <span>Total Amount:</span>
                    <span>$<?php echo isset($total) ? number_format($total, 2) : '0.00'; ?></span>
                </div>
            </div>
            <div class="success-actions">
                <a href="/booking" class="btn-primary">View My Orders</a>
            </div>
        </div>
    </div>
</section>

<!-- Overlay -->
<div id="overlay"></div>

<!-- Include CSS files -->
<link rel="stylesheet" href="/assets/css/cash-payment.css">

<!-- Include JavaScript files -->
<script src="/assets/js/cash-payment.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>