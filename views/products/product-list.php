<?php
// Ensure $users is defined and is an array
$products = $products ?? [];
?>


  <div class="container mt-3">
    <h3>Products List</h3>
    <table class="table mt-3">
      <a href="/product/create" class="btn btn-primary">Add New</a>

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
        <?php foreach ($products as $index => $product): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="" style="width: 50px; height: 50px;">
            </td>
            <td><?= htmlspecialchars($product['product_name']) ?></td>
            <td><?= htmlspecialchars($product['product_detail']) ?></td>
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