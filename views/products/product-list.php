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
      font-family: 'Nunito', sans-serif;
      overflow-x: hidden;
    }

    /* Sidebar styling */
    #accordionSidebar {
      width: 250px;
      min-height: 100vh;
      background: white;
      transition: all 0.3s;
      position: fixed;
      z-index: 1000;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .sidebar-brand {
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
    }

    .sidebar-brand-text {
      font-size: 1.2rem;
      font-weight: 800;
    }

    .sidebar-divider {
      margin: 10px 15px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .nav-item {
      margin: 5px 0;
    }

    .nav-link {
      padding: 10px 15px;
      color: #333;
      border-radius: 5px;
      margin: 0 10px;
    }

    .nav-link:hover {
      background-color: #f8f9fa;
    }

    .nav-link.active {
      background-color: #4e73df;
      color: white !important;
    }

    .nav-link i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    /* Main content styling */
    .main-content {
      margin-left: 250px;
      width: calc(100% - 250px);
      padding: 20px;
      transition: all 0.3s;
    }

    /* Card styling */
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .card-header {
      background-color: #fff;
      border-bottom: 1px solid #e3e6f0;
      border-radius: 10px 10px 0 0 !important;
      padding: 1rem 1.5rem;
    }

    /* Table styling */
    .table-responsive {
      border-radius: 10px;
      overflow: hidden;
    }

    .table {
      margin-bottom: 0;
      width: 100%;
    }

    .table thead th {
      background-color: #f8f9fa;
      border-bottom-width: 1px;
      font-weight: 600;
      color: #4e73df;
      vertical-align: middle;
      padding: 12px 15px;
    }

    .table td, .table th {
      padding: 12px 15px;
      vertical-align: middle;
    }

    .table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .table tbody tr:hover {
      background-color: #f1f1f1;
    }

    /* Button styling */
    .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }

    .btn-success {
      background-color: #1cc88a;
      border-color: #1cc88a;
    }

    .btn-success:hover {
      background-color: #17a673;
      border-color: #17a673;
    }

    .btn-primary {
      background-color: #4e73df;
      border-color: #4e73df;
    }

    .btn-primary:hover {
      background-color: #3a5bc7;
      border-color: #3a5bc7;
    }

    /* Search input styling */
    .search-container {
      margin-bottom: 1rem;
    }

    .input-group {
      width: 250px;
    }

    /* Modal styling */
    .modal-content {
      border-radius: 10px;
    }

    /* Content wrapper */
    .content-wrapper {
      width: 100%;
      padding: 20px;
      margin-left: 250px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      #accordionSidebar {
        margin-left: -250px;
      }
      
      .content-wrapper,
      .main-content {
        margin-left: 0;
        width: 100%;
      }
      
      .input-group {
        width: 100% !important;
        margin-top: 10px;
      }
      
      #accordionSidebar.active {
        margin-left: 0;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon rotate-n-15">
        <img src="/placeholder.svg" alt="">
    </div>
    <div class="sidebar-brand-text mx-3 text-dark">XING FU CHA</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="/admin-dashboard">
        <i class="fas fa-fw fa-tachometer-alt text-dark"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Customers -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/admin/users">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span>Customers</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Products -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/admin/products">
        <i class="fas fa-fw fa-folder"></i>
        <span>Products</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Receipts -->
<li class="nav-item">
    <a class="nav-link collapsed" href="/admin/receipts">
        <i class="fas fa-receipt"></i>
        <span>Receipts</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Feedback -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-comment-alt feedback-icon"></i>
        <span>Feedback</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Settings -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-cogs setting-icon"></i>
        <span>Settings</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a href="/logout" class="role-switch-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</li>
</ul>


  <!-- Content Area -->
  <div class="content-wrapper">
    <div class="container-fluid">
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
                  <td><?= $product['product_id'] ?></td>
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