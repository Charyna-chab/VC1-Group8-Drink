<?php
$users = $users ?? [];
?>


<div class="card shadow mb-4 ml-3 mr-3">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Customers List</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <!-- Button to add new user -->
        <div class="d-flex justify-content-end mb-2">
          <a href="/user/create" class="btn btn-success">Add New</a>
        </div>

        <!-- Search form inside the table header -->
        <thead>
          <tr>
            <th colspan="7">
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
            </th>
          </tr>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($users as $index => $user): ?>
            <tr>
              <td><?= 1 + $index ?></td>
              <td>
                <img src="<?= htmlspecialchars($user['image']) ?>">
              </td>
              <td class="name-user"><?= htmlspecialchars($user['name']) ?></td>
              <td class="phone-user"><?= htmlspecialchars($user['phone']) ?></td>
              <td class="address-user"><?= htmlspecialchars($user['address']) ?></td>
              <td class="email-user"><?= htmlspecialchars($user['email']) ?></td>
              <td class="role-user"><?= htmlspecialchars($user['role']) ?></td>
              <td>
                <a href="/user/edit?id=<?= $user['user_id'] ?>" class="btn btn-warning">Edit</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#users<?= $user['user_id'] ?>">Delete</button>
                <!-- Modal -->
                <?php include 'delete.php' ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>


    </div>
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
    </style>