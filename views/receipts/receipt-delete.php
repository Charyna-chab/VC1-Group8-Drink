<?php require_once 'partials/header.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Delete Receipt #<?= $receipt['receipt_id'] ?></h4>
        </div>
        <div class="card-body">
            <p>Are you sure you want to delete this receipt?</p>
            <p><strong>Order Date:</strong> <?= date('M d, Y', strtotime($receipt['order_date'])) ?></p>
            <p><strong>Product:</strong> <?= $receipt['product_name'] ?></p>
            <p><strong>Amount:</strong> $<?= number_format($receipt['amount'], 2) ?></p>
            
            <form method="POST" action="/receipt/delete/<?= $receipt['receipt_id'] ?>">
                <button type="submit" class="btn btn-danger">Confirm Delete</button>
                <a href="/receipt" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>