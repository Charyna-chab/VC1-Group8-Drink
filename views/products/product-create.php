<?php require_once __DIR__ . '/../admin/Partials/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Success Message -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Product Form -->
            <form action="/admin/products/store" method="POST" enctype="multipart/form-data"
                class="border border-2 rounded-4 p-4 shadow-sm bg-light">

                <h3 class="mb-4 text-center text-primary">Add a New Product</h3>

                <!-- Product Name -->
                <div class="form-floating mb-4">
                    <input type="text" class="form-control rounded-3" id="product_name" name="product_name"
                        value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" required>
                    <label for="product_name">Product Name</label>
                </div>

                <!-- Price -->
                <div class="form-floating mb-4">
                    <input type="number" step="0.01" class="form-control rounded-3" id="price" name="price"
                        value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
                    <label for="price">Price ($)</label>
                </div>
                <!-- Quantity -->
                <div class="form-floating mb-4">
                    <input type="number" class="form-control rounded-3" id="quantity" name="quantity"
                        value="<?= htmlspecialchars($product['quantity'] ?? '') ?>" required>
                    <label for="quantity">Quantity</label>
                </div>

                <!-- Product Detail -->
                <div class="form-floating mb-4">
                    <textarea class="form-control rounded-3" id="product_detail" name="product_detail"
                        style="height: 120px;" required><?= htmlspecialchars($product['product_detail'] ?? '') ?></textarea>
                    <label for="product_detail">Product Detail</label>
                </div>

                <!-- Category -->
                <div class="form-floating mb-4">
                    <select class="form-select rounded-3" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="brown-sugar" <?= ($product['category'] ?? '') === 'brown-sugar' ? 'selected' : '' ?>>
                            Brown Sugar</option>
                        <option value="macchiato" <?= ($product['category'] ?? '') === 'macchiato' ? 'selected' : '' ?>>
                            Macchiato</option>
                        <option value="coffee" <?= ($product['category'] ?? '') === 'coffee' ? 'selected' : '' ?>>Coffee
                            </option>
                        <option value="tea" <?= ($product['category'] ?? '') === 'tea' ? 'selected' : '' ?>>
                           Tea</option>
                        <option value="snack" <?= ($product['category'] ?? '') === 'snack' ? 'selected' : '' ?>>Snack
                        </option>
                    </select>
                    <label for="category">Category</label>
                </div>

                <!-- Product Image Upload -->
                <div class="mb-4">
                    <label for="imageInput" class="form-label fw-semibold">Product Image</label>
                    <input type="file" name="image" class="form-control rounded-pill" accept="image/*" id="imageInput">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image'] ?? '') ?>">
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

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success rounded-pill px-4">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<!-- JS for Live Image Preview -->
<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

imageInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.src = '';
        imagePreview.classList.add('d-none');
    }
});
</script>

