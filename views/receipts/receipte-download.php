<?php require_once 'partials/header.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Receipt #<?= $receipt['receipt_id'] ?></h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Order Information</h5>
                    <p><strong>Date:</strong> <?= date('M d, Y H:i', strtotime($receipt['order_date'])) ?></p>
                    <p><strong>Product:</strong> <?= $receipt['product_name'] ?></p>
                    <p><strong>Amount:</strong> $<?= number_format($receipt['amount'], 2) ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Payment Information</h5>
                    <p><strong>Method:</strong> <?= $receipt['payment_method'] ?></p>
                    <p><strong>Status:</strong> <?= $receipt['payment_status'] ?></p>
                    <p><strong>Transaction ID:</strong> <?= $receipt['transaction_id'] ?></p>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                <a href="/receipt" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>