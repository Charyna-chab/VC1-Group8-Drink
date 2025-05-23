<?php require_once __DIR__ . '/../admin/Partials/header.php';?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/../admin/Partials/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php require_once __DIR__ . '/../admin/Partials/header.php'; ?>
                <!-- End of Topbar -->

                <!-- Main Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Order List</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User Name</th>
                                            <th>Product Name</th>
                                            <th>Total Price</th>
                                            <th>Total Order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $index => $order): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($order['user_name']) ?></td>
                                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                                <td>$<?= number_format($order['total_price'], 2) ?></td>
                                                <td><?= $order['quantity'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/assets/js/sb-admin-2.min.js"></script>
</body>

</html>