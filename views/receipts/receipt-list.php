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
            background-color: #fff;
        }

        #content {
            width: 100%;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            background-color: #fff;
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

        <div id="content" class="bg-white">  <!-- Changed to bg-white -->
            <?php require './views/admin/Partials/navbar.php' ?>

        <div class="container-fluid mt-4 px-4">  <!-- Added px-4 for side padding -->
            <h2 class="mb-4 text-dark">Your Receipts</h2>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
    
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white border-bottom">  <!-- Added border-bottom -->
                    <h4 class="m-0 font-weight-bold text-dark">Receipt History</h4>
                    <div class="search-container" style="width: 350px;">  <!-- Increased width -->
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control form-control-lg border" placeholder="Search receipts...">
                            <div class="input-group-append">
                                <button class="btn btn-primary px-4" type="button" id="searchButton">  <!-- Added px-4 -->
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg m-0">  <!-- Removed table-striped -->
                            <thead class="bg-light">  <!-- Light gray header -->
                                <tr>
                                    <th class="py-3 px-4 text-dark font-weight-bold" style="width: 15%;">Receipt ID</th>
                                    <th class="py-3 px-4 text-dark font-weight-bold" style="width: 15%;">Order Date</th>
                                    <th class="py-3 px-4 text-dark font-weight-bold" style="width: 25%;">Product Receipt</th>
                                    <th class="py-3 px-4 text-dark font-weight-bold" style="width: 10%;">Amount</th>
                                    <th class="py-3 px-4 text-dark font-weight-bold" style="width: 15%;">Status</th>
                                    <th class="py-3 px-4 text-dark font-weight-bold" style="width: 20%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($receipts)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 font-weight-bold h5 text-muted">No receipts found</td>  <!-- Changed to text-muted -->
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($receipts as $receipt): ?>
                                        <tr class="border-bottom">  <!-- Added border-bottom -->
                                            <td class="py-3 px-4 align-middle text-dark"><?= htmlspecialchars($receipt['receipt_id']) ?></td>
                                            <td class="py-3 px-4 align-middle text-dark"><?= date('M d, Y', strtotime($receipt['order_date'])) ?></td>
                                            <td class="py-3 px-4 align-middle text-dark"><?= htmlspecialchars($receipt['product_name']) ?></td>
                                            <td class="py-3 px-4 align-middle text-dark font-weight-bold">$<?= number_format($receipt['amount'], 2) ?></td>
                                            <td class="py-3 px-4 align-middle">
                                                <span class="badge badge-pill <?= $receipt['payment_status'] == 'Paid' ? 'badge-success' : 'badge-warning' ?> p-2">
                                                    <?= htmlspecialchars($receipt['payment_status']) ?>
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 align-middle">
                                                <a href="/receipt/download/<?= $receipt['receipt_id'] ?>" class="btn btn-primary btn-sm mx-1">  <!-- Changed to btn-sm -->
                                                    <i class="fas fa-download"></i> View
                                                </a>
                                                <a href="/receipt/delete/<?= $receipt['receipt_id'] ?>" class="btn btn-danger btn-sm mx-1">
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
    </script>
</body>
</html>