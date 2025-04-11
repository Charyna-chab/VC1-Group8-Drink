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

<<<<<<< HEAD
      <div class="checkout-content">
          <div class="order-summary-section">
              <h3>Order Summary</h3>
              <div class="order-items">
                  <?php foreach ($cartItems as $item): ?>
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
              </div>
              
              <div class="order-totals">
                  <div class="total-row">
                      <span>Subtotal:</span>
                      <span>$<?php echo number_format($subtotal, 2); ?></span>
                  </div>
                  <div class="total-row">
                      <span>Delivery (8%):</span>
                      <span>$<?php echo number_format($tax, 2); ?></span>
                  </div>
                  <div class="total-row grand-total">
                      <span>Total:</span>
                      <span>$<?php echo number_format($total, 2); ?></span>
                  </div>
              </div>
          </div>

          <div class="payment-section">
              <h3>Payment Method</h3>
              <div class="payment-options">
                  <div class="payment-option" data-payment="card">
                      <div class="payment-option-header">
                          <input type="radio" name="payment_method" id="card_payment" value="card">
                          <label for="card_payment">
                              <i class="fas fa-credit-card"></i>
                              <span>Credit/Debit Card</span>
                          </label>
                      </div>
                      <div class="payment-option-content">
                          <div class="card-payment-form">
                              <div class="form-group">
                                  <label for="card_number">Card Number</label>
                                  <input type="text" id="card_number" placeholder="Your number card" maxlength="19">
                              </div>
                              <div class="form-row">
                                  <div class="form-group">
                                      <label for="expiry_date">Expiry Date</label>
                                      <input type="text" id="expiry_date" placeholder="date" maxlength="5">
                                  </div>
                                  <div class="form-group">
                                      <label for="cvv">CVV</label>
                                      <input type="text" id="cvv" placeholder="123" maxlength="3">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="card_name">Name on Card</label>
                                  <input type="text" id="card_name" placeholder="Your name cards">
                              </div>
                          </div>
                      </div>
                  </div>
=======
        <!-- Step 1: Customer Details -->
        <div class="checkout-step-content active" id="step-1">
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
                    <button id="continue-to-payment" class="btn-primary">
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
        </div>

        <!-- Step 2: Payment Method -->
        <div class="checkout-step-content" id="step-2">
            <h3>Select Payment Method</h3>
            
            <!-- Hidden form fields to store customer data -->
            <input type="hidden" id="hidden_first_name" name="hidden_first_name">
            <input type="hidden" id="hidden_last_name" name="hidden_last_name">
            <input type="hidden" id="hidden_email" name="hidden_email">
            <input type="hidden" id="hidden_phone" name="hidden_phone">
            <input type="hidden" id="hidden_address" name="hidden_address">
            <input type="hidden" id="hidden_notes" name="hidden_notes">
            <input type="hidden" id="hidden_transaction_id" name="hidden_transaction_id">
            
            <div class="payment-methods">
                <!-- ABA Pay -->
                <div class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" id="aba_payment" value="aba">
                        <label for="aba_payment">
                            <img src="/assets/images/aba-pay-logo.png" alt="ABA Pay">
                            <span>ABA Pay</span>
                        </label>
                    </div>
                    <div class="payment-method-content">
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
                                <input type="text" id="aba_transaction_id" placeholder="e.g. ABA123456789">
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
                        <input type="radio" name="payment_method" id="acleda_payment" value="acleda">
                        <label for="acleda_payment">
                            <img src="/assets/images/acleda-pay-logo.png" alt="ACLEDA Pay">
                            <span>ACLEDA Pay</span>
                        </label>
                    </div>
                    <div class="payment-method-content">
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
                                <input type="text" id="acleda_transaction_id" placeholder="e.g. ACLEDA123456789">
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
                        <input type="radio" name="payment_method" id="card_payment" value="card">
                        <label for="card_payment">
                            <i class="fas fa-credit-card"></i>
                            <span>Credit/Debit Card</span>
                        </label>
                    </div>
                    <div class="payment-method-content">
                        <div class="card-payment-form">
                            <div class="card-input-container">
                                <div class="card-front">
                                    <div class="form-group">
                                        <label for="card_number">Card Number</label>
                                        <div class="card-number-input">
                                            <input type="text" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                                            <div class="card-icons">
                                                <i class="fab fa-cc-visa"></i>
                                                <i class="fab fa-cc-mastercard"></i>
                                                <i class="fab fa-cc-amex"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="expiry_date">Expiry Date</label>
                                            <input type="text" id="expiry_date" placeholder="MM/YY" maxlength="5">
                                        </div>
                                        <div class="form-group">
                                            <label for="cvv">CVV 
                                                <span class="cvv-info">
                                                    <i class="fas fa-question-circle"></i>
                                                    <span class="cvv-tooltip">3 or 4 digit security code on the back of your card</span>
                                                </span>
                                            </label>
                                            <input type="text" id="cvv" placeholder="123" maxlength="4">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="card_name">Name on Card</label>
                                        <input type="text" id="card_name" placeholder="John Doe">
                                    </div>
                                </div>
                            </div>
                            <button id="process-card-payment" class="btn-primary">
                                <i class="fas fa-lock"></i> Process Payment
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Cash on Delivery -->
                <div class="payment-method">
                    <div class="payment-method-header">
                        <input type="radio" name="payment_method" id="cash_payment" value="cash">
                        <label for="cash_payment">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash on Delivery</span>
                        </label>
                    </div>
                    <div class="payment-method-content">
                        <div class="cash-payment-info">
                            <p>You will pay when your order is delivered or when you pick it up at our store.</p>
                            <p>Please prepare the exact amount: <strong id="cash-amount">$0.00</strong></p>
                            <div class="cash-payment-note">
                                <i class="fas fa-info-circle"></i>
                                <p>Note: Our delivery person will contact you before arrival.</p>
                            </div>
                        </div>
                        <button id="confirm-cash-payment" class="btn-primary">
                            <i class="fas fa-check"></i> Confirm Cash Payment
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="payment-actions">
                <button id="back-to-details" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Details
                </button>
            </div>
        </div>
>>>>>>> feature/profile

        <!-- Step 3: Confirmation -->
        <div class="checkout-step-content" id="step-3">
            <div class="order-confirmation">
                <div class="confirmation-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2>Thank You for Your Order!</h2>
                <p>Your order has been placed successfully.</p>
                
                <div class="order-details">
                    <div class="order-number">
                        <span>Order Number:</span>
                        <span id="confirmation-order-number">#000000</span>
                    </div>
                    <div class="order-date">
                        <span>Order Date:</span>
                        <span id="confirmation-order-date">January 1, 2023 12:00 PM</span>
                    </div>
                    <div class="order-total">
                        <span>Total Amount:</span>
                        <span id="confirmation-order-total">$0.00</span>
                    </div>
                    <div class="payment-method-used">
                        <span>Payment Method:</span>
                        <span id="confirmation-payment-method">Credit Card</span>
                    </div>
                </div>
                
                <div class="confirmation-message">
                    <p>We've sent a confirmation email to <span id="confirmation-email">your@email.com</span></p>
                    <p>You can view your order details and track your delivery status in the "My Bookings" section.</p>
                </div>
                
                <div class="confirmation-actions">
                    <a href="/booking" class="btn-secondary">
                        <i class="fas fa-list"></i> View My Orders
                    </a>
                    <a href="/receipt" id="view-receipt-btn" class="btn-primary">
                        <i class="fas fa-receipt"></i> View Receipt
                    </a>
                    <a href="/order" class="btn-outline">
                        <i class="fas fa-mug-hot"></i> Order More Drinks
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="loading-modal">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Processing your payment...</p>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay"></div>
</section>

<!-- Include CSS files -->
<link rel="stylesheet" href="/assets/css/checkout.css">

<!-- Include JavaScript files -->
<script src="/assets/js/checkout.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
