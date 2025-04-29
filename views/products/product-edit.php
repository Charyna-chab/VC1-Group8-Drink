<?php require_once __DIR__ . '/../admin/Partials/header.php'; ?>

<div class="container py-5">
    <div class="card shadow-lg mx-auto" style="max-width: 700px; border-radius: 1rem;">
        <div class="card-body px-5 py-4">
            <h3 class="text-center text-primary mb-4">Edit Product</h3>

            <form action="/admin/products/update/<?= $product['product_id'] ?>" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <!-- Flash Messages -->
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

                <!-- Name -->
                <div class="form-floating mb-4">
                    <input type="text" class="form-control rounded-3" id="product_name" name="product_name"
                        value="<?= htmlspecialchars($product['product_name']) ?>" required>
                    <label for="product_name">Product Name</label>
                </div>

                <!-- Detail -->
                <div class="form-floating mb-4">
                    <textarea class="form-control rounded-3" id="product_detail" name="product_detail" rows="4" required
                        style="height: 120px;"><?= htmlspecialchars($product['product_detail']) ?></textarea>
                    <label for="product_detail">Product Detail</label>
                </div>

                <!-- Price -->
                <div class="form-floating mb-4">
                    <input type="number" step="0.01" class="form-control rounded-3" id="price" name="price"
                        value="<?= $product['price'] ?>" required>
                    <label for="price">Price ($)</label>
                </div>
              

                <!-- Category -->
                <div class="form-floating mb-4">
                    <select class="form-select rounded-3" id="category" name="category" required>
                        <option value="brown-sugar" <?= $product['category'] === 'brown-sugar' ? 'selected' : '' ?>>Brown
                            Sugar</option>
                        </option>
                        <option value="macchiato" <?= $product['category'] === 'macchiato' ? 'selected' : '' ?>>Macchiato
                            Tea</option>
                        <option value="coffee" <?= $product['category'] === 'coffee' ? 'selected' : '' ?>>Coffee
                        </option>
                        <option value="tea" <?= $product['category'] === 'tea' ? 'selected' : '' ?>>Tea</option>
                        </option>
                        <option value="snack" <?= $product['category'] === 'snack' ? 'selected' : '' ?>>Snack</option>
                    </select>
                    <label for="category">Category</label>
                </div>

                <!-- Image Upload -->
                <!-- Product Image -->
                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold">Product Image</label>
                    <input type="file" name="image" class="form-control rounded-pill" accept="image/*" id="imageInput">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image']) ?>">
                    <small class="text-muted">Leave blank to keep the current image.</small>

                    <!-- Image Preview -->
                    <div class="mt-3 text-center" id="previewWrapper">
                        <?php if (!empty($product['image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($product['image']) ?>" id="imagePreview"
                            class="img-fluid rounded" style="max-height: 160px;">
                        <p class="text-muted small mt-1">Current Image</p>
                        <?php else: ?>
                        <img id="imagePreview" class="img-fluid rounded d-none" style="max-height: 160px;">
                        <?php endif; ?>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-4">Update</button>
                    <a href="/product" class="btn btn-outline-danger rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<script>
document.getElementById('imageInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>