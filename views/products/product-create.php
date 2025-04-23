<?php require_once __DIR__ . '/../admin/Partials/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
            <form action="/admin/products/store" method="POST" enctype="multipart/form-data" class="border border-2 rounded-4 p-4 shadow-sm bg-light">
                <h3 class="mb-4 text-center text-primary">Add a New Product</h3>
                
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" id="product_name" name="product_name" class="form-control rounded-pill" placeholder="Enter product name" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="price" class="form-control rounded-pill" placeholder="Enter product price" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="product_detail" class="form-label">Product Detail</label>
                    <textarea id="product_detail" name="product_detail" class="form-control rounded-3" placeholder="Describe your product" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category" class="form-control rounded-pill" required>
                        <option value="milk-tea">Milk Tea</option>
                        <option value="fruit-tea">Fruit Tea</option>
                        <option value="coffee">Coffee</option>
                        <option value="smoothie">Smoothie</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" id="image" name="image" class="form-control rounded-pill" accept="image/*">
                    <small class="form-text text-muted">Upload an image (JPG, JPEG, PNG, GIF).</small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success w-100 rounded-pill">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
