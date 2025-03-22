

<?php $products = $product ?? []; ?>

<div class="card-body">
    <div class="table-responsive ">
        <div class="container">
            <form action="/user/update?id=<?= $product['product_id'] ?>" method="POST">
                <div class="form-group">
                    <label for="" class="form-label">Name:</label>
                    <input type="text" value=" <?= $product['product_name'] ?>" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Phone:</label>
                    <input type="phone" value=" <?= $product['product_detail'] ?>" name="phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Email:</label>
                    <input type="email" value=" <?= $product['price'] ?>" name="email" class="form-control">
                </div>
                <button type="submit" class="btn btn-success mt-3">Update</button>
            </form>
        </div>
    </div>
</div>
<?php '../layout/footer.php' ?>
