<?php
// views/order_list.php
require_once __DIR__ . '/../views/layouts/header.php';
require_once __DIR__ . '/../views/layouts/sidebar.php';
?>

<section class="content">
    <div class="order-list-container">
        <div class="order-list-header">
            <h2>Order List</h2>
        </div>

        <div class="order-list-content">
            <!-- Check if there are any orders -->
            <?php if (count($orders) > 0): ?>
            <table class="order-list-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                        <td><?php echo ucfirst($order['status']); ?></td>
                        <td>
                            <a href="/order/details?id=<?php echo $order['order_id']; ?>" class="btn-view-details">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <!-- You can add more actions like edit, delete, etc. -->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </div>  
</section>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script src="/assets/js/order_list.js"></script>
