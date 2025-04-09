<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<section class="content">
  <div class="checkout-container">
      <div class="checkout-header">
          <h2>Checkout</h2>
          <p>Complete your order by selecting a payment method</p>
      </div>

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
                      <span>Tax (8%):</span>
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

                  <div class="payment-option" data-payment="qr">
                      <div class="payment-option-header">
                          <input type="radio" name="payment_method" id="qr_payment" value="qr">
                          <label for="qr_payment">
                              <i class="fas fa-qrcode"></i>
                              <span>QR Code Payment</span>
                          </label>
                      </div>
                      <div class="payment-option-content">
                          <div class="qr-code-container">
                              <img src="/assets/images/qr-code-payment.png" alt="QR Code Payment">
                              <p>Scan this QR code with your mobile payment app to complete the payment</p>
                              <div class="qr-verification">
                                  <button id="verify-qr-payment" class="btn-primary">
                                      <i class="fas fa-check-circle"></i> Verify Payment
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="payment-option" data-payment="cash">
                      <div class="payment-option-header">
                          <input type="radio" name="payment_method" id="cash_payment" value="cash">
                          <label for="cash_payment">
                              <i class="fas fa-money-bill-wave"></i>
                              <span>Cash on Delivery</span>
                          </label>
                      </div>
                      <div class="payment-option-content">
                          <div class="cash-payment-info">
                              <p>You will pay when your order is delivered or when you pick it up at our store.</p>
                              <p>Please prepare the exact amount: <strong>$<?php echo number_format($total, 2); ?></strong></p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="checkout-actions">
          <a href="/cart" class="btn-outline">
              <i class="fas fa-arrow-left"></i> Back to Cart
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
                  <span id="order-number">#<?php echo 'ORD' . rand(100000, 999999); ?></span>
              </div>
              <div class="order-total">
                  <span>Total Amount:</span>
                  <span>$<?php echo number_format($total, 2); ?></span>
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
<link rel="stylesheet" href="/assets/css/checkout.css">

<!-- Include JavaScript files -->
<script src="/assets/js/checkout.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>

