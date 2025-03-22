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
            <a href="/product/edit?product_id=<?= $product['product_id'] ?>" class="btn btn-warning">Edit</a>
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
                    <a href="/product/delete?product_id=<?= $product['product_id'] ?>"type="button" class="btn btn-danger">Yes</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
    </tbody>
  </table>
  <?php
  if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Clear message after displaying
  }

  if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // Clear message after displaying
  }
  ?>
</div>
<script>
  $(document).ready(function() {
    <?php if (isset($_SESSION['success'])) { ?>
      $.notify("<?= $_SESSION['success'] ?>", "success");
      <?php unset($_SESSION['success']); ?>
    <?php } ?>

    <?php if (isset($_SESSION['error'])) { ?>
      $.notify("<?= $_SESSION['error'] ?>", "error");
      <?php unset($_SESSION['error']); ?>
    <?php } ?>
  });
</script>

<?php '../layout/footer.php'; ?>