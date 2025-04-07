<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Receipt #<?= $receipt['receipt_id'] ?></h4>
            <div>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Print
                </button>
                <a href="/receipt" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="receipt-container p-4 border rounded">
                <div class="text-center mb-4">
                    <h2>XING FU CHA</h2>
                    <p>123 Bubble Tea Street, Tea City</p>
                    <p>Tel: (123) 456-7890</p>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Receipt Information</h5>
                        <p><strong>Receipt ID:</strong> #<?= $receipt['receipt_id'] ?></p>
                        <p><strong>Date:</strong> <?= date('M d, Y H:i', strtotime($receipt['order_date'])) ?></p>
                        <p><strong>Transaction ID:</strong> <?= $receipt['transaction_id'] ?></p>
                    </div>
                </div>
                
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $receipt['product_name'] ?></td>
                                <td class="text-right">$<?= number_format($receipt['amount'], 2) ?></td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Total</strong></td>
                                <td class="text-right"><strong>$<?= number_format($receipt['amount'], 2) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Payment Information</h5>
                        <p><strong>Method:</strong> <?= $receipt['payment_method'] ?></p>
                        <p><strong>Status:</strong> <?= $receipt['payment_status'] ?></p>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p>Thank you for your purchase!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>

