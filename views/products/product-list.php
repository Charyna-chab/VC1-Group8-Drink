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
            
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
                        <a href="/admin/products/create" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="input-group" style="width: 300px;">
                                <input type="text" class="form-control form-control-sm" placeholder="Search..." id="searchInput">
                                <button class="btn btn-primary btn-sm" type="button" id="searchButton">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Product Detail</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $index => $product): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($product['product_id']) ?></td>
                                                <td>
                                                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="product-image">
                                                </td>
                                                <td><?= htmlspecialchars($product['product_name']) ?></td>
                                                <td><?= htmlspecialchars($product['product_detail']) ?></td>
                                                <td>$<?= htmlspecialchars($product['price']) ?></td>
                                                <td>
                                                    <a href="/admin/products/edit?id=<?= $product['product_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="/admin/products/delete?product_id=<?= $product['product_id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No products found.</td>
                                        </tr>
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