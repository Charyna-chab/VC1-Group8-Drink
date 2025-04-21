<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<section class="content">
    <div class="payment-container">
        <div class="payment-header">
            <h2>Complete Your Payment</h2>
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

            <!-- Payment Methods Section -->
            <div class="payment-methods-section">
                <h3>Select Payment Method</h3>
                
                <div class="payment-methods-container">
                    <!-- Card Payment Option -->
                    <div class="payment-method-card" data-payment="card">
                        <div class="payment-method-header">
                            <input type="radio" name="payment_method" id="card_payment" value="card">
                            <label for="card_payment">
                                <i class="fas fa-credit-card"></i>
                                <span>Credit/Debit Card</span>
                            </label>
                        </div>
                        <div class="payment-method-content" id="card_payment_content">
                            <div class="card-payment-form">
                                <div class="form-group">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" id="expiry_date" placeholder="MM/YY" maxlength="5">
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="card_name">Name on Card</label>
                                    <input type="text" id="card_name" placeholder="John Doe">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ABA QR Code Payment Option -->
                    <div class="payment-method-card" data-payment="aba">
                        <div class="payment-method-header">
                            <input type="radio" name="payment_method" id="aba_payment" value="aba">
                            <label for="aba_payment">
                                <img src="/assets/images/aba-pay-logo.png" alt="ABA Pay" style="height: 24px;">
                                <span>ABA Pay</span>
                            </label>
                        </div>
                        <div class="payment-method-content" id="aba_payment_content">
                            <div class="qr-code-container">
                                <img src="/assets/images/aba-qr-code.png" alt="ABA QR Code Payment">
                                <p>Scan this QR code with your ABA mobile app to complete the payment</p>
                                <div class="payment-details">
                                    <div class="payment-detail-row">
                                        <span>Account Name:</span>
                                        <span>Xing Fu Cha</span>
                                    </div>
                                    <div class="payment-detail-row">
                                        <span>Account Number:</span>
                                        <span>000 123 456</span>
                                    </div>
                                </div>
                                <div class="qr-verification">
                                    <div class="form-group">
                                        <label for="aba_transaction_id">Enter Transaction ID</label>
                                        <input type="text" id="aba_transaction_id" placeholder="e.g. ABA123456789">
                                    </div>
                                    <button id="verify-aba-payment" class="btn-primary">
                                        <i class="fas fa-check-circle"></i> Verify Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ACLEDA QR Code Payment Option -->
                    <div class="payment-method-card" data-payment="acleda">
                        <div class="payment-method-header">
                            <input type="radio" name="payment_method" id="acleda_payment" value="acleda">
                            <label for="acleda_payment">
                                <img src="/assets/images/acleda-pay-logo.png" alt="ACLEDA Pay" style="height: 24px;">
                                <span>ACLEDA Pay</span>
                            </label>
                        </div>
                        <div class="payment-method-content" id="acleda_payment_content">
                            <div class="qr-code-container">
                                <img src="/assets/images/acleda-qr-code.png" alt="ACLEDA QR Code Payment">
                                <p>Scan this QR code with your ACLEDA mobile app to complete the payment</p>
                                <div class="payment-details">
                                    <div class="payment-detail-row">
                                        <span>Account Name:</span>
                                        <span>Xing Fu Cha</span>
                                    </div>
                                    <div class="payment-detail-row">
                                        <span>Account Number:</span>
                                        <span>000 987 654</span>
                                    </div>
                                </div>
                                <div class="qr-verification">
                                    <div class="form-group">
                                        <label for="acleda_transaction_id">Enter Transaction ID</label>
                                        <input type="text" id="acleda_transaction_id" placeholder="e.g. ACLEDA123456789">
                                    </div>
                                    <button id="verify-acleda-payment" class="btn-primary">
                                        <i class="fas fa-check-circle"></i> Verify Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cash Payment Option -->
                    <div class="payment-method-card" data-payment="cash">
                        <div class="payment-method-header">
                            <input type="radio" name="payment_method" id="cash_payment" value="cash">
                            <label for="cash_payment">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Cash on Delivery</span>
                            </label>
                        </div>
                        <div class="payment-method-content" id="cash_payment_content">
                            <div class="cash-payment-info">
                                <p>You will pay when your order is delivered or when you pick it up at our store.</p>
                                <p>Please prepare the exact amount: <strong>$<?php echo isset($total) ? number_format($total, 2) : '0.00'; ?></strong></p>
                                <div class="cash-payment-note">
                                    <i class="fas fa-info-circle"></i>
                                    <p>Note: Our delivery person will contact you before arrival.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="payment-actions">
            <a href="/booking" class="btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <button id="complete-payment" class="btn-primary" disabled>
                <i class="fas fa-lock"></i> Complete Payment
            </button>
        </div>
    </div>

    <!-- Payment Success Modal -->
    <div id="paymentSuccessModal" class="payment-success-modal">
        <div class="payment-success-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>Payment Successful!</h3>
            <p id="payment-success-message">Your payment has been processed successfully.</p>
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
                <a href="/receipt?order_id=<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : ''; ?>" class="btn-primary">View Receipt</a>
                <a href="/booking" class="btn-secondary">View My Orders</a>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay"></div>
</section>

<!-- Include CSS files -->
<link rel="stylesheet" href="/assets/css/payment.css">

<!-- Include JavaScript files -->
<script src="/assets/js/payment.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
