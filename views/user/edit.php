

<?php $users = $user ?? []; ?>

<div class="card-body">
    <div class="table-responsive ">
        <div class="container">
            <form action="/user/update?id=<?= $user['user_id'] ?>" method="POST">
                <div class="form-group">
                    <label for="" class="form-label">Name:</label>
                    <input type="text" value=" <?= $user['name'] ?>" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Phone:</label>
                    <input type="phone" value=" <?= $user['phone'] ?>" name="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Email:</label>
                    <input type="email" value=" <?= $user['email'] ?>" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Address:</label>
                    <input type="address" value=" <?= $user['address'] ?>" name="address" class="form-control">
                </div>
                <button type="submit" class="btn btn-success mt-3">Update</button>
            </form>
        </div>
    </div>
</div>
<?php '../layout/footer.php' ?>
