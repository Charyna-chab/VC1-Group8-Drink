<?php
// Ensure $users is defined and is an array
$products = $products ?? [];
?>

<div class="card-body">
  <div class="table-responsive">
    <h3>Products List</h3>
    <table class="table table-bordered table-light" id="dataTable" width="100%" cellspacing="0">
      <a href="/product/create" class="btn btn-primary">Add New</a>

      <thead>
        <tr>
          <th>ID</th>
          <th>Product Name</th>
          <th>Image</th>
          <th>Product Detail</th>
          <th>Price</th>
          <th>Action</th>
         
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $index => $product): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($product['product_name']) ?></td>
            <td>
              <!-- Display image if available -->
              <?php if (!empty($product['image'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($product['image']) ?>"
                  alt="Profile Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
              <?php else: ?>
                No image
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($product['product_detial']) ?></td>
            <td><?= htmlspecialchars($product['price']) ?></td>
            <td>
              <a href="/product/edit?id=<?= $product['product_id'] ?>" class="btn btn-warning">Edit</a>
              <a href="" class="btn btn-danger"  tabindex="-1">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php '../layout/footer.php'; ?>