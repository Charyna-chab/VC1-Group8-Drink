<?php require_once 'partials/header.php'; ?>

<div class="container mt-4">
    <h2>Your Receipts</h2>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Receipt ID</th>
                    <th>Order Date</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receipts as $receipt): ?>
                <tr>
                    <td><?= htmlspecialchars($receipt['receipt_id']) ?></td>
                    <td><?= date('M d, Y', strtotime($receipt['order_date'])) ?></td>
                    <td><?= htmlspecialchars($receipt['product_name']) ?></td>
                    <td>$<?= number_format($receipt['price'], 2) ?></td>
                    <td><?= htmlspecialchars($receipt['payment_status']) ?></td>
                    <td>
                        <a href="/receipt/download/<?= $receipt['receipt_id'] ?>" class="btn btn-sm btn-primary">Download</a>
                        <a href="/receipt/delete/<?= $receipt['receipt_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>