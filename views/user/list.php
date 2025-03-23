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
                <a href="/user/create" class="btn btn-primary mb-4">Add New</a>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($user['image']) ?>" alt="" style="width: 50px; height: 50px;">
                            </td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['address']) ?></td>
                            <td>
                                <a href="/user/edit?id=<?= $user['user_id'] ?>" class="btn btn-warning">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#users<?= $user['user_id'] ?>">
                                    Delete
                                </button>
                                <!-- Modal -->
                                <?php include 'delete.php' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
