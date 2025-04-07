<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Receipt Details'; ?></title>
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

        .receipt-container {
            background-color: white;
            max-width: 800px;
            margin: 0 auto;
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
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Receipt #<?= $receipt['receipt_id'] ?></h6>
                            <div>
                                <button onclick="window.print()" class="btn btn-sm btn-primary">
                                    <i class="fas fa-print"></i> Print
                                </button>
                                <button onclick="generatePDF()" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-pdf"></i> Save as PDF
                                </button>
                                <a href="/admin/receipts" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="receipt-container" class="receipt-container p-4 border rounded">
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
                                    <div class="col-md-6">
                                        <h5>Customer Information</h5>
                                        <p><strong>Name:</strong> <?= $receipt['username'] ?></p>
                                        <p><strong>Email:</strong> <?= $receipt['email'] ?></p>
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
                                    <p class="small text-muted">This is an official receipt from Xing Fu Cha.</p>
                                </div>
                            </div>
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

    <!-- PDF Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function generatePDF() {
            // Get the receipt container
            const element = document.getElementById('receipt-container');
            
            // Configure html2pdf options
            const opt = {
                margin: 1,
                filename: 'receipt-<?= $receipt['receipt_id'] ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            
            // Generate and download PDF
            html2pdf().set(opt).from(element).save();
        }

        // Add print-specific styles
        window.onbeforeprint = function() {
            document.querySelectorAll('.btn, .no-print').forEach(el => {
                el.style.display = 'none';
            });
        };

        window.onafterprint = function() {
            document.querySelectorAll('.btn, .no-print').forEach(el => {
                el.style.display = '';
            });
        };
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #receipt-container, #receipt-container * {
                visibility: visible;
            }
            #receipt-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</body>
</html>