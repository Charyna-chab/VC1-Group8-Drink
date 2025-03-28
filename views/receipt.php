<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

<section class="content">
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="receipt-actions">
                <button id="print-receipt" class="btn-outline">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                <a href="/receipt/download/<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : ''; ?>" class="btn-outline">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <a href="/booking" class="btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
            <h2>Order Receipt</h2>
            <p>Order #<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'New Order'; ?></p>
        </div>

        <div class="receipt-content" id="receipt-printable">
            <div class="receipt-brand">
                <img src="/assets/image/logo/logo.png" alt="Xing Fu Cha Logo" class="receipt-logo">
                <h3>Xing Fu Cha</h3>
                <p>Bubble Tea & Coffee</p>
            </div>
            
            <div class="receipt-info">
                <div class="receipt-info-item">
                    <span>Order Number:</span>
                    <span id="receipt-order-number">#<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : 'New Order'; ?></span>
                </div>
                <div class="receipt-info-item">
                    <span>Date:</span>
                    <span id="receipt-date">Loading...</span>
                </div>
                <div class="receipt-info-item">
                    <span>Payment Method:</span>
                    <span id="receipt-payment-method">Loading...</span>
                </div>
                <div class="receipt-info-item">
                    <span>Status:</span>
                    <span id="receipt-status">Loading...</span>
                </div>
            </div>
            
            <div class="receipt-divider"></div>
            
            <div class="receipt-items">
                <h4>Order Items</h4>
                <div id="receipt-items-list">
                    <!-- Items will be loaded dynamically -->
                    <div class="receipt-loading">Loading order items...</div>
                </div>
            </div>
            
            <div class="receipt-divider"></div>
            
            <div class="receipt-summary">
                <div class="receipt-summary-item">
                    <span>Subtotal:</span>
                    <span id="receipt-subtotal">$0.00</span>
                </div>
                <div class="receipt-summary-item">
                    <span>Tax (8%):</span>
                    <span id="receipt-tax">$0.00</span>
                </div>
                <div class="receipt-summary-item total">
                    <span>Total:</span>
                    <span id="receipt-total">$0.00</span>
                </div>
            </div>
            
            <div class="receipt-footer">
                <p>Thank you for your order!</p>
                <p>Visit us again at Xing Fu Cha</p>
                <p>123 Main Street, City, Country</p>
                <p>Tel: +1 (555) 123-4567</p>
            </div>
        </div>
    </div>
</section>

<!-- Include CSS files -->
<link rel="stylesheet" href="/assets/css/receipt.css">

<!-- Include JavaScript files -->
<script src="/assets/js/receipt.js"></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>

