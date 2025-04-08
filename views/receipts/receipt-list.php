<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Product List'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <style>
        body {
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
        }

        #content {
            width: 100%;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
        }

        .dropdown-toggle::after {
            display: none;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                width: 100%;
            }
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require './views/admin/Partials/sidebar.php' ?>

        <div id="content" class="bg-light">
            <?php require './views/admin/Partials/navbar.php' ?>

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
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Receipt History</h6>
                    <div class="search-container">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search receipts...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="searchButton">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
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

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchButton').click(function() {
                filterTable();
            });

            $('#searchInput').keyup(function(e) {
                if (e.key === 'Enter') {
                    filterTable();
                }
            });

            function filterTable() {
                const value = $('#searchInput').val().toLowerCase();
                $('tbody tr').each(function() {
                    const $row = $(this);
                    if ($row.text().toLowerCase().indexOf(value) > -1) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            }
        });
        $(document).ready(function() {
        // Search functionality
        $('#searchButton').click(function() {
            filterTable();
        });

        $('#searchInput').keyup(function(e) {
            // Search on each keystroke
            filterTable();
        });

        function filterTable() {
            const value = $('#searchInput').val().toLowerCase();
            $('tbody tr').each(function() {
                const $row = $(this);
                let found = false;
                
                // Check each cell in the row (except actions column)
                $row.find('td:not(:last-child)').each(function() {
                    if ($(this).text().toLowerCase().includes(value)) {
                        found = true;
                        return false; // break the loop if found
                    }
                });
                
                if (found || value === '') {
                    $row.show();
                } else {
                    $row.hide();
                }
            });
        }
    });
    </script>
</body>

</html>
