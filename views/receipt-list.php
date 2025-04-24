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
                    <span id="receipt-date"><?php echo date('F j, Y h:i A'); ?></span>
                </div>
                <div class="receipt-info-item">
                    <span>Payment Method:</span>
                    <span id="receipt-payment-method">
                        <?php 
                            if (isset($receipt) && isset($receipt['payment_method'])) {
                                $method = $receipt['payment_method'];
                                switch ($method) {
                                    case 'card':
                                        echo 'Credit/Debit Card';
                                        break;
                                    case 'aba':
                                        echo 'ABA Pay';
                                        break;
                                    case 'acleda':
                                        echo 'ACLEDA Pay';
                                        break;
                                    case 'cash':
                                        echo 'Cash on Delivery';
                                        break;
                                    default:
                                        echo $method;
                                }
                            } else {
                                echo 'Not specified';
                            }
                        ?>
                    </span>
                </div>
                <div class="receipt-info-item">
                    <span>Status:</span>
                    <span id="receipt-status" class="<?php echo isset($receipt) && isset($receipt['status']) ? $receipt['status'] : 'processing'; ?>">
                        <?php 
                            if (isset($receipt) && isset($receipt['status'])) {
                                echo ucfirst($receipt['status']);
                            } else {
                                echo 'Processing';
                            }
                        ?>
                    </span>
                </div>
            </div>
            
            <div class="receipt-divider"></div>
            
            <div class="receipt-items">
                <h4>Order Items</h4>
                <div id="receipt-items-list">
                    <?php if (isset($receipt) && isset($receipt['items']) && !empty($receipt['items'])): ?>
                        <?php foreach ($receipt['items'] as $item): ?>
                            <div class="receipt-item">
                                <div class="receipt-item-details">
                                    <h5><?php echo htmlspecialchars($item['name']); ?> <span class="receipt-item-quantity">x<?php echo $item['quantity']; ?></span></h5>
                                    <p>Size: <?php echo htmlspecialchars($item['size']['name']); ?> | Sugar: <?php echo htmlspecialchars($item['sugar']['name']); ?> | Ice: <?php echo htmlspecialchars($item['ice']['name']); ?></p>
                                    <p>Toppings: 
                                        <?php 
                                            if (isset($item['toppings']) && !empty($item['toppings'])) {
                                                $toppingNames = array_map(function($topping) {
                                                    return $topping['name'];
                                                }, $item['toppings']);
                                                echo htmlspecialchars(implode(', ', $toppingNames));
                                            } else {
                                                echo 'None';
                                            }
                                        ?>
                                    </p>
                                </div>
                                <div class="receipt-item-price">
                                    $<?php echo number_format($item['totalPrice'], 2); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="receipt-loading">Loading order items...</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="receipt-divider"></div>
            
            <div class="receipt-summary">
                <div class="receipt-summary-item">
                    <span>Subtotal:</span>
                    <span id="receipt-subtotal">
                        $<?php echo isset($receipt) && isset($receipt['subtotal']) ? number_format($receipt['subtotal'], 2) : '0.00'; ?>
                    </span>
                </div>
                <div class="receipt-summary-item">
                    <span>Tax (8%):</span>
                    <span id="receipt-tax">
                        $<?php echo isset($receipt) && isset($receipt['tax']) ? number_format($receipt['tax'], 2) : '0.00'; ?>
                    </span>
                </div>
                <div class="receipt-summary-item total">
                    <span>Total:</span>
                    <span id="receipt-total">
                        $<?php echo isset($receipt) && isset($receipt['total']) ? number_format($receipt['total'], 2) : '0.00'; ?>
                    </span>
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
