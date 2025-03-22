<div class="card-body w-50 p-3">
    <div class="table-responsive">
        <div class="container">
            <!-- Update form action and use a hidden input for ID -->
            <form action="/product/update" method="POST" enctype="multipart/form-data" class="border border-dark p-5">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <div class="form-group mb-3 col">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" value="<?= $product['product_name'] ?>" name="product_name" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="product_detail" class="form-label">Product Detail:</label>
                    <input type="text" value="<?= $product['product_detail'] ?>" name="product_detail" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" value="<?= $product['price'] ?>" name="price" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="image" class="form-label">Product Image:</label>
                    <input type="file" name="image" class="form-control">
                    <input type="hidden" name="existing_image" value="<?= $product['image'] ?>">
                </div>
                <button type="submit" class="btn btn-success mt-3">Update</button>
            </form>
        </div>
    </div>
</div>
