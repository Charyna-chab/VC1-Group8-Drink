<?php
// session_start();
$products = $products ?? [];
$total = 0;
$product_count = count($products);
foreach ($products as $product) {
  $total += floatval($product['price']);
}
$_SESSION['product_total'] = $total;

// Store the product count in a session variable
$_SESSION['product_count'] = $product_count;
?>
<!-- In your header.php or at the top of your file -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Your table structure -->
<div class="card shadow mb-4 ml-3 mr-3">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <div class="d-flex justify-content-end">
        <form class="form-inline">
          <div class="input-group" style="max-width: 250px;">
            <input type="text" class="form-control form-control-sm bg-light border-0" placeholder="Search...">
            <div class="input-group-append">
              <button class="btn btn-primary btn-sm" type="button">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <!-- Button to add new user -->
        <div class="mb-2">
          <a href="/product/create" class="btn btn-primary">Add New</a>
        </div>

        <!-- Search form inside the table header -->
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
              <td><?= htmlspecialchars($product['price']) ?></td>

              <td>
                <!-- Action Dropdown - Fixed Version -->
                <div class="dropdown" style="position: relative;">
                  <button class="btn btn-sm p-0 border-0 bg-transparent dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton<?= $index ?>"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-ellipsis-v text-dark"></i>
                  </button>

                  <ul class="dropdown-menu dropdown-menu-end shadow"
                    aria-labelledby="dropdownMenuButton<?= $index ?>"
                    style="position: absolute; z-index: 1000; display: none;">
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
              </td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  /* Dropdown fixes */
  .dropdown-menu {
    min-width: 120px;
    border: 1px solid rgba(0, 0, 0, .1);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    z-index: 1060;
  }

  .dropdown-item {
    padding: 0.25rem 1rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
  }

  .dropdown-item:hover {
    background-color: #f8f9fa;
  }

  /* Button styling */
  .btn.p-0 {
    padding: 0 !important;
  }

  /* Make sure dropdown is visible */
  .dropdown:hover .dropdown-menu {
    display: block !important;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    var dropdowns = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
      .map(function(toggleEl) {
        return new bootstrap.Dropdown(toggleEl);
      });

    // Debug output
    console.log('Initialized dropdowns:', dropdowns.length);

    // Click event for testing
    document.querySelectorAll('.dropdown-toggle').forEach(function(el) {
      el.addEventListener('click', function() {
        console.log('Dropdown clicked, menu should show');
      });
    });
  });
</script>

<!-- At the bottom of your file before </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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