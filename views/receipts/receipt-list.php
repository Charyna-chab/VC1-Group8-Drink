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
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Receipt History</h6>
        </div>
        <div class="card-body">
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
                        <?php if (empty($receipts)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No receipts found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($receipts as $receipt): ?>
                                <tr>
                                    <td><?= htmlspecialchars($receipt['receipt_id']) ?></td>
                                    <td><?= date('M d, Y', strtotime($receipt['order_date'])) ?></td>
                                    <td><?= htmlspecialchars($receipt['product_name']) ?></td>
                                    <td>$<?= number_format($receipt['amount'], 2) ?></td>
                                    <td>
                                        <span class="badge <?= $receipt['payment_status'] == 'Paid' ? 'badge-success' : 'badge-warning' ?>">
                                            <?= htmlspecialchars($receipt['payment_status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/receipt/download/<?= $receipt['receipt_id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download"></i> View
                                        </a>
                                        <a href="/receipt/delete/<?= $receipt['receipt_id'] ?>" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
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