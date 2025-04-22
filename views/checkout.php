<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/navbar.php';
require_once __DIR__ . '/layouts/sidebar.php';

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check for booking_id in URL
$booking_id = isset($_GET['booking_id']) ? htmlspecialchars($_GET['booking_id']) : null;

// Sync localStorage cart with session
if (!isset($_SESSION['cart']) && isset($_POST['cart'])) {
    $_SESSION['cart'] = json_decode($_POST['cart'], true);
}

// Google Maps API Key
$google_maps_api_key = "YOUR_GOOGLE_MAPS_API_KEY"; // Replace with your actual API key
?>

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
                <div class="step-label">Receipt</div>
            </div>
        </div>

        <?php if ($booking_id): ?>
            <div class="checkout-notice">
                <p>Completing payment for Order #<?php echo $booking_id; ?></p>
            </div>
        <?php endif; ?>

        <!-- Step 1: Customer Details -->
        <div class="checkout-step-content active" id="step-1">
            <form id="customer-details-form">
                <div class="checkout-grid">
                    <div class="checkout-form">
                        <h3>Customer Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name *</label>
                                <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                                <span class="error-message" id="first_name_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                                <span class="error-message" id="last_name_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" placeholder="you@example.com" required>
                            <span class="error-message" id="email_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" placeholder="+123 456 7890" required>
                            <span class="error-message" id="phone_error"></span>
                        </div>
                        
                        <!-- Google Maps Integration -->
                        <div class="form-group">
                            <label for="address_search">Find Your Delivery Location *</label>
                            <div class="address-search-container">
                                <input type="text" id="address_search" placeholder="Search for your address" class="address-search-input">
                                <button type="button" id="use-my-location" class="btn-outline-small">
                                    <i class="fas fa-location-arrow"></i> Use My Location
                                </button>
                            </div>
                            <span class="error-message" id="address_search_error"></span>
                        </div>
                        
                        <div class="form-group">
                            <div id="map"></div>
                            <div class="map-instructions">
                                <p><i class="fas fa-info-circle"></i> Drag the marker to adjust your exact location.</p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Delivery Address Details *</label>
                            <textarea id="address" name="address" rows="3" placeholder="Apartment/Unit #, Building, Floor, Additional directions" required></textarea>
                            <span class="error-message" id="address_error"></span>
                        </div>
                        
                        <!-- Hidden inputs for coordinates -->
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">
                        <input type="hidden" id="formatted_address" name="formatted_address">
                        
                        <div class="form-group">
                            <label for="notes">Order Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="2" placeholder="Any special instructions?"></textarea>
                        </div>
                        <input type="hidden" id="booking_id" name="booking_id" value="<?php echo $booking_id; ?>">
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
            <input type="hidden" id="hidden_first_name" name="hidden_first_name">
            <input type="hidden" id="hidden_last_name" name="hidden_last_name">
            <input type="hidden" id="hidden_email" name="hidden_email">
            <input type="hidden" id="hidden_phone" name="hidden_phone">
            <input type="hidden" id="hidden_address" name="hidden_address">
            <input type="hidden" id="hidden_notes" name="hidden_notes">
            <input type="hidden" id="hidden_booking_id" name="hidden_booking_id" value="<?php echo $booking_id; ?>">
            <input type="hidden" id="hidden_lat" name="hidden_lat">
            <input type="hidden" id="hidden_lng" name="hidden_lng">
            <input type="hidden" id="hidden_formatted_address" name="hidden_formatted_address">
            <input type="hidden" id="selected_payment_method" name="selected_payment_method">

            <!-- Payment Cards -->
            <div class="payment-cards">
                <!-- ABA Pay -->
                <div class="payment-card" data-method="aba">
                    <img src="assets/image/ABA logo.png" alt="ABA Pay" class="payment-card-logo">
                    <h4>ABA Pay</h4>
                </div>
                <!-- ACLEDA Pay -->
                <div class="payment-card" data-method="acleda">
                    <img src="/assets/images/acleda-pay-logo.png" alt="ACLEDA Pay" class="payment-card-logo">
                    <h4>ACLEDA Pay</h4>
                </div>
                <!-- Visa Card -->
                <div class="payment-card" data-method="card">
                    <i class="fas fa-credit-card payment-card-icon"></i>
                    <h4>Visa Card</h4>
                </div>
            </div>

            <!-- Payment Method Content (Visa Only) -->
            <div class="payment-method-content" id="card_payment_content" style="display: none;">
                <div class="card-payment-form">
                    <div class="form-group">
                        <label for="card_number">Card Number *</label>
                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                        <span class="error-message" id="card_number_error"></span>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date *</label>
                            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                            <span class="error-message" id="expiry_date_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV *</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                            <span class="error-message" id="cvv_error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card_holder">Card Holder Name *</label>
                        <input type="text" id="card_holder" name="card_holder" placeholder="John Doe" required>
                        <span class="error-message" id="card_holder_error"></span>
                    </div>
                    <button type="button" id="process-card-payment" class="btn-primary">
                        <i class="fas fa-lock"></i> Process Payment
                    </button>
                </div>
            </div>

            <!-- QR Code Modal for ABA and ACLEDA -->
            <div id="qr-modal" class="qr-modal">
                <div class="qr-modal-content">
                    <span class="qr-modal-close">×</span>
                    <div id="qr-modal-body"></div>
                </div>
            </div>

            <div class="payment-actions">
                <button type="button" id="back-to-customer" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Customer Details
                </button>
            </div>
        </div>

        <!-- Step 3: Receipt -->
        <div class="checkout-step-content" id="step-3">
            <div class="order-confirmation">
                <div class="receipt-header">
                    <img src="/assets/images/logo.png" alt="Xing Fu Cha Logo" class="receipt-logo">
                    <h2>Order Receipt</h2>
                    <p>Thank you for your purchase at Xing Fu Cha!</p>
                </div>
                <div class="receipt-content">
                    <div class="receipt-section receipt-details">
                        <h3>Order Details</h3>
                        <div class="receipt-row">
                            <span>Order Number:</span>
                            <span id="order-number"></span>
                        </div>
                        <div class="receipt-row">
                            <span>Order Date:</span>
                            <span id="order-date"><?php echo date('F j, Y H:i'); ?></span>
                        </div>
                        <div class="receipt-row">
                            <span>Customer Name:</span>
                            <span id="order-customer"></span>
                        </div>
                        <div class="receipt-row">
                            <span>Email:</span>
                            <span id="order-email"></span>
                        </div>
                        <div class="receipt-row">
                            <span>Delivery Address:</span>
                            <span id="order-address"></span>
                        </div>
                        <div class="receipt-row">
                            <span>Payment Method:</span>
                            <span id="order-payment-method"></span>
                        </div>
                        <div class="receipt-row">
                            <span>Transaction ID:</span>
                            <span id="order-transaction-id"></span>
                        </div>
                    </div>
                    <div class="receipt-section receipt-items">
                        <h3>Order Items</h3>
                        <div id="order-items-list"></div>
                        <div class="receipt-totals">
                            <div class="receipt-total-row">
                                <span>Subtotal:</span>
                                <span id="order-subtotal">$0.00</span>
                            </div>
                            <div class="receipt-total-row">
                                <span>Tax (8%):</span>
                                <span id="order-tax">$0.00</span>
                            </div>
                            <div class="receipt-total-row grand-total">
                                <span>Total:</span>
                                <span id="order-total">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="confirmation-actions">
                    <a href="views/order.php" class="btn-primary">Continue Shopping</a>
                    <button type="button" id="print-receipt" class="btn-outline">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                    <button type="button" id="download-receipt" class="btn-outline">
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                    <button type="button" id="email-receipt" class="btn-outline">
                        <i class="fas fa-envelope"></i> Email Receipt
                    </button>
                    <button type="button" id="share-receipt" class="btn-outline">
                        <i class="fas fa-share-alt"></i> Share Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="/assets/css/checkout.css">
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&libraries=places&callback=initMap" async defer></script>
<script src="/assets/js/checkout.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    #map {
        height: 300px;
        width: 100%;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
    }
    
    .address-search-container {
        display: flex;
        gap: 10px;
    }
    
    .address-search-input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .btn-outline-small {
        padding: 8px 12px;
        background: none;
        border: 1px solid #ff6769;
        color: #ff6769;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
        white-space: nowrap;
    }
    
    .btn-outline-small:hover {
        background: #ff6769;
        color: white;
    }
    
    .map-instructions {
        margin-top: -10px;
        margin-bottom: 15px;
        font-size: 13px;
        color: #666;
    }
</style>