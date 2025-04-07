<?php include 'views/admin/partials/header.php'; ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order List</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm mr-2">
                <i class="fas fa-download fa-sm text-primary-50"></i> Export
            </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> New Order
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="ordersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['id']) ?></td>
                                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                    <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                                    <td>
                                        <span class="badge badge-<?= getStatusClass($order['status']) ?>">
                                            <?= ucfirst(htmlspecialchars($order['status'])) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($order['item_count']) ?></td>
                                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td class="text-center">
                                        <a href="/order-list/details/<?= $order['id'] ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Helper function to get appropriate Bootstrap badge class based on status
function getStatusClass($status) {
    switch ($status) {
        case 'completed':
            return 'success';
        case 'processing':
            return 'primary';
        case 'pending':
            return 'warning';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>

<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            order: [[2, 'desc']]
        });
    });
</script>

<?php include 'views/admin/partials/footer.php'; ?>