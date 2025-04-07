<div class="col-xl-6 col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Recent Receipts</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Receipt Actions:</div>
                    <a class="dropdown-item" href="/admin/receipts">View All Receipts</a>
                    <a class="dropdown-item" href="/admin/receipts/export-csv">Export to CSV</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentReceipts as $receipt): ?>
                        <tr>
                            <td><a href="/admin/receipts/download/<?= $receipt['receipt_id'] ?>">#<?= $receipt['receipt_id'] ?></a></td>
                            <td><?= htmlspecialchars($receipt['username']) ?></td>
                            <td><?= date('M d, Y', strtotime($receipt['order_date'])) ?></td>
                            <td>$<?= number_format($receipt['amount'], 2) ?></td>
                            <td>
                                <span class="badge <?= $receipt['payment_status'] == 'Paid' ? 'badge-success' : 'badge-warning' ?>">
                                    <?= htmlspecialchars($receipt['payment_status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentReceipts)): ?>
                        <tr>
                            <td colspan="5" class="text-center">No recent receipts</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-center">
                <a href="/admin/receipts" class="btn btn-primary btn-sm">View All Receipts</a>
            </div>
        </div>
    </div>
</div>