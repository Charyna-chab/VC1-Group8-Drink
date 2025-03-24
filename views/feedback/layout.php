<?php 
include '../layout/header.php';
require_once '../config/db.php'; // Database connection
require_once '../auth/check_auth.php'; // Authentication check

// Log admin access to feedback page
$admin_id = $_SESSION['admin_id'] ?? 0;
$stmt = $conn->prepare("INSERT INTO access_logs (admin_id, page_accessed, access_time) VALUES (?, 'feedback', NOW())");
$stmt->execute([$admin_id]);

// Handle filters
$search = $_GET['search'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Build query with filters
$query = "SELECT f.*, u.name as customer_name 
          FROM feedback f 
          LEFT JOIN users u ON f.user_id = u.id 
          WHERE 1=1";

$params = [];

if (!empty($search)) {
    $query .= " AND (u.name LIKE ? OR f.message LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($date_from)) {
    $query .= " AND f.created_at >= ?";
    $params[] = $date_from;
}

if (!empty($date_to)) {
    $query .= " AND f.created_at <= ?";
    $params[] = $date_to . ' 23:59:59';
}

$query .= " ORDER BY f.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Customer Feedback</h1>
    <p class="mb-4">View and manage customer feedback submissions.</p>

    <!-- Feedback Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
        </div>
        <div class="card-body">
            <form method="get" action="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Search (Name or Message)</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="<?= htmlspecialchars($search) ?>" placeholder="Search...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">From Date</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="<?= htmlspecialchars($date_from) ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">To Date</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="<?= htmlspecialchars($date_to) ?>">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mb-3">Apply</button>
                        <a href="/feedback" class="btn btn-secondary mb-3 ml-2">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Feedback Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Feedback</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Message</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedback as $item): ?>
                        <tr>
                            <td><?= !empty($item['customer_name']) ? htmlspecialchars($item['customer_name']) : 'Guest' ?></td>
                            <td><?= date('M j, Y g:i a', strtotime($item['created_at'])) ?></td>
                            <td><?= nl2br(htmlspecialchars($item['message'])) ?></td>
                            <td>
                                <?php if (!empty($item['rating'])): ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $item['rating']): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($feedback)): ?>
                        <tr>
                            <td colspan="4" class="text-center">No feedback found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include '../layout/footer.php'; ?>

<!-- Page level plugins -->
<script src="/assets/vendor/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "order": [[1, "desc"]], // Default sort by date descending
        "columnDefs": [
            { "orderable": false, "targets": [2, 3] } // Disable sorting for message and rating columns
        ]
    });
});
</script>