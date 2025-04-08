<?php
// views/admin/order_details.php
require_once __DIR__ . '/../../layouts/admin_header.php';
require_once __DIR__ . '/../../layouts/admin_sidebar.php';
?>

<section class="content">
    <div class="order-details-container">
        <div class="order-details-header">
            <h2>Order Details</h2>
            <div class="header-actions">
                <a href="/admin/order-list" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="/admin/order/edit/<?= $order['order_id']; ?>" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Order
                </a>
            </div>
        </div>

        <div class="order-details-content">
            <div class="order-info">
                <h3>Order Information</h3>
                <div class="info-group">
                    <div class="info-item">
                        <span class="label">Order ID:</span>
                        <span class="value"><?= $order['order_id']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Order Date:</span>
                        <span class="value"><?= $order['order_date']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Drink Size:</span>
                        <span class="value"><?= $order['drink_size']; ?></span>
                    </div>
                </div>
            </div>

            <div class="product-info">
                <h3>Product Information</h3>
                <div class="info-group">
                    <div class="info-item">
                        <span class="label">Product ID:</span>
                        <span class="value"><?= $product['product_id']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Product Name:</span>
                        <span class="value"><?= $product['product_name']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Price:</span>
                        <span class="value">$<?= number_format($product['price'], 2); ?></span>
                    </div>
                </div>
                <?php if (!empty($product['image'])): ?>
                <div class="product-image">
                    <img src="data:image/jpeg;base64,<?= base64_encode($product['image']); ?>" alt="<?= $product['product_name']; ?>">
                </div>
                <?php endif; ?>
            </div>

            <div class="customer-info">
                <h3>Customer Information</h3>
                <div class="info-group">
                    <div class="info-item">
                        <span class="label">Customer ID:</span>
                        <span class="value"><?= $user['user_id']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Name:</span>
                        <span class="value"><?= $user['name']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Email:</span>
                        <span class="value"><?= $user['email']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Phone:</span>
                        <span class="value"><?= $user['phone']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Order details styles */
.order-details-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.order-details-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}

.header-actions {
    display: flex;
    gap: 10px;
}

.btn-back {
    background-color: #f1f1f1;
    color: #333;
    border: 1px solid #ddd;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-back i {
    margin-right: 5px;
}

.order-details-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

@media (min-width: 768px) {
    .order-details-content {
        grid-template-columns: 1fr 1fr;
    }
}

.order-info,
.product-info,
.customer-info {
    background-color: #f9f9f9;
    border-radius: 6px;
    padding: 15px;
}

.order-info h3,
.product-info h3,
.customer-info h3 {
    margin-top: 0;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    color: #333;
}

.info-group {
    display: grid;
    gap: 10px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
}

.value {
    font-size: 16px;
    color: #333;
    font-weight: 500;
}

.product-image {
    margin-top: 15px;
    text-align: center;
}

.product-image img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 4px;
}
</style>

<?php require_once __DIR__ . '/../../layouts/admin_footer.php'; ?>