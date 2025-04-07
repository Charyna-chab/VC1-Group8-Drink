<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Delete Receipt'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
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

        @media (max-width: 768px) {
            #sidebarToggleTop {
                display: block;
            }
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php require_once 'views/admin/Partials/sidebar.php'; ?>   
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require_once 'views/admin/Partials/navbar.php'; ?>     
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Delete Receipt #<?= $receipt['receipt_id'] ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger">
                                <h5><i class="fas fa-exclamation-triangle"></i> Warning!</h5>
                                <p>Are you sure you want to delete this receipt? This action cannot be undone.</p>
                            </div>
                            
                            <div class="receipt-details mb-4">
                                <p><strong>Receipt ID:</strong> #<?= $receipt['receipt_id'] ?></p>
                                <p><strong>Customer:</strong> <?= $receipt['username'] ?></p>
                                <p><strong>Order Date:</strong> <?= date('M d, Y', strtotime($receipt['order_date'])) ?></p>
                                <p><strong>Product:</strong> <?= $receipt['product_name'] ?></p>
                                <p><strong>Amount:</strong> $<?= number_format($receipt['amount'], 2) ?></p>
                                <p><strong>Payment Status:</strong> <?= $receipt['payment_status'] ?></p>
                            </div>
                            
                            <form method="POST" action="/admin/receipts/delete/<?= $receipt['receipt_id'] ?>">
                                <div class="d-flex justify-content-between">
                                    <a href="/admin/receipts" class="btn btn-secondary">
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
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; XING FU CHA 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/assets/js/sb-admin-2.min.js"></script>
</body>
</html>