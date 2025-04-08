<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Product List'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
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
            border-radius: 0.75rem;
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
/* Search Container Styles - Bigger and Right-Aligned */
.search-container {
    position: relative;
    width: 100%;
    max-width: 350px; /* Increased from 400px */
    margin-left: auto; /* This pushes it to the right */
    margin-right: 0;   /* Removes right margin */
}

.search-container .input-group {
    display: flex;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); /* Stronger shadow */
    border-radius: 30px; /* More rounded */
    overflow: hidden;
    transition: all 0.3s ease;
    height: 40px; /* Fixed height for bigger size */
}

.search-container .input-group:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); /* Stronger hover shadow */
}

/* Search Input Styles - Bigger */
.search-container #searchInput {
    flex: 1;
    border: none;
    padding: 12px 25px; /* Increased padding */
    font-size: 16px; /* Larger font */
    background-color: #f8f9fc;
    color: #333;
    outline: none;
    height: 100%; /* Takes full height of container */
}

.search-container #searchInput::placeholder {
    color: #9a9a9a;
    font-weight: 300;
    font-size: 15px; /* Larger placeholder */
}

.search-container #searchInput:focus {
    background-color: #fff;
    box-shadow: inset 0 0 0 2px #4e73df; /* Thicker focus border */
}

/* Search Button Styles - Bigger */
.search-container #searchButton {
    border: none;
    background-color: #4e73df;
    color: white;
    padding: 0 25px; /* Wider button */
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 60px; /* Minimum button width */
}

.search-container #searchButton:hover {
    background-color: #2e59d9;
}

.search-container #searchButton i {
    font-size: 20px; /* Larger icon */
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .search-container {
        max-width: 100%;
    }
    
    .search-container #searchInput {
        padding: 10px 20px;
        font-size: 15px;
    }
    
    .search-container #searchButton {
        padding: 0 20px;
        min-width: 50px;
    }
    
    .search-container #searchButton i {
        font-size: 18px;
    }
}

/* Highlight for search results */
.highlight-match {
    background-color: #fffde7;
    font-weight: bold;
    padding: 3px 5px; /* Slightly bigger highlight */
    border-radius: 4px;
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

            .search-container {
                width: 100%;
            }
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require_once __DIR__ . '/../admin/Partials/sidebar.php'; ?>

        <div id="content" class="bg-light">
            <?php require_once __DIR__ . '/../admin/Partials/navbar.php'; ?>

            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Enhanced search functionality
            $('#searchButton').click(function() {
                performSearch();
            });

            $('#searchInput').on('input', function() {
                performSearch();
            });

            $('#searchInput').keyup(function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });

            function performSearch() {
                const searchTerm = $('#searchInput').val().toLowerCase().trim();
                const $rows = $('tbody tr');
                let matchCount = 0;
                
                // Remove previous highlights
                $('.product-name, .product-detail').each(function() {
                    const originalText = $(this).text();
                    $(this).text(originalText);
                    $(this).removeClass('highlight-match');
                });
                
                if (searchTerm === '') {
                    // Show all rows if search is empty
                    $rows.show();
                    $('#searchResults').text('');
                    return;
                }
                
                // Hide all rows first
                $rows.hide();
                
                // Filter and show matching rows
                $rows.each(function() {
                    const $row = $(this);
                    const productName = $row.find('.product-name').text().toLowerCase();
                    const productDetail = $row.find('.product-detail').text().toLowerCase();
                    const category = $row.data('category').toLowerCase();
                    
                    if (productName.includes(searchTerm) || 
                        productDetail.includes(searchTerm) || 
                        category.includes(searchTerm)) {
                        
                        $row.show();
                        matchCount++;
                        
                        // Highlight matching text in product name
                        if (productName.includes(searchTerm)) {
                            highlightText($row.find('.product-name'), searchTerm);
                        }
                        
                        // Highlight matching text in product detail
                        if (productDetail.includes(searchTerm)) {
                            highlightText($row.find('.product-detail'), searchTerm);
                        }
                    }
                });
                
                // Update search results count
                $('#searchResults').text(matchCount > 0 ? 
                    `Found ${matchCount} matching product${matchCount !== 1 ? 's' : ''}` : 
                    'No products found');
                
                // Sort matching rows to show exact matches first
                sortSearchResults(searchTerm);
            }
            
            function highlightText($element, searchTerm) {
                const text = $element.text();
                const lowerText = text.toLowerCase();
                const index = lowerText.indexOf(searchTerm.toLowerCase());
                
                if (index >= 0) {
                    const prefix = text.substring(0, index);
                    const match = text.substring(index, index + searchTerm.length);
                    const suffix = text.substring(index + searchTerm.length);
                    
                    $element.html(prefix + '<span class="highlight-match">' + match + '</span>' + suffix);
                }
            }
            
            function sortSearchResults(searchTerm) {
                const $tbody = $('tbody');
                const $visibleRows = $('tbody tr:visible');
                
                // Sort rows: exact matches first, then partial matches
                const sortedRows = $visibleRows.get().sort(function(a, b) {
                    const aName = $(a).data('name').toLowerCase();
                    const bName = $(b).data('name').toLowerCase();
                    
                    // If one is an exact match and the other isn't
                    const aExact = aName === searchTerm;
                    const bExact = bName === searchTerm;
                    
                    if (aExact && !bExact) return -1;
                    if (!aExact && bExact) return 1;
                    
                    // If one starts with the search term and the other doesn't
                    const aStarts = aName.startsWith(searchTerm);
                    const bStarts = bName.startsWith(searchTerm);
                    
                    if (aStarts && !bStarts) return -1;
                    if (!aStarts && bStarts) return 1;
                    
                    // Otherwise sort alphabetically
                    return aName.localeCompare(bName);
                });
                
                // Re-append sorted rows
                $.each(sortedRows, function(index, row) {
                    $tbody.append(row);
                });
            }
        });
    </script>
</body>
</html>