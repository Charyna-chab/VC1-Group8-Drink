<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Delete Receipt #<?= $receipt['receipt_id'] ?></h4>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <h5><i class="fas fa-exclamation-triangle"></i> Warning!</h5>
                <p>Are you sure you want to delete this receipt? This action cannot be undone.</p>
            </div>
            
            <div class="receipt-details mb-4">
                <p><strong>Receipt ID:</strong> #<?= $receipt['receipt_id'] ?></p>
                <p><strong>Order Date:</strong> <?= date('M d, Y', strtotime($receipt['order_date'])) ?></p>
                <p><strong>Product:</strong> <?= $receipt['product_name'] ?></p>
                <p><strong>Amount:</strong> $<?= number_format($receipt['amount'], 2) ?></p>
                <p><strong>Payment Status:</strong> <?= $receipt['payment_status'] ?></p>
            </div>
            
            <form method="POST" action="/receipt/delete/<?= $receipt['receipt_id'] ?>">
                <div class="d-flex justify-content-between">
                    <a href="/receipt" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Confirm Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>