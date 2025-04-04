<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/navbar.php'; ?>
<?php require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?? 'Order List'; ?></h1>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
            <div>
                <select id="statusFilter" class="form-control form-control-sm">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="orderTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No orders found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td>
                                    <?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?><br>
                                    <small><?php echo htmlspecialchars($order['customer_email'] ?? ''); ?></small>
                                </td>
                                <td>
                                    <ul class="list-unstyled">
                                        <?php if (isset($order['items']) && is_array($order['items'])): ?>
                                            <?php foreach ($order['items'] as $item): ?>
                                                <li><?php echo htmlspecialchars($item['product_name']) . ' x ' . $item['quantity']; ?></li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li>No items</li>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo getStatusBadgeClass($order['status']); ?>">
                                        <?php echo ucfirst($order['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <a href="/order-list/details?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <form method="POST" action="/update-order-status" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <select name="status" class="form-control form-control-sm status-select mt-1">
                                            <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                            <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                                    </form>
                                    <form method="POST" action="/delete-order" class="d-inline mt-1" onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Helper function to get appropriate badge class based on status
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'info';
        case 'completed':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>

<script src="/assets/js/order-list.js"></script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>