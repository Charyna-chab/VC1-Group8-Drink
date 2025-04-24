<?php require_once __DIR__ . '/../admin/Partials/header.php'; ?>

<div class="container my-5">
    <div class="card shadow mb-4" style="width: 50%; margin: auto; border-radius: 0.75rem;">
        <div class="card-body">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <h4 class="mb-4 text-primary">Edit Product</h4>
            <form action="/admin/products/update/<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <div class="form-group mb-3">
                    <label for="product_name" class="form-label">Name:</label>
                    <input type="text" value="<?= htmlspecialchars($product['product_name']) ?>" name="product_name" class="form-control rounded-pill" required>
                </div>

                <div class="form-group mb-3">
                    <label for="product_detail" class="form-label">Product Detail:</label>
                    <textarea name="product_detail" class="form-control rounded-3" rows="4" required><?= htmlspecialchars($product['product_detail']) ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" value="<?= $product['price'] ?>" name="price" class="form-control rounded-pill" step="0.01" required>
                </div>

                <div class="form-group mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <select name="category" class="form-control rounded-pill" required>
                        <option value="milk-tea" <?= $product['category'] === 'milk-tea' ? 'selected' : '' ?>>Milk Tea</option>
                        <option value="fruit-tea" <?= $product['category'] === 'fruit-tea' ? 'selected' : '' ?>>Fruit Tea</option>
                        <option value="coffee" <?= $product['category'] === 'coffee' ? 'selected' : '' ?>>Coffee</option>
                        <option value="smoothie" <?= $product['category'] === 'smoothie' ? 'selected' : '' ?>>Smoothie</option>
                        <option value="snack" <?= $product['category'] === 'snack' ? 'selected' : '' ?>>Snack</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="image" class="form-label">Product Image:</label>
                    <input type="file" name="image" class="form-control rounded-pill" accept="image/*">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image']) ?>">
                    <small class="form-text text-muted">Upload a new image to replace the current one, or leave blank to keep existing image.</small>
                    <?php if (!empty($product['image'])): ?>
                        <div class="mt-2">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Current Image" style="max-width: 100px; border-radius: 8px;">
                            <p class="small text-muted mt-1">Current image</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success rounded-pill px-4">Update Product</button>
                    <a href="/admin/products" class="btn btn-secondary rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../admin/Partials/footer.php'; ?>