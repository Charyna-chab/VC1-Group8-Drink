<?php require_once './views/admin/Partials/header.php'?>
<?php
// Start the session
// session_start();
$products = $products ?? [];
$totalPrice = $totalPrice ?? 0;
$totalProducts = $totalProducts ?? 0;
$totalorders = $totalorders ?? 0; // Example value, replace with actual data
$pendingRequests = 18; // You can update this to be dynamic if needed

// Retrieve the total from the session, default to 0 if not set
$total = isset($_SESSION['product_total']) ? $_SESSION['product_total'] : 0;
$product_count = $_SESSION['product_count'] ?? 0;
?>

<body id="page-top">
    <div id="wrapper">
        <?php require './views/admin/Partials/sidebar.php' ?>
        <?php require './views/admin/Partials/navbar.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Order Total (Monthly)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <span><?= htmlspecialchars($totalorders) ?></span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Price Product -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Price Product</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        $<span id="total-price"><?= number_format($totalPrice, 2) ?></span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Product -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Product</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <span><?= $totalProducts ?></span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Requests</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingRequests ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <!-- Area Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Total Price
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Total Product
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-warning"></i> Requests
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Scripts -->
        <script src="/assets/vendor/jquery/jquery.min.js"></script>
        <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="/assets/js/sb-admin-2.min.js"></script>
        <script src="/assets/vendor/chart.js/Chart.min.js"></script>

        <!-- Pass PHP to JS -->
        <script>
            const totalPrice = <?= json_encode($totalPrice) ?>;
            const totalProducts = <?= json_encode($totalProducts) ?>;
            const pendingRequests = <?= json_encode($pendingRequests) ?>;
        </script>

        <!-- Pie Chart Script -->
        <script>
            const ctxPie = document.getElementById("myPieChart").getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ["Total Price Product", "Total Product", "Pending Requests"],
                    datasets: [{
                        data: [totalPrice, totalProducts, pendingRequests],
                        backgroundColor: ['#1cc88a', '#1FCAF5', '#f6c23e'],
                        hoverBackgroundColor: ['#1cc88a', '#1FCAF5', '#f4b619'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });
        </script>

        <!-- Optional: Area chart if needed -->
        <script src="/assets/js/demo/chart-area-demo.js"></script>


</body>

</html>