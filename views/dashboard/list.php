<?php
// Start the session
session_start();
$products = $products ?? [];

// Retrieve the total from the session, default to 0 if not set
$total = isset($_SESSION['product_total']) ? $_SESSION['product_total'] : 0;
$product_count = $_SESSION['product_count'] ?? 0;
?>
<body id="page-top">
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
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
                                        Earnings (Monthly)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Price Product</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">

                                        $<span id="total-price"><?= number_format($total, 2) ?></span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Product
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <span><?= $product_count ?></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Requests</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Dropdown Header:</div>
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Dropdown Header:</div>
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Direct
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Social
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Referral
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


           
            <div class="card shadow mb-4 ml-3 mr-3">
                <div class="card-header py-3">

                    <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Product Detail</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div class="d-flex justify-content-end">
                                    <form class="form-inline">
                                        <div class="input-group mb-3 border" style="max-width: 250px;">
                                            <input type="text" class="form-control form-control-sm bg-light border-0" placeholder="Search...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-sm" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php foreach ($products as $index => $product): ?>
                                    <tr>
                                        <td><?= 1 + $index ?></td>
                                        <td>
                                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="" style="width: 50px; height: 50px; border-radius: 10px; object-fit: cover;">
                                        </td>
                                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                                        <td><?= htmlspecialchars($product['product_detail']) ?></td>
                                        <td><?= htmlspecialchars($product['price']) ?></td>
                                        <td>
                                            <a href="/product/edit?id=<?= $product['product_id'] ?>" class="btn btn-warning">Edit</a>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                Remove
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Remove Product</h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                            <a href="/product/delete?product_id=<?= $product['product_id'] ?>" type="button" class="btn btn-danger">Yes</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                            </tbody>
                        </table>



                        <?php '../layout/footer.php'; ?>
                        <!-- Add this before the closing body tag -->
                        <script>
                            // Improved search function that sorts matching products to the top
                            document.addEventListener('DOMContentLoaded', function() {
                                const searchInput = document.querySelector('input[placeholder="Search..."]');
                                const tableBody = document.querySelector('tbody');

                                // Store the original order of rows
                                const originalRows = Array.from(tableBody.querySelectorAll('tr'));

                                searchInput.addEventListener('keyup', function() {
                                    const searchTerm = this.value.toLowerCase().trim();

                                    if (searchTerm === '') {
                                        // If search is empty, restore original order
                                        restoreOriginalOrder();
                                        return;
                                    }

                                    // Create an array to hold rows and their match scores
                                    const rowsWithScores = [];

                                    originalRows.forEach(row => {
                                        const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                                        const productName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                                        const productDetail = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                                        const price = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

                                        // Calculate match score (higher is better match)
                                        let score = 0;

                                        // Exact matches get highest score
                                        if (id === searchTerm) score += 100;
                                        if (productName === searchTerm) score += 100;
                                        if (productDetail === searchTerm) score += 100;
                                        if (price === searchTerm) score += 100;

                                        // Partial matches get lower scores
                                        if (id.includes(searchTerm)) score += 50;
                                        if (productName.includes(searchTerm)) score += 50;
                                        if (productDetail.includes(searchTerm)) score += 30;
                                        if (price.includes(searchTerm)) score += 40;

                                        // Add row to array with its score
                                        rowsWithScores.push({
                                            row,
                                            score
                                        });
                                    });

                                    // Sort rows by score (highest first)
                                    rowsWithScores.sort((a, b) => b.score - a.score);

                                    // Clear the table
                                    tableBody.innerHTML = '';

                                    // Add rows back in sorted order, hiding non-matching rows
                                    rowsWithScores.forEach(item => {
                                        if (item.score > 0) {
                                            // Highlight the matching row
                                            item.row.style.display = '';
                                            item.row.style.backgroundColor = '#f0f8ff'; // Light blue highlight

                                            // After a short delay, remove the highlight
                                            setTimeout(() => {
                                                item.row.style.backgroundColor = '';
                                            }, 2000);

                                            tableBody.appendChild(item.row);
                                        } else {
                                            // Hide non-matching rows
                                            item.row.style.display = 'none';
                                            tableBody.appendChild(item.row);
                                        }
                                    });
                                });

                                // Function to restore original order
                                function restoreOriginalOrder() {
                                    tableBody.innerHTML = '';
                                    originalRows.forEach(row => {
                                        row.style.display = '';
                                        row.style.backgroundColor = '';
                                        tableBody.appendChild(row);
                                    });
                                }

                                // Add event listener for the search button
                                const searchButton = document.querySelector('.input-group-append button');
                                searchButton.addEventListener('click', function() {
                                    // Trigger the keyup event on the search input
                                    const event = new Event('keyup');
                                    searchInput.dispatchEvent(event);
                                });
                            });
                        </script>
                        <!-- Add some styling to improve the layout -->
                        <style>
                            /* Ensure flexbox is applied to each of the columns for centering */
                            .name-user,
                            .phone-user,
                            .email-user,
                            .address-user {
                                text-align: center;
                            }

                            .table {
                                width: 100%;
                            }

                            th,
                            td {
                                text-align: center;
                            }

                            /* Ensure that the images are circles with object-fit */
                            td img {
                                width: 50px;
                                height: 50px;
                                border-radius: 50%;
                                object-fit: cover;
                            }

                            /* Style the search bar */
                            .input-group {
                                max-width: 250px;
                            }

                            .input-group-append button {
                                background-color: #007bff;
                                color: white;
                            }

                            .input-group-append button i {
                                font-size: 14px;
                            }

                            /* Optional: Add some spacing between the button and the table */
                            .d-flex {
                                margin-bottom: 15px;
                            }

                            /* Style the modal */
                            .modal-content {
                                padding: 20px;
                            }
                        </style>

                    </div>





                    <!-- Bootstrap core JavaScript-->
                    <script src="/assets/vendor/jquery/jquery.min.js"></script>
                    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                    <!-- Core plugin JavaScript-->
                    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

                    <!-- Custom scripts for all pages-->
                    <script src="/assets/js/sb-admin-2.min.js"></script>

                    <!-- Page level plugins -->
                    <script src="/assets/vendor/chart.js/Chart.min.js"></script>

                    <!-- Page level custom scripts -->
                    <script src="/assets/js/demo/chart-area-demo.js"></script>
                    <script src="/assets/js/demo/chart-pie-demo.js"></script>



</body>

</html>