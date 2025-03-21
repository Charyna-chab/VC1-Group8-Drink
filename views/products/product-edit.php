<?php $product = $product ?? []; ?>

<div class="card-body w-50 p-3">
    <div class="table-responsive">
        <div class="container">
            <!-- Update the form action and method -->
            <form action="/product/update/<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data" class="border border-dark p-5">
                <div class="form-group mb-3 col">
                    <label for="name" class="form-label">Name:</label>
                    <!-- Correct the input name -->
                    <input type="text" value="<?= $product['product_name'] ?>" name="product_name" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="product_detail" class="form-label">Product Detail:</label>
                    <!-- Correct the input name -->
                    <input type="text" value="<?= $product['product_detail'] ?>" name="product_detail" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="price" class="form-label">Price:</label>
                    <!-- Correct the input type and name -->
                    <input type="number" value="<?= $product['price'] ?>" name="price" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="image" class="form-label">Current Image:</label>
                    <!-- Display the existing image -->
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= $product['image'] ?>" alt="Product Image" style="max-width: 200px; max-height: 200px;">
                    <?php else: ?>
                        <p>No image available.</p>
                    <?php endif; ?>
                </div>
                <div class="form-group mb-3 col">
                    <label for="image" class="form-label">Upload New Image:</label>
                    <!-- Input for uploading a new image -->
                    <input type="file" name="image" class="form-control">
                    <!-- Hidden input to store the existing image path -->
                    <input type="hidden" name="existing_image" value="<?= $product['image'] ?>">
                </div>
                <button type="submit" class="btn btn-success mt-3">Update</button>
            </form>
        </div>
    </div>
</div>