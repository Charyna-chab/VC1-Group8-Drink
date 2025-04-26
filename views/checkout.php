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
        <!-- Progress Bar -->
        <div class="progress-bar-container">
            <div class="progress-bar-fill" id="progress-bar-fill"></div>
        </div>

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
                        <div class="form-header">
                            <div class="form-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h3>Customer Information</h3>
                        </div>
                        
                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <h4 class="section-title"><i class="fas fa-id-card"></i> Personal Details</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name">First Name *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                                    </div>
                                    <span class="error-message" id="first_name_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                                    </div>
                                    <span class="error-message" id="last_name_error"></span>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email" placeholder="you@example.com" required>
                                    </div>
                                    <span class="error-message" id="email_error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="phone" name="phone" placeholder="+855 12 345 678" required>
                                    </div>
                                    <span class="error-message" id="phone_error"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Delivery Location Section -->
                        <div class="form-section">
                            <h4 class="section-title"><i class="fas fa-map-marker-alt"></i> Delivery Location</h4>
                            
                            <!-- Google Maps Integration -->
                            <div class="form-group">
                                <label for="address_search">Find Your Location *</label>
                                <div class="address-search-container">
                                    <div class="input-with-icon">
                                        <i class="fas fa-search"></i>
                                        <input type="text" id="address_search" placeholder="Search for your address" class="address-search-input">
                                    </div>
                                    <button type="button" id="use-my-location" class="btn-outline-small">
                                        <i class="fas fa-location-arrow"></i> Current Location
                                    </button>
                                </div>
                                <span class="error-message" id="address_search_error"></span>
                            </div>
                            
                            <div class="form-group">
                                <div id="map"></div>
                                <div class="map-instructions">
                                    <p><i class="fas fa-info-circle"></i> Drag the marker to adjust your exact location for easier delivery.</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="address">Delivery Address Details *</label>
                                <div class="input-with-icon textarea-icon">
                                    <i class="fas fa-home"></i>
                                    <textarea id="address" name="address" rows="3" placeholder="Apartment/Unit #, Building, Floor, Additional directions" required></textarea>
                                </div>
                                <span class="error-message" id="address_error"></span>
                            </div>
                            
                            <!-- Hidden inputs for coordinates -->
                            <input type="hidden" id="lat" name="lat" value="11.5564">
                            <input type="hidden" id="lng" name="lng" value="104.9282">
                            <input type="hidden" id="formatted_address" name="formatted_address" value="Phnom Penh, Cambodia">
                        </div>
                        
                        <!-- Additional Information Section -->
                        <div class="form-section">
                            <h4 class="section-title"><i class="fas fa-clipboard-list"></i> Additional Information</h4>
                            <div class="form-group">
                                <label for="notes">Order Notes (Optional)</label>
                                <div class="input-with-icon textarea-icon">
                                    <i class="fas fa-comment"></i>
                                    <textarea id="notes" name="notes" rows="2" placeholder="Any special instructions?"></textarea>
                                </div>
                            </div>
                            <input type="hidden" id="booking_id" name="booking_id" value="<?php echo $booking_id; ?>">
                        </div>
                        
                        <button type="submit" id="continue-to-payment" class="btn-primary">
                            Continue to Payment <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    <div class="checkout-order-summary">
                        <div class="summary-header">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Order Summary</h3>
                        </div>
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
            <!-- Hidden fields for customer data -->
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
            <input type="hidden" id="payment_phone_number" name="payment_phone_number">

            <div class="payment-container">
                <div class="payment-header">
                    <div class="payment-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Select Payment Method</h3>
                    <p>Choose your preferred payment option</p>
                </div>
                
                <div class="payment-amount-display">
                    <div class="amount-label">Total Amount:</div>
                    <div class="amount-value" id="payment-total">$0.00</div>
                </div>

                <!-- Payment Options -->
                <div class="payment-options">
                    <!-- ABA Pay -->
                    <div class="payment-option" data-method="aba">
                        <div class="payment-option-inner">
                            <img src="/assets/image/ABA logo.png" alt="ABA Pay" class="payment-logo">
                            <h4>ABA Pay</h4>
                        </div>
                    </div>
                    
                    <!-- ACLEDA Pay -->
                    <div class="payment-option" data-method="acleda">
                        <div class="payment-option-inner">
                            <img src="assets/image/Logo Acleda.png" alt="ACLEDA Pay" class="payment-logo">
                            <h4>ACLEDA Pay</h4>
                        </div>
                    </div>
                    
                    <!-- Visa Card -->
                    <div class="payment-option" data-method="card">
                        <div class="payment-option-inner">
                            <img src="assets/image/Visa-Card.png" alt="Visa-Card" class="payment-logo">      
                            <h4>Visa Card</h4>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Content Container -->
                <div class="payment-method-container">
                    <!-- Default message -->
                    <div class="payment-method-default" id="payment-method-default">
                        <div class="payment-method-icon">
                            <i class="fas fa-hand-pointer"></i>
                        </div>
                        <p>Please select a payment method above</p>
                    </div>
                    
                    <!-- ABA Pay Content -->
                    <div class="payment-method-content" id="aba_payment_content" style="display: none;">
                        <div class="payment-qr-container">
                            <h4>ABA Pay</h4>
                            <div class="payment-amount">$<span id="aba-payment-amount">0.00</span></div>
                            <img src="assets/image/ABA Vanda.jpg.jpg" alt="ABA Pay QR Code" class="payment-qr">
                            <p>Scan this QR code with your ABA app to pay</p>
                            
                            <div class="phone-input-container">
                                <label for="aba_phone">Enter your ABA account phone number for automatic charging:</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" id="aba_phone" placeholder="+855 12 345 678" required>
                                </div>
                                <span class="error-message" id="aba_phone_error"></span>
                            </div>
                            
                            <button type="button" id="process-aba-payment" class="btn-primary">
                                <i class="fas fa-check-circle"></i> Complete Payment
                            </button>
                        </div>
                    </div>
                    
                    <!-- ACLEDA Pay Content -->
                    <div class="payment-method-content" id="acleda_payment_content" style="display: none;">
                        <div class="payment-qr-container">
                            <h4>ACLEDA Pay</h4>
                            <div class="payment-amount">$<span id="acleda-payment-amount">0.00</span></div>
                            <img src="/assets/images/acleda-qr-code.png" alt="ACLEDA Pay QR Code" class="payment-qr">
                            <p>Scan this QR code with your ACLEDA app to pay</p>
                            
                            <div class="phone-input-container">
                                <label for="acleda_phone">Enter your ACLEDA account phone number for automatic charging:</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" id="acleda_phone" placeholder="+855 12 345 678" required>
                                </div>
                                <span class="error-message" id="acleda_phone_error"></span>
                            </div>
                            
                            <button type="button" id="process-acleda-payment" class="btn-primary">
                                <i class="fas fa-check-circle"></i> Complete Payment
                            </button>
                        </div>
                    </div>
                    
                    <!-- Visa Card Content -->
                    <div class="payment-method-content" id="card_payment_content" style="display: none;">
                        <div class="card-payment-form">
                            <h4>Credit Card Payment</h4>
                            <div class="payment-amount">$<span id="card-payment-amount">0.00</span></div>
                            
                            <div class="card-input-container">
                                <div class="form-group">
                                    <label for="card_number">Card Number *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-credit-card"></i>
                                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                    </div>
                                    <span class="error-message" id="card_number_error"></span>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date *</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-calendar"></i>
                                            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                                        </div>
                                        <span class="error-message" id="expiry_date_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV *</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-lock"></i>
                                            <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                                        </div>
                                        <span class="error-message" id="cvv_error"></span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="card_holder">Card Holder Name *</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="card_holder" name="card_holder" placeholder="John Doe" required>
                                    </div>
                                    <span class="error-message" id="card_holder_error"></span>
                                </div>
                                
                                <button type="button" id="process-card-payment" class="btn-primary">
                                    <i class="fas fa-lock"></i> Process Payment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment-actions">
                    <button type="button" id="back-to-customer" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Customer Details
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 3: Receipt -->
        <div class="checkout-step-content" id="step-3">
            <div class="order-confirmation" id="receipt-container">
                <div class="receipt-header">
                    <img src="/assets/image/logo/logo.png" alt="Xing Fu Cha Logo" class="receipt-logo">
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
                <div class="receipt-actions">
                    <button type="button" id="print-receipt" class="btn-outline">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                    <button type="button" id="download-receipt" class="btn-outline">
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Confirmation Modal -->
<div class="confirmation-modal" id="confirmation-modal" style="display: none;">
    <div class="confirmation-modal-content">
        <h3>Confirm Payment</h3>
        <p>Are you sure you want to proceed with the payment of <span id="confirmation-amount">$0.00</span> using <span id="confirmation-method"></span>?</p>
        <div class="confirmation-modal-actions">
            <button type="button" id="confirm-payment" class="btn-primary">Confirm</button>
            <button type="button" id="cancel-payment" class="btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="/assets/css/checkout.css">
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&libraries=places&callback=initMap" async defer></script>
<script src="/assets/js/checkout.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    /* General Styles */
    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        position: relative;
    }
    
    /* Progress Bar */
    .progress-bar-container {
        position: sticky;
        top: 0;
        width: 100%;
        height: 8px;
        background-color: #f0f0f0;
        border-radius: 4px;
        margin-bottom: 20px;
        z-index: 100;
        overflow: hidden;
    }
    
    .progress-bar-fill {
        height: 100%;
        background-color: #ff6769;
        width: 33.33%;
        transition: width 0.5s ease;
    }
    
    /* Checkout Steps */
    .checkout-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        opacity: 1;
        transition: opacity 0.3s ease;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        transition: transform 0.3s ease;
    }
    
    .step:hover {
        transform: scale(1.1);
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f0f0f0;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    .step.active .step-number {
        background-color: #ff6769;
        color: white;
        transform: scale(1.2);
    }
    
    .step-connector {
        height: 3px;
        width: 100px;
        background-color: #f0f0f0;
        margin: 0 15px;
        transition: background-color 0.3s ease;
    }
    
    .step.active + .step-connector {
        background-color: #ff6769;
    }
    
    .step-label {
        font-size: 14px;
        color: #666;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .step.active .step-label {
        color: #ff6769;
        font-weight: 600;
    }
    
    /* Checkout Grid */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
    }
    
    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* Form Styling */
    .checkout-form {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 30px;
        animation: slide-in 0.5s ease;
    }
    
    @keyframes slide-in {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .form-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f5f5f5;
    }
    
    .form-icon {
        width: 50px;
        height: 50px;
        background-color: #ff6769;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .form-icon i {
        font-size: 24px;
        color: white;
    }
    
    .form-header h3 {
        margin: 0;
        font-size: 22px;
        color: #333;
    }
    
    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .form-section:last-of-type {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 18px;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #ff6769;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        transition: color 0.3s ease;
    }
    
    .textarea-icon i {
        top: 20px;
        transform: none;
    }
    
    .input-with-icon input,
    .input-with-icon textarea {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .input-with-icon input:focus,
    .input-with-icon textarea:focus {
        border-color: #ff6769;
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 103, 105, 0.1);
        transform: scale(1.02);
    }
    
    .error-message {
        color: #f44336;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    
    /* Map Styles */
    #map {
        height: 300px;
        width: 100%;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .address-search-container {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .address-search-input {
        flex: 1;
    }
    
    .btn-outline-small {
        padding: 8px 12px;
        background: none;
        border: 1px solid #ff6769;
        color: #ff6769;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 5px;
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
    
    /* Order Summary */
    .checkout-order-summary {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
        position: sticky;
        top: 20px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }
    
    .summary-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f5f5f5;
    }
    
    .summary-header i {
        font-size: 24px;
        color: #ff6769;
        margin-right: 10px;
    }
    
    .summary-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .checkout-order-items {
        margin-bottom: 20px;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 5px;
    }
    
    .order-item {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .order-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }
    
    .order-item-details {
        flex: 1;
    }
    
    .order-item-details h4 {
        margin: 0 0 5px;
        font-size: 16px;
        color: #333;
    }
    
    .order-item-details p {
        margin: 3px 0;
        font-size: 13px;
        color: #666;
    }
    
    .checkout-totals {
        border-top: 2px solid #f5f5f5;
        padding-top: 15px;
    }
    
    .checkout-total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .checkout-total-row.grand-total {
        font-weight: bold;
        font-size: 18px;
        color: #ff6769;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #eee;
    }
    
    /* Button Styles */
    .btn-primary {
        background-color: #ff6769;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 14px 24px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 20px;
    }
    
    .btn-primary:hover {
        background-color: #ff4f52;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 103, 105, 0.3);
    }
    
    .btn-primary:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .btn-secondary {
        background-color: #f5f5f5;
        color: #666;
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background-color: #eee;
    }
    
    .btn-outline {
        background: none;
        border: 1px solid #ff6769;
        color: #ff6769;
        border-radius: 8px;
        padding: 12px 20px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-outline:hover {
        background-color: #ff6769;
        color: white;
    }
    
    /* Payment Styles */
    .payment-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 30px;
        animation: slide-in 0.5s ease;
    }
    
    .payment-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .payment-icon {
        width: 70px;
        height: 70px;
        background-color: #ff6769;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }
    
    .payment-icon i {
        font-size: 30px;
        color: white;
    }
    
    .payment-header h3 {
        margin: 0 0 5px;
        font-size: 24px;
        color: #333;
    }
    
    .payment-header p {
        margin: 0;
        color: #666;
        font-size: 16px;
    }
    
    .payment-amount-display {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 30px;
        text-align: center;
    }
    
    .amount-label {
        font-size: 16px;
        color: #666;
        margin-bottom: 5px;
    }
    
    .amount-value {
        font-size: 28px;
        font-weight: bold;
        color: #ff6769;
    }
    
    .payment-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    @media (max-width: 768px) {
        .payment-options {
            grid-template-columns: 1fr;
        }
    }
    
    .payment-option {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-option-inner {
        background-color: #f9f9f9;
        border: 2px solid #eee;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .payment-option:hover .payment-option-inner {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        border-color: #ff6769;
    }
    
    .payment-option.active .payment-option-inner {
        background-color: #fff5f5;
        border-color: #ff6769;
        box-shadow: 0 8px 15px rgba(255, 103, 105, 0.2);
    }
    
    .payment-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-bottom: 15px;
    }
    
    .payment-icon {
        font-size: 50px;
        color: #ff6769;
        margin-bottom: 15px;
    }
    
    .payment-option h4 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .payment-method-container {
        background-color: #f9f9f9;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        min-height: 300px;
        position: relative;
        overflow: hidden;
    }
    
    .payment-method-default {
        text-align: center;
        padding: 40px 0;
    }
    
    .payment-method-icon {
        font-size: 50px;
        color: #ccc;
        margin-bottom: 20px;
    }
    
    .payment-method-default p {
        color: #999;
        font-size: 18px;
    }
    
    .payment-qr-container {
        text-align: center;
        position: relative;
        padding: 20px;
        background: linear-gradient(45deg, #fff5f5, #f9f9f9);
        border-radius: 12px;
        animation: pulse-bg 3s infinite;
    }
    
    @keyframes pulse-bg {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .payment-qr-container h4 {
        font-size: 22px;
        color: #333;
        margin-bottom: 10px;
    }
    
    .payment-amount {
        font-size: 28px;
        font-weight: bold;
        color: #ff6769;
        margin: 15px 0;
    }
    
    .payment-qr {
        width: 300px;
        height: 300px;
        margin: 20px auto;
        border: 2px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }
    
    .payment-qr:hover {
        transform: scale(1.05);
    }
    
    @media (max-width: 576px) {
        .payment-qr {
            width: 250px;
            height: 250px;
        }
    }
    
    .phone-input-container {
        max-width: 400px;
        margin: 20px auto;
        text-align: left;
    }
    
    .card-input-container {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .payment-actions {
        display: flex;
        justify-content: center;
    }
    
    /* Receipt Styles */
    .order-confirmation {
        max-width: 800px;
        margin: 0 auto;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 30px;
        animation: slide-in 0.5s ease;
    }
    
    .receipt-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .receipt-logo {
        width: 120px;
        margin-bottom: 15px;
    }
    
    .receipt-header h2 {
        margin: 0 0 5px;
        font-size: 28px;
        color: #ff6769;
    }
    
    .receipt-header p {
        margin: 0;
        color: #666;
        font-size: 16px;
    }
    
    .receipt-content {
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .receipt-section {
        margin-bottom: 30px;
    }
    
    .receipt-section h3 {
        font-size: 20px;
        color: #ff6769;
        margin: 0 0 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ff6769;
    }
    
    .receipt-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 15px;
    }
    
    .receipt-row span:first-child {
        font-weight: 600;
        color: #333;
    }
    
    .receipt-totals {
        border-top: 2px solid #eee;
        padding-top: 15px;
        margin-top: 20px;
    }
    
    .receipt-total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 15px;
    }
    
    .receipt-total-row.grand-total {
        font-weight: bold;
        font-size: 18px;
        color: #ff6769;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #eee;
    }
    
    .receipt-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    /* Loading Modal */
    .loading-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    
    .loading-spinner {
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    
    .loading-spinner i {
        font-size: 40px;
        color: #ff6769;
        margin-bottom: 15px;
    }
    
    .loading-spinner p {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .progress-bar {
        width: 100%;
        height: 8px;
        background-color: #f0f0f0;
        border-radius: 4px;
        margin-top: 15px;
        overflow: hidden;
    }
    
    .progress-bar-fill {
        height: 100%;
        background-color: #ff6769;
        width: 0%;
        transition: width 0.2s ease;
    }
    
    /* Toast Notifications */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1500;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .toast {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 300px;
        max-width: 400px;
        opacity: 0;
        animation: slide-in-right 0.3s ease forwards;
    }
    
    .toast.success {
        border-left: 4px solid #4caf50;
    }
    
    .toast.error {
        border-left: 4px solid #f44336;
    }
    
    .toast.info {
        border-left: 4px solid #2196f3;
    }
    
    .toast-icon {
        font-size: 24px;
    }
    
    .toast-content h4 {
        margin: 0 0 5px;
        font-size: 16px;
        color: #333;
    }
    
    .toast-content p {
        margin: 0;
        font-size: 14px;
        color: #666;
    }
    
    .toast-close {
        background: none;
        border: none;
        font-size: 20px;
        color: #999;
        cursor: pointer;
        margin-left: auto;
    }
    
    .toast-hide {
        animation: slide-out-right 0.3s ease forwards;
    }
    
    @keyframes slide-in-right {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slide-out-right {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(20px);
        }
    }
    
    /* Confirmation Modal */
    .confirmation-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
    }
    
    .confirmation-modal-content {
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        animation: slide-in 0.3s ease;
    }
    
    .confirmation-modal-content h3 {
        margin: 0 0 15px;
        font-size: 22px;
        color: #333;
    }
    
    .confirmation-modal-content p {
        margin: 0 0 20px;
        font-size: 16px;
        color: #666;
    }
    
    .confirmation-modal-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    /* Celebration Animation */
    .celebration-animation {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1500;
    }
    
    .confetti {
        position: absolute;
        top: -10px;
        border-radius: 0;
        animation: fall linear forwards;
    }
    
    @keyframes fall {
        to {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
    
    .fade-out {
        animation: fade-out 1s forwards;
    }
    
    @keyframes fade-out {
        to {
            opacity: 0;
        }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const customerForm = document.getElementById("customer-details-form");
    const paymentOptions = document.querySelectorAll(".payment-option");
    const steps = document.querySelectorAll(".step");
    const stepContents = document.querySelectorAll(".checkout-step-content");
    const continueToPaymentBtn = document.getElementById("continue-to-payment");
    const backToCustomerBtn = document.getElementById("back-to-customer");
    const processCardPaymentBtn = document.getElementById("process-card-payment");
    const processAbaPaymentBtn = document.getElementById("process-aba-payment");
    const processAcledaPaymentBtn = document.getElementById("process-acleda-payment");
    const printReceiptBtn = document.getElementById("print-receipt");
    const downloadReceiptBtn = document.getElementById("download-receipt");
    const orderItemsContainer = document.getElementById("checkout-order-items");
    const checkoutSubtotal = document.getElementById("checkout-subtotal");
    const checkoutTax = document.getElementById("checkout-tax");
    const checkoutTotal = document.getElementById("checkout-total");
    const paymentTotalDisplay = document.getElementById("payment-total");
    const abaPaymentAmount = document.getElementById("aba-payment-amount");
    const acledaPaymentAmount = document.getElementById("acleda-payment-amount");
    const cardPaymentAmount = document.getElementById("card-payment-amount");
    const orderNumber = document.getElementById("order-number");
    const orderCustomer = document.getElementById("order-customer");
    const orderEmail = document.getElementById("order-email");
    const orderAddress = document.getElementById("order-address");
    const orderPaymentMethod = document.getElementById("order-payment-method");
    const orderTransactionId = document.getElementById("order-transaction-id");
    const orderItemsList = document.getElementById("order-items-list");
    const orderSubtotal = document.getElementById("order-subtotal");
    const orderTax = document.getElementById("order-tax");
    const orderTotal = document.getElementById("order-total");
    const selectedPaymentMethodInput = document.getElementById("selected_payment_method");
    const paymentPhoneNumberInput = document.getElementById("payment_phone_number");
    const progressBarFill = document.getElementById("progress-bar-fill");
    const confirmationModal = document.getElementById("confirmation-modal");
    const confirmPaymentBtn = document.getElementById("confirm-payment");
    const cancelPaymentBtn = document.getElementById("cancel-payment");
    const confirmationAmount = document.getElementById("confirmation-amount");
    const confirmationMethod = document.getElementById("confirmation-method");

    // Get booking_id from URL
    const urlParams = new URLSearchParams(window.location.search);
    const bookingId = urlParams.get("booking_id");
    const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
    let itemsSource = [];
    let currentTransactionId = "";
    let map, marker, autocomplete, geocoder;
    let currentTotal = 0;
    let mapInitialized = false;
    let pendingPayment = null;

    // Initialize Google Maps with delay to ensure DOM readiness
    window.initMap = () => {
        setTimeout(() => {
            const mapElement = document.getElementById("map");
            const addressSearchInput = document.getElementById("address_search");
            const useMyLocationBtn = document.getElementById("use-my-location");
            const latInput = document.getElementById("lat");
            const lngInput = document.getElementById("lng");
            const formattedAddressInput = document.getElementById("formatted_address");
            const addressTextarea = document.getElementById("address");

            // Default location (center of Phnom Penh, Cambodia)
            const defaultLocation = { lat: 11.5564, lng: 104.9282 };

            // Create map
            map = new google.maps.Map(mapElement, {
                center: defaultLocation,
                zoom: 15,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
            });

            // Create marker
            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
            });

            // Initialize geocoder
            geocoder = new google.maps.Geocoder();

            // Initialize autocomplete
            autocomplete = new google.maps.places.Autocomplete(addressSearchInput, {
                types: ["address"],
            });

            // Bias autocomplete results to current map bounds
            autocomplete.bindTo("bounds", map);

            // Handle place selection
            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();

                if (!place.geometry) {
                    showToast("Error", "No location details available for this address.", "error");
                    return;
                }

                // Update map and marker
                map.setCenter(place.geometry.location);
                map.setZoom(17);
                marker.setPosition(place.geometry.location);

                // Update hidden inputs
                updateLocationInputs(place.geometry.location, place.formatted_address);
            });

            // Handle marker drag
            marker.addListener("dragend", () => {
                const position = marker.getPosition();
                geocoder.geocode({ location: position }, (results, status) => {
                    if (status === "OK" && results[0]) {
                        updateLocationInputs(position, results[0].formatted_address);
                    } else {
                        showToast("Warning", "Could not find address for this location.", "warning");
                        updateLocationInputs(position, "Custom location");
                    }
                });
            });

            // Handle "Use My Location" button
            useMyLocationBtn.addEventListener("click", () => {
                if (navigator.geolocation) {
                    showToast("Finding Location", "Getting your current location...", "info");

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const userLocation = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };

                            // Update map and marker
                            map.setCenter(userLocation);
                            map.setZoom(17);
                            marker.setPosition(userLocation);

                            // Get address from coordinates
                            geocoder.geocode({ location: userLocation }, (results, status) => {
                                if (status === "OK" && results[0]) {
                                    updateLocationInputs(userLocation, results[0].formatted_address);
                                    addressSearchInput.value = results[0].formatted_address;
                                } else {
                                    updateLocationInputs(userLocation, "Custom location");
                                    addressSearchInput.value = "Custom location";
                                    showToast("Warning", "Could not find address for your location.", "warning");
                                }
                            });
                        },
                        (error) => {
                            let errorMessage = "Could not get your location.";
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage = "Location access denied. Please enable location services.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage = "Location information is unavailable.";
                                    break;
                                case error.TIMEOUT:
                                    errorMessage = "Location request timed out.";
                                    break;
                            }
                            showToast("Error", errorMessage, "error");
                            // Fallback to default location
                            updateLocationInputs(defaultLocation, "Phnom Penh, Cambodia");
                            map.setCenter(defaultLocation);
                            marker.setPosition(defaultLocation);
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0,
                        }
                    );
                } else {
                    showToast("Error", "Geolocation is not supported by this browser.", "error");
                    // Fallback to default location
                    updateLocationInputs(defaultLocation, "Phnom Penh, Cambodia");
                    map.setCenter(defaultLocation);
                    marker.setPosition(defaultLocation);
                }
            });

            // Helper function to update location inputs
            function updateLocationInputs(location, formattedAddress) {
                latInput.value = location.lat instanceof Function ? location.lat() : location.lat;
                lngInput.value = location.lng instanceof Function ? location.lng() : location.lng;
                formattedAddressInput.value = formattedAddress;

                // Update address textarea with formatted address as a starting point
                if (addressTextarea.value === "") {
                    addressTextarea.value = formattedAddress;
                }
            }

            // Set flag to indicate map is initialized
            mapInitialized = true;
            // Set default location initially
            updateLocationInputs(defaultLocation, "Phnom Penh, Cambodia");
        }, 1000); // Delay to ensure DOM is fully loaded
    };

    // Fallback utilities
    const formatPrice = (price) => `$${(price || 0).toFixed(2)}`;
    const formatPriceWithoutSymbol = (price) => (price || 0).toFixed(2);
    const generateId = (prefix) => `${prefix}-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
    const showRedirectNotification = (title, message, url) => {
        showToast(title, message, "info");
        setTimeout(() => {
            window.location.href = url;
        }, 2000);
    };

    // Form validation for customer details
    function validateForm() {
        let isValid = true;
        let errorMessages = [];
        const fields = [{
                id: "first_name",
                errorId: "first_name_error",
                message: "First name is required (min 2 characters)",
                pattern: /^[A-Za-z\s]{2,}$/,
            },
            {
                id: "last_name",
                errorId: "last_name_error",
                message: "Last name is required (min 2 characters)",
                pattern: /^[A-Za-z\s]{2,}$/,
            },
            {
                id: "email",
                errorId: "email_error",
                message: "Valid email is required",
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            },
            {
                id: "phone",
                errorId: "phone_error",
                message: "Valid phone number is required (8-15 digits)",
                pattern: /^\+?\d{8,15}$/,
            },
            { id: "address", errorId: "address_error", message: "Delivery address is required", pattern: /.+/ },
        ];

        fields.forEach((field) => {
            const input = document.getElementById(field.id);
            const error = document.getElementById(field.errorId);

            if (!input || !error) {
                console.error(`Input or error element not found for field: ${field.id}`);
                isValid = false;
                errorMessages.push(`Field ${field.id} is missing`);
                return;
            }

            if (!input.value || !field.pattern.test(input.value)) {
                error.textContent = field.message;
                input.classList.add("error");
                isValid = false;
                errorMessages.push(field.message);
            } else {
                error.textContent = "";
                input.classList.remove("error");
            }
        });

        // Validate map location
        const latInput = document.getElementById("lat");
        const lngInput = document.getElementById("lng");
        const addressSearchError = document.getElementById("address_search_error");

        if (!mapInitialized || !latInput.value || !lngInput.value || isNaN(latInput.value) || isNaN(lngInput.value)) {
            addressSearchError.textContent = "Please wait for the map to load or select a valid delivery location";
            isValid = false;
            errorMessages.push("Map not initialized or invalid location");
        } else {
            addressSearchError.textContent = "";
        }

        return isValid;
    }

    // Validate phone number for QR payments
    function validatePhoneNumber(phoneId, errorId) {
        const phoneInput = document.getElementById(phoneId);
        const phoneError = document.getElementById(errorId);

        if (!phoneInput || !phoneError) {
            console.error(`Phone input or error element not found: ${phoneId}, ${errorId}`);
            return false;
        }

        if (!phoneInput.value || !/^\+?\d{10,15}$/.test(phoneInput.value)) {
            phoneError.textContent = "Please enter a valid phone number";
            phoneInput.classList.add("error");
            return false;
        } else {
            phoneError.textContent = "";
            phoneInput.classList.remove("error");
            return true;
        }
    }

    // Form validation for card payment
    function validateCardForm() {
        let isValid = true;
        const fields = [{
                id: "card_number",
                errorId: "card_number_error",
                message: "Valid card number is required (16 digits)",
                pattern: /^\d{16}$/,
            },
            {
                id: "expiry_date",
                errorId: "expiry_date_error",
                message: "Valid expiry date is required (MM/YY)",
                pattern: /^(0[1-9]|1[0-2])\/([0-9]{2})$/,
            },
            { id: "cvv", errorId: "cvv_error", message: "Valid CVV is required (3-4 digits)", pattern: /^\d{3,4}$/ },
            {
                id: "card_holder",
                errorId: "card_holder_error",
                message: "Card holder name is required",
                pattern: /^[A-Za-z\s]{2,}$/,
            },
        ];

        fields.forEach((field) => {
            const input = document.getElementById(field.id);
            const error = document.getElementById(field.errorId);

            if (!input || !error) {
                console.error(`Input or error element not found for field: ${field.id}`);
                isValid = false;
                return;
            }

            let value = input.value.replace(/\s/g, "") || "";
            if (field.id === "card_number") {
                value = value.replace(/\D/g, "");
            }

            if (!value || !field.pattern.test(value)) {
                error.textContent = field.message;
                input.classList.add("error");
                isValid = false;
            } else {
                error.textContent = "";
                input.classList.remove("error");
            }
        });

        return isValid;
    }

    // Load order summary
    function loadOrderSummary() {
        if (bookingId) {
            const booking = bookings.find((b) => b.id === bookingId);
            if (booking) {
                itemsSource = booking.items.map((item) => ({
                    ...item,
                    basePrice: item.basePrice || item.totalPrice / item.quantity,
                }));
            } else {
                orderItemsContainer.innerHTML = "<p>Booking not found. Please return to the order page.</p>";
                showToast("Invalid Booking", "The specified booking was not found. Redirecting to order page...", "error");
                setTimeout(() => {
                    window.location.href = "/order";
                }, 3000);
                return;
            }
        } else {
            itemsSource = JSON.parse(localStorage.getItem("cart")) || [];
        }

        let subtotal = 0;
        const itemsHTML = itemsSource
            .map((item) => {
                const itemTotal = item.basePrice * item.quantity;
                subtotal += itemTotal;
                const toppingsText =
                    item.toppings && item.toppings.length > 0 ? item.toppings.map((t) => t.name).join(", ") : "None";
                return `
                  <div class="order-item">
                      <img src="${item.image}" alt="${item.name}">
                      <div class="order-item-details">
                          <h4>${item.name}</h4>
                          <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                          <p>Toppings: ${toppingsText}</p>
                          <p>Quantity: ${item.quantity}</p>
                          <p>Price: ${formatPrice(item.basePrice)}</p>
                          <p>Total: ${formatPrice(itemTotal)}</p>
                      </div>
                  </div>
              `;
            })
            .join("");

        const tax = subtotal * 0.08;
        const total = subtotal + tax;
        currentTotal = total;

        orderItemsContainer.innerHTML = itemsHTML;
        checkoutSubtotal.textContent = formatPrice(subtotal);
        checkoutTax.textContent = formatPrice(tax);
        checkoutTotal.textContent = formatPrice(total);

        // Update payment amount displays
        paymentTotalDisplay.textContent = formatPrice(total);
        if (abaPaymentAmount) abaPaymentAmount.textContent = formatPriceWithoutSymbol(total);
        if (acledaPaymentAmount) acledaPaymentAmount.textContent = formatPriceWithoutSymbol(total);
        if (cardPaymentAmount) cardPaymentAmount.textContent = formatPriceWithoutSymbol(total);
    }

    // Navigate to a specific step
    function goToStep(step) {
        steps.forEach((s) => s.classList.toggle("active", s.dataset.step <= step));
        stepContents.forEach((c) => c.classList.toggle("active", c.id === `step-${step}`));
        
        // Update progress bar
        const progressWidth = step === 1 ? 33.33 : step === 2 ? 66.66 : 100;
        progressBarFill.style.width = `${progressWidth}%`;
        
        // Animate step transition
        const checkoutSteps = document.querySelector(".checkout-steps");
        checkoutSteps.style.opacity = "0";
        setTimeout(() => {
            checkoutSteps.style.opacity = "1";
        }, 300);
        
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    // Show loading modal with progress
    function showLoadingModal(message = "Processing...", showProgress = false) {
        const existingModal = document.querySelector(".loading-modal");
        if (existingModal) existingModal.remove();

        const modal = document.createElement("div");
        modal.className = "loading-modal";
        modal.innerHTML = `
              <div class="loading-spinner">
                  <i class="fas fa-spinner fa-spin"></i>
                  <p>${message}</p>
                  ${showProgress ? '<div class="progress-bar"><div class="progress-bar-fill"></div></div>' : ""}
              </div>
          `;
        document.body.appendChild(modal);
        modal.style.display = "flex";

        if (showProgress) {
            let progress = 0;
            const progressBarFill = modal.querySelector(".progress-bar-fill");
            const interval = setInterval(() => {
                progress += 10;
                progressBarFill.style.width = `${progress}%`;
                if (progress >= 100) {
                    clearInterval(interval);
                }
            }, 200);
        }

        return modal;
    }

    // Hide loading modal
    function hideLoadingModal(modal) {
        modal.style.display = "none";
        modal.remove();
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        let toastContainer = document.querySelector(".toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.className = "toast-container";
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement("div");
        toast.className = `toast ${type}`;
        toast.innerHTML = `
              <div class="toast-icon">
                  <i class="fas fa-${type === "success" ? "check-circle" : type === "error" ? "exclamation-circle" : "info-circle"}"></i>
              </div>
              <div class="toast-content">
                  <h4>${title}</h4>
                  <p>${message}</p>
              </div>
              <button class="toast-close">×</button>
          `;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add("toast-hide");
            setTimeout(() => toast.remove(), 300);
        }, 5000);

        toast.querySelector(".toast-close").addEventListener("click", () => {
            toast.classList.add("toast-hide");
            setTimeout(() => toast.remove(), 300);
        });

        return toast;
    }

    // Show confirmation modal
    function showConfirmationModal(method, phoneNumber = null) {
        pendingPayment = { method, phoneNumber };
        confirmationAmount.textContent = formatPrice(currentTotal);
        confirmationMethod.textContent = {
            card: "Visa Card",
            aba: "ABA Pay",
            acleda: "ACLEDA Pay",
        }[method] || "Unknown";
        confirmationModal.style.display = "flex";
    }

    // Hide confirmation modal
    function hideConfirmationModal() {
        confirmationModal.style.display = "none";
        pendingPayment = null;
    }

    // Process payment
    function processPayment(method, phoneNumber = null) {
        const modal = showLoadingModal("Processing your payment...", true);

        // Store phone number if provided
        if (phoneNumber) {
            paymentPhoneNumberInput.value = phoneNumber;
        }

        // Simulate payment processing (2 seconds)
        setTimeout(() => {
            hideLoadingModal(modal);
            currentTransactionId = generateId("TX");
            updateReceipt(method);
            goToStep(3);
            clearCart();
            showToast("Payment Successful", "Your payment has been processed successfully!", "success");
            showCelebrationAnimation();
        }, 2000);
    }

    // Update receipt
    function updateReceipt(paymentMethod) {
        const firstName = document.getElementById("hidden_first_name").value || "";
        const lastName = document.getElementById("hidden_last_name").value || "";
        const email = document.getElementById("hidden_email").value || "";
        const address = document.getElementById("hidden_address").value || "";
        const phoneNumber = document.getElementById("payment_phone_number").value || "";

        orderNumber.textContent = bookingId || generateId("ORD");
        orderCustomer.textContent = `${firstName} ${lastName}`;
        orderEmail.textContent = email;
        orderAddress.textContent = address;

        const paymentMethodText = {
            card: "Visa Card",
            aba: `ABA Pay (${phoneNumber})`,
            acleda: `ACLEDA Pay (${phoneNumber})`,
        }[paymentMethod] || "Unknown";

        orderPaymentMethod.textContent = paymentMethodText;
        orderTransactionId.textContent = currentTransactionId;

        let subtotal = 0;
        const itemsHTML = itemsSource
            .map((item) => {
                const itemTotal = item.basePrice * item.quantity;
                subtotal += itemTotal;
                const toppingsText =
                    item.toppings && item.toppings.length > 0 ? item.toppings.map((t) => t.name).join(", ") : "None";
                return `
                      <div class="order-item">
                          <img src="${item.image}" alt="${item.name}">
                          <div class="order-item-details">
                              <h4>${item.name}</h4>
                              <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                              <p>Toppings: ${toppingsText}</p>
                              <p>Quantity: ${item.quantity}</p>
                              <p>Price: ${formatPrice(item.basePrice)}</p>
                              <p>Total: ${formatPrice(itemTotal)}</p>
                          </div>
                      </div>
                  `;
            })
            .join("");

        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        orderItemsList.innerHTML = itemsHTML;
        orderSubtotal.textContent = formatPrice(subtotal);
        orderTax.textContent = formatPrice(tax);
        orderTotal.textContent = formatPrice(total);

        // Update booking status
        if (bookingId) {
            const bookingIndex = bookings.findIndex((b) => b.id === bookingId);
            if (bookingIndex !== -1) {
                bookings[bookingIndex].status = "completed";
                bookings[bookingIndex].paymentStatus = "completed";
                bookings[bookingIndex].paymentMethod = paymentMethod;
                bookings[bookingIndex].customer = {
                    firstName,
                    lastName,
                    email,
                    address,
                    phoneNumber,
                };
                bookings[bookingIndex].checkoutTimestamp = new Date().toISOString();
                localStorage.setItem("bookings", JSON.stringify(bookings));
            }
        }
    }

    // Clear cart after successful payment
    function clearCart() {
        localStorage.removeItem("cart");
        if (bookingId) {
            const bookingIndex = bookings.findIndex((b) => b.id === bookingId);
            if (bookingIndex !== -1) {
                bookings[bookingIndex].cartCleared = true;
                localStorage.setItem("bookings", JSON.stringify(bookings));
            }
        }
    }

    // Show celebration animation
    function showCelebrationAnimation() {
        const celebrationContainer = document.createElement("div");
        celebrationContainer.className = "celebration-animation";
        document.body.appendChild(celebrationContainer);

        const colors = ["#ff6769", "#4caf50", "#2196f3", "#f44336", "#ff9800"];
        for (let i = 0; i < 50; i++) {
            const confetti = document.createElement("div");
            confetti.className = "confetti";
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.width = `${Math.random() * 10 + 5}px`;
            confetti.style.height = `${Math.random() * 10 + 5}px`;
            confetti.style.left = `${Math.random() * 100}vw`;
            confetti.style.animationDuration = `${Math.random() * 2 + 1}s`;
            confetti.style.animationDelay = `${Math.random() * 0.5}s`;
            celebrationContainer.appendChild(confetti);
        }

        setTimeout(() => {
            celebrationContainer.classList.add("fade-out");
            setTimeout(() => celebrationContainer.remove(), 1000);
        }, 3000);
    }

    // Event Listeners
    customerForm.addEventListener("submit", (e) => {
        e.preventDefault();
        if (validateForm()) {
            // Store customer details in hidden fields
            document.getElementById("hidden_first_name").value = document.getElementById("first_name").value;
            document.getElementById("hidden_last_name").value = document.getElementById("last_name").value;
            document.getElementById("hidden_email").value = document.getElementById("email").value;
            document.getElementById("hidden_phone").value = document.getElementById("phone").value;
            document.getElementById("hidden_address").value = document.getElementById("address").value;
            document.getElementById("hidden_notes").value = document.getElementById("notes").value;
            document.getElementById("hidden_lat").value = document.getElementById("lat").value;
            document.getElementById("hidden_lng").value = document.getElementById("lng").value;
            document.getElementById("hidden_formatted_address").value = document.getElementById("formatted_address").value;

            goToStep(2);
            showToast("Success", "Customer details saved. Please select a payment method.", "success");
        }
    });

    paymentOptions.forEach((option) => {
        option.addEventListener("click", () => {
            paymentOptions.forEach((opt) => opt.classList.remove("active"));
            option.classList.add("active");
            const method = option.dataset.method;
            selectedPaymentMethodInput.value = method;

            document.querySelectorAll(".payment-method-content").forEach((content) => {
                content.style.display = "none";
            });
            document.getElementById("payment-method-default").style.display = "none";
            document.getElementById(`${method}_payment_content`).style.display = "block";
        });
    });

    backToCustomerBtn.addEventListener("click", () => {
        goToStep