<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<section class="content">
    <div class="checkout-container">
        <div class="checkout-header">
            <h2>Checkout</h2>
            <p>Complete your order by providing your details and selecting a payment method</p>
        </div>

        <div class="checkout-content">
            <!-- Step Indicator -->
            <div class="checkout-steps">
                <div class="step active" id="step-1">
                    <div class="step-number">1</div>
                    <div class="step-label">Your Details</div>
                </div>
                <div class="step-connector"></div>
                <div class="step" id="step-2">
                    <div class="step-number">2</div>
                    <div class="step-label">Payment Method</div>
                </div>
                <div class="step-connector"></div>
                <div class="step" id="step-3">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>

            <!-- Step 1: User Details Form -->
            <div class="checkout-step-content active" id="step-1-content">
                <form id="user-details-form" method="post" action="/process-payment">
                    <div class="checkout-form-container">
                        <div class="user-form">
                            <h3>Your Details</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Delivery Address</label>
                                <textarea id="address" name="address" placeholder="Enter your delivery address" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="notes">Special Instructions (Optional)</label>
                                <textarea id="notes" name="notes" placeholder="Any special instructions for your order" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="order-summary-section">
                            <h3>Order Summary</h3>
                            <div class="order-items" id="checkout-order-items">
                                <!-- Order items will be dynamically loaded here -->
                                <div class="loading-spinner">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Loading your order...</span>
                                </div>
                            </div>
                            
                            <div class="order-totals">
                                <div class="total-row">
                                    <span>Subtotal:</span>
                                    <span id="checkout-subtotal">$0.00</span>
                                </div>
                                <div class="total-row">
                                    <span>Tax (8%):</span>
                                    <span id="checkout-tax">$0.00</span>
                                </div>
                                <div class="total-row grand-total">
                                    <span>Total:</span>
                                    <span id="checkout-total">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-actions">
                        <a href="/cart" class="btn-outline">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                        <button type="button" id="continue-to-payment" class="btn-primary">
                            Continue to Payment <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 2: Payment Methods -->
            <div class="checkout-step-content" id="step-2-content">
                <form id="payment-form" method="post" action="/process-payment">
                    <!-- Hidden fields to store user details -->
                    <input type="hidden" id="hidden_first_name" name="first_name">
                    <input type="hidden" id="hidden_last_name" name="last_name">
                    <input type="hidden" id="hidden_email" name="email">
                    <input type="hidden" id="hidden_phone" name="phone">
                    <input type="hidden" id="hidden_address" name="address">
                    <input type="hidden" id="hidden_notes" name="notes">
                    <input type="hidden" id="hidden_transaction_id" name="transaction_id">
                    
                    <div class="payment-methods-container">
                        <h3>Select Payment Method</h3>
                        
                        <div class="payment-methods">
                            <!-- ABA Payment -->
                            <div class="payment-method" data-payment="aba">
                                <div class="payment-method-header">
                                    <input type="radio" name="payment_method" id="aba_payment" value="aba">
                                    <label for="aba_payment">
                                        <img src="/assets/images/payments/aba-logo.png" alt="ABA Pay">
                                        <span>ABA Pay</span>
                                    </label>
                                </div>
                                <div class="payment-method-content">
                                    <div class="payment-qr-container">
                                        <img src="/assets/images/payments/aba-qr.png" alt="ABA QR Code" class="payment-qr">
                                        <p>Scan this QR code with your ABA mobile app to complete the payment</p>
                                    </div>
                                    <div class="payment-details">
                                        <div class="payment-detail-row">
                                            <span>Account Name:</span>
                                            <span>XING FU CHA</span>
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
                                            <label for="aba_transaction_id">Transaction ID</label>
                                            <input type="text" id="aba_transaction_id" placeholder="Enter your ABA transaction ID">
                                        </div>
                                        <button type="button" id="verify-aba-payment" class="btn-primary">
                                            <i class="fas fa-check-circle"></i> Verify Payment
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ACLEDA Payment -->
                            <div class="payment-method" data-payment="acleda">
                                <div class="payment-method-header">
                                    <input type="radio" name="payment_method" id="acleda_payment" value="acleda">
                                    <label for="acleda_payment">
                                        <img src="/assets/images/payments/acleda-logo.png" alt="ACLEDA Pay">
                                        <span>ACLEDA Pay</span>
                                    </label>
                                </div>
                                <div class="payment-method-content">
                                    <div class="payment-qr-container">
                                        <img src="/assets/images/payments/acleda-qr.png" alt="ACLEDA QR Code" class="payment-qr">
                                        <p>Scan this QR code with your ACLEDA mobile app to complete the payment</p>
                                    </div>
                                    <div class="payment-details">
                                        <div class="payment-detail-row">
                                            <span>Account Name:</span>
                                            <span>XING FU CHA</span>
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
                                            <label for="acleda_transaction_id">Transaction ID</label>
                                            <input type="text" id="acleda_transaction_id" placeholder="Enter your ACLEDA transaction ID">
                                        </div>
                                        <button type="button" id="verify-acleda-payment" class="btn-primary">
                                            <i class="fas fa-check-circle"></i> Verify Payment
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- VISA Card Payment -->
                            <div class="payment-method" data-payment="card">
                                <div class="payment-method-header">
                                    <input type="radio" name="payment_method" id="card_payment" value="card">
                                    <label for="card_payment">
                                        <img src="/assets/images/payments/visa-logo.png" alt="VISA Card">
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
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="card_name">Cardholder Name</label>
                                                    <input type="text" id="card_name" placeholder="John Doe">
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label for="expiry_date">Expiry Date</label>
                                                        <input type="text" id="expiry_date" placeholder="MM/YY" maxlength="5">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cvv">CVV</label>
                                                        <input type="text" id="cvv" placeholder="123" maxlength="3">
                                                        <div class="cvv-info">
                                                            <i class="fas fa-question-circle"></i>
                                                            <div class="cvv-tooltip">3-digit code on the back of your card</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-payment-actions">
                                            <button type="button" id="process-card-payment" class="btn-primary">
                                                <i class="fas fa-lock"></i> Pay Securely
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cash on Delivery -->
                            <div class="payment-method" data-payment="cash">
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
                                        <button type="button" id="confirm-cash-payment" class="btn-primary">
                                            <i class="fas fa-check"></i> Confirm Cash Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-actions">
                        <button type="button" id="back-to-details" class="btn-outline">
                            <i class="fas fa-arrow-left"></i> Back to Details
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Confirmation -->
            <div class="checkout-step-content" id="step-3-content">
                <div class="order-confirmation">
                    <div class="confirmation-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Thank You for Your Order!</h3>
                    <p>Your order has been successfully placed.</p>
                    
                    <div class="order-details">
                        <div class="order-number">
                            <span>Order Number:</span>
                            <span id="confirmation-order-number">#000000</span>
                        </div>
                        <div class="order-date">
                            <span>Order Date:</span>
                            <span id="confirmation-order-date">January 1, 2023</span>
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
                        <p>We've sent a confirmation email to <span id="confirmation-email">your email address</span>.</p>
                        <p>You can track your order status in the <a href="/booking">My Orders</a> section.</p>
                    </div>
                    
                    <div class="confirmation-actions">
                        <a href="/receipt?order_id=" class="btn-primary" id="view-receipt-btn">
                            <i class="fas fa-receipt"></i> View Receipt
                        </a>
                        <a href="/booking" class="btn-outline">
                            <i class="fas fa-list"></i> View My Orders
                        </a>
                        <a href="/order" class="btn-outline">
                            <i class="fas fa-shopping-bag"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Overlay -->
<div id="overlay"></div>

<!-- Loading Spinner Modal -->
<div id="loadingModal" class="loading-modal">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin"></i>
        <span>Processing your payment...</span>
    </div>
</div>

<!-- Include CSS files -->
<link rel="stylesheet" href="/assets/css/checkout.css">

<!-- Include JavaScript files -->
<script src="/assets/js/checkout.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
