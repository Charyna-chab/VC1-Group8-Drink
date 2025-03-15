<?php $users = $users ?? []; ?>
<div class="card-body">
  <div class="table-responsive ">
    <h3>Customers</h3>
    <table class="table table-bordered table-light" id="dataTable" width="100%" cellspacing="0">
      <a href="/user/create" class="btn btn-primary">Add New</a>

      <thead>
        <tr>
          <th>ID</th>
          <th></th>
          <th>Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Address</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td>
              <!-- Display image if available -->
              <?php if (!empty($user['image'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($user['image']) ?>"
                  alt="Profile Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
              <?php else: ?>
                No image
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['phone']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['address']) ?></td>
            <td>
              <a href="/user/edit?id=<?= $user['user_id'] ?>" class="btn btn-warning">Edit</a>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#user<?= $user['user_id'] ?>">
                Delete
              </button>

              <!-- Modal -->
              <?php require 'delete.php' ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php '../layout/footer.php' ?>