<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<section class="content">
    <div class="checkout-container">
        <!-- Checkout Steps -->
        <div class="checkout-steps">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Customer Details</div>
            </div>
            <div class="step-connector"></div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Payment Method</div>
            </div>
            <div class="step-connector"></div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>

        <!-- Step 1: Customer Details -->
        <div class="checkout-step-content active" id="step-1">
            <form id="customer-details-form">
                <div class="checkout-grid">
                    <div class="checkout-form">
                        <h3>Customer Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Delivery Address</label>
                            <textarea id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="notes">Order Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="2"></textarea>
                        </div>
                        <button type="submit" id="continue-to-payment" class="btn-primary">
                            Continue to Payment <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    <div class="checkout-order-summary">
                        <h3>Order Summary</h3>
                        <div id="checkout-order-items" class="checkout-order-items">
                            <div class="loading-spinner">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Loading your order...</p>
                            </div>
                        </div>
                        <div class="checkout-totals">
                            <div class="checkout-total-row">
                                <span>Subtotal:</span>
                                <span id="checkout-subtotal">$0.00</span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Tax (8%):</span>
                                <span id="checkout-tax">$0.00</span>
                            </div>
                            <div class="checkout-total-row grand-total">
                                <span>Total:</span>
                                <span id="checkout-total">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Step 2: Payment Method -->
        <div class="checkout-step-content" id="step-2">
            <h3>Select Payment Method</h3>
            
            <!-- Hidden form fields with customer data -->
            <input type="hidden" id="hidden_first_name" name="hidden_first_name">
            <input type="hidden" id="hidden_last_name" name="hidden_last_name">
            <input type="hidden" id="hidden_email" name="hidden_email">
            <input type="hidden" id="hidden_phone" name="hidden_phone">
            <input type="hidden" id="hidden_address" name="hidden_address">
            <input type="hidden" id="hidden_notes" name="hidden_notes">
            
            <div class="payment-methods">
                <!-- ABA Pay -->
                <div class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" id="aba_payment" value="aba" required>
                        <label for="aba_payment">
                            <img src="/assets/images/aba-pay-logo.png" alt="ABA Pay" class="payment-logo">
                            <span>ABA Pay</span>
                        </label>
                    </div>
                    <div class="payment-method-content" id="aba_payment_content" style="display: none;">
                        <div class="payment-qr-container">
                            <img src="/assets/images/aba-qr-code.png" alt="ABA QR Code" class="payment-qr">
                            <p>Scan this QR code with your ABA mobile app to complete the payment</p>
                        </div>
                        <div class="payment-details">
                            <div class="payment-detail-row">
                                <span>Account Name:</span>
                                <span>Xing Fu Cha</span>
                            </div>
                            <div class="payment-detail-row">
                                <span>Account Number:</span>
                                <span>000 123 456</span>
                            </div>
                            <div class="payment-detail-row">
                                <span>Amount:</span>
                                <span id="aba-amount">$0.00</span>
                            </div>
                        </div>
                        <div class="payment-verification">
                            <div class="form-group">
                                <label for="aba_transaction_id">Enter Transaction ID</label>
                                <input type="text" id="aba_transaction_id" placeholder="e.g. ABA123456789" required>
                            </div>
                            <button id="verify-aba-payment" class="btn-primary">
                                <i class="fas fa-check-circle"></i> Verify Payment
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- ACLEDA Pay -->
                <div class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" id="acleda_payment" value="acleda" required>
                        <label for="acleda_payment">
                            <img src="/assets/images/acleda-pay-logo.png" alt="ACLEDA Pay" class="payment-logo">
                            <span>ACLEDA Pay</span>
                        </label>
                    </div>
                    <div class="payment-method-content" id="acleda_payment_content" style="display: none;">
                        <div class="payment-qr-container">
                            <img src="/assets/images/acleda-qr-code.png" alt="ACLEDA QR Code" class="payment-qr">
                            <p>Scan this QR code with your ACLEDA mobile app to complete the payment</p>
                        </div>
                        <div class="payment-details">
                            <div class="payment-detail-row">
                                <span>Account Name:</span>
                                <span>Xing Fu Cha</span>
                            </div>
                            <div class="payment-detail-row">
                                <span>Account Number:</span>
                                <span>000 987 654</span>
                            </div>
                            <div class="payment-detail-row">
                                <span>Amount:</span>
                                <span id="acleda-amount">$0.00</span>
                            </div>
                        </div>
                        <div class="payment-verification">
                            <div class="form-group">
                                <label for="acleda_transaction_id">Enter Transaction ID</label>
                                <input type="text" id="acleda_transaction_id" placeholder="e.g. ACLEDA123456789" required>
                            </div>
                            <button id="verify-acleda-payment" class="btn-primary">
                                <i class="fas fa-check-circle"></i> Verify Payment
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Credit/Debit Card -->
                <div class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" id="card_payment" value="card" required>
                        <label for="card_payment">
                            <i class="fas fa-credit-card"></i>
                            <span>Credit/Debit Card</span>
                        </label>
                    </div>
                    <div class="payment-method-content" id="card_payment_content" style="display: none```php
                            </div>
                        </div>
                    </div>
                    <div class="card-payment-form">
                        <div class="form-group">
                            <label for="card_number">Card Number</label>
                            <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="card_holder">Card Holder Name</label>
                            <input type="text" id="card_holder" name="card_holder" placeholder="John Doe" required>
                        </div>
                        <button type="button" id="process-card-payment" class="btn-primary">
                            <i class="fas fa-lock"></i> Process Payment
                        </button>
                    </div>
                </div>
                
                <!-- Cash on Delivery -->
                <div class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" id="cod_payment" value="cod" required>
                        <label for="cod_payment">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash on Delivery</span>
                        </label>
                    </div>
                    <div class="payment-method-content" id="cod_payment_content" style="display: none;">
                        <p>Pay cash upon delivery or pickup.</p>
                        <p>Total Amount: <strong id="cod-amount">$0.00</strong></p>
                        <button type="button" id="confirm-cod-payment" class="btn-primary">
                            <i class="fas fa-check"></i> Confirm Order
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="payment-actions">
                <button type="button" id="back-to-customer" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Customer Details
                </button>
            </div>
        </div>

        <!-- Step 3: Order Confirmation -->
        <div class="checkout-step-content" id="step-3">
            <div class="order-confirmation">
                <i class="fas fa-check-circle"></i>
                <h2>Order Confirmed!</h2>
                <p>Your order has been successfully placed.</p>
                
                <div class="order-details">
                    <div class="order-detail-row">
                        <span>Order Number:</span>
                        <span id="order-number"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Order Date:</span>
                        <span id="order-date"><?php echo date('F j, Y H:i'); ?></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Customer Name:</span>
                        <span id="order-customer"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Email:</span>
                        <span id="order-email"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Delivery Address:</span>
                        <span id="order-address"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Payment Method:</span>
                        <span id="order-payment-method"></span>
                    </div>
                </div>
                
                <div class="order-items">
                    <h3>Order Items</h3>
                    <div id="order-items-list"></div>
                    <div class="order-totals">
                        <div class="order-total-row">
                            <span>Subtotal:</span>
                            <span id="order-subtotal">$0.00</span>
                        </div>
                        <div class="order-total-row">
                            <span>Tax (8%):</span>
                            <span id="order-tax">$0.00</span>
                        </div>
                        <div class="order-total-row grand-total">
                            <span>Total:</span>
                            <span id="order-total">$0.00</span>
                        </div>
                    </div>
                </div>
                
                <div class="confirmation-actions">
                    <a href="/orders" class="btn-primary">View Orders</a>
                    <a href="/menu" class="btn-secondary">Continue Shopping</a>
                    <button type="button" id="print-receipt" class="btn-outline">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include CSS -->
<link rel="stylesheet" href="/assets/css/checkout.css">

<!-- Include JavaScript -->
<script src="/assets/js/checkout.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>