<body id="page-top">
    <div id="wrapper">
        <?php require_once __DIR__ . '/../admin/Partials/sidebar.php'; ?>

        <div id="content" class="bg-light">
            <?php require_once __DIR__ . '/../admin/Partials/navbar.php'; ?>

            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Topping List</h6>
                        <a href="/admin/products/create" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-plus me-1"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div id="searchResults" class="text-muted small"></div>
                            <div class="search-container">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search products..." 
                                        id="searchInput" autocomplete="off">
                                    <button class="btn btn-primary btn-sm" type="button" id="searchButton">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
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
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $index => $product): ?>
                                        <tr data-category="<?= htmlspecialchars($product['category']) ?>" data-name="<?= htmlspecialchars($product['product_name']) ?>">
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image"
                                                    class="product-image" style="object-fit: cover;">
                                            </td>
                                            <td class="product-name"><?= htmlspecialchars($product['product_name']) ?></td>
                                            <td class="product-detail"><?= htmlspecialchars($product['product_detail']) ?></td>
                                            <td>$<?= htmlspecialchars($product['price']) ?></td>
                                            <td><?= htmlspecialchars($product['category']) ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm p-0 border-0 bg-transparent dropdown-toggle"
                                                        type="button" id="dropdownMenuButton<?= $index ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v text-dark"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow"
                                                        aria-labelledby="dropdownMenuButton<?= $index ?>">
                                                        <li>
                                                            <a class="dropdown-item py-2"
                                                                href="/admin/products/edit/<?= $product['product_id'] ?>">
                                                                <i class="fas fa-edit me-2 text-primary"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-2 text-danger" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal<?= $index ?>">
                                                                <i class="fas fa-trash me-2 text-danger"></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="modal fade" id="deleteModal<?= $index ?>" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Deletion</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete
                                                                "<?= htmlspecialchars($product['product_name']) ?>"?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <form
                                                                    action="/admin/products/delete/<?= $product['product_id'] ?>"
                                                                    method="POST">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>