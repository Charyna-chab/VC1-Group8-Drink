<?php
// session_start();
$products = $products ?? [];
$total = 0;
foreach ($products as $product) {
    $total += floatval($product['price']);
}
$_SESSION['product_total'] = $total;
?>


<div class="card shadow mb-4 ml-3 mr-3">
  <div class="card-header py-3">
 
    <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <a href="/product/create" class="btn btn-primary ">Add New</a>

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
          <?php foreach ($products as $index => $product): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td>
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="" style="width: 50px; height: 50px;">
              </td>
              <td><?= htmlspecialchars($product['product_name']) ?></td>
              <td><?= htmlspecialchars($product['product_detail']) ?></td>
              <td class="price"><?= htmlspecialchars($product['price']) ?></td>
              <!-- Add this at the bottom of your PHP file, before the closing </body> tag -->
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Get all price elements from the table
                  const priceElements = document.querySelectorAll(".price");

                  // Calculate the total price
                  let total = 0;
                  priceElements.forEach((element) => {
                    const price = parseFloat(element.textContent);
                    if (!isNaN(price)) {
                      total += price;
                    }
                  });

                  // Update the "Totals" card with the calculated total
                  const totalPriceElement = document.getElementById("total-price");
                  totalPriceElement.textContent = total.toFixed(2); // Display with 2 decimal places
                });
              </script>
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