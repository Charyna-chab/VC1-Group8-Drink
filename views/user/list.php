<?php '../layout/header.php'?>
<?php '../layout/nav.php'?>

<?php $users = $users ?? []; ?>

    <a href="/user/create" class="btn btn-primary">Add New</a>
    <table class="table mt-3">
      <thead>
        <tr>
          <th>ID</th>
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
  <!-- </div>
</div> -->

