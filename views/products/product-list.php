<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($title) ? $title : 'Admin Dashboard - XING FU CHA'; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      margin: 0;
      background-color: #f8f9fa;
    }

    .main-content {
      display: flex;
      width: 100%;
    }

    .content-wrapper {
      flex: 1;
      padding: 20px;
    }

    .table-responsive {
      overflow-x: auto;
    }

    .card {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
    }

    .card-header {
      background-color: #f8f9fa;
      border-bottom: 1px solid #e3e6f0;
    }

    .table {
      margin-bottom: 0;
    }

    .table th {
      border-top: none;
      border-bottom: 1px solid #e3e6f0;
      font-weight: 600;
      color: #4e73df;
    }

    .table td {
      vertical-align: middle;
    }

    .table img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #dee2e6;
    }

    .action-buttons {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
    }

    .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }

    .dropdown-menu {
      min-width: 120px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
      padding: 0.25rem 1rem;
      font-size: 0.875rem;
    }

    .input-group {
      max-width: 250px;
    }

    .search-container {
      margin-bottom: 1rem;
    }

    .modal-header {
      border-bottom: 1px solid #e3e6f0;
    }

    .modal-footer {
      border-top: 1px solid #e3e6f0;
    }
  </style>
</head>

<body>
  <?php require_once '../admin/Partials/header.php' ?>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Sidebar - Left untouched -->
    <div class="sidebar text-dark">
      <?php require '../admin/Partials/sidebar.php' ?>
    </div>

    <!-- Content Area -->
    <div class="content-wrapper">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
          <a href="/product/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add New
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <div class="search-container d-flex justify-content-end mb-3">
              <div class="input-group">
                <input type="text" class="form-control form-control-sm" placeholder="Search..." id="searchInput">
                <button class="btn btn-primary btn-sm" type="button" id="searchButton">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
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
                <?php foreach ($products as $index => $product): ?>
                <tr>
                  <td><?= 1 + $index ?></td>
                  <td>
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="" style="width: 50px; height: 50px; border-radius: 10px; object-fit: cover;">
                  </td>
                  <td><?= htmlspecialchars($product['product_name']) ?></td>
                  <td><?= htmlspecialchars($product['product_detail']) ?></td>
                  <td>$<?= htmlspecialchars($product['price']) ?></td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm p-0 border-0 bg-transparent dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton<?= $index ?>"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v text-dark"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end shadow"
                        aria-labelledby="dropdownMenuButton<?= $index ?>">
                        <li>
                          <a class="dropdown-item py-2" href="/product/edit?id=<?= $product['product_id'] ?>">
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

                    <div class="modal fade" id="deleteModal<?= $index ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete "<?= htmlspecialchars($product['product_name']) ?>"?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="/product/delete?product_id=<?= $product['product_id'] ?>" class="btn btn-danger">Delete</a>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Search functionality
      const searchInput = document.getElementById('searchInput');
      const searchButton = document.getElementById('searchButton');
      
      function filterTable() {
        const value = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(value) ? '' : 'none';
        });
      }
      
      searchButton.addEventListener('click', filterTable);
      searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') filterTable();
      });
    });
  </script>
</body>
</html>