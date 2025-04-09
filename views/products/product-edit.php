<?php require_once __DIR__ . '/../admin/Partials/header.php'; ?>

<div class="d-flex justify-content-center">
    <div class="card shadow mb-4" style="width: 50%; border-radius: 0.75rem;">
        <div class="card-body">
            <div class="container">
                <h4 class="mb-4 text-primary text-center">Edit Product</h4>
                <form action="/admin/products/update/<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                    <div class="form-group mb-3 col">
                        <label for="product_name" class="form-label">Name:</label>
                        <input type="text" value="<?= htmlspecialchars($product['product_name']) ?>" name="product_name" class="form-control rounded-pill" required>
                    </div>

                    <div class="form-group mb-3 col">
                        <label for="product_detail" class="form-label">Product Detail:</label>
                        <input type="text" value="<?= htmlspecialchars($product['product_detail']) ?>" name="product_detail" class="form-control rounded-pill" required>
                    </div>

                    <div class="form-group mb-3 col">
                        <label for="price" class="form-label">Price:</label>
                        <input type="number" value="<?= $product['price'] ?>" name="price" class="form-control rounded-pill" step="0.01" required>
                    </div>

                    <div class="form-group mb-3 col">
                        <label for="category" class="form-label">Category:</label>
                        <select name="category" class="form-control rounded-pill" required>
                            <option value="milk-tea" <?= $product['category'] === 'milk-tea' ? 'selected' : '' ?>>Milk Tea</option>
                            <option value="fruit-tea" <?= $product['category'] === 'fruit-tea' ? 'selected' : '' ?>>Fruit Tea</option>
                            <option value="coffee" <?= $product['category'] === 'coffee' ? 'selected' : '' ?>>Coffee</option>
                            <option value="smoothie" <?= $product['category'] === 'smoothie' ? 'selected' : '' ?>>Smoothie</option>
                        </select>
                    </div>

                    <div class="form-group mb-3 col">
                        <label for="image" class="form-label">Product Image:</label>
                        <input type="file" name="image" class="form-control rounded-pill">
                        <input type="hidden" name="existing_image" value="<?= $product['image'] ?>">
                        <?php if (!empty($product['image'])): ?>
                            <div class="mt-2 text-center">
                                <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" alt="Current Image" style="max-width: 100px; border-radius: 8px;">
                                <p class="small text-muted mt-1">Current image</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success mt-3 rounded-pill px-4">Update Product</button>
                        <a href="/product" class="btn btn-danger mt-3 rounded-pill px-4 ">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>