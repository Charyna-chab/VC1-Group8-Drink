<div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="/product/update/?id=<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data" class="border border-2 rounded p-4 shadow-sm bg-white">
                    <h3 class="mb-4 text-center text-primary">Update Product</h3>

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Name</label>
                        <input type="text" id="product_name" value="<?= $product['product_name'] ?>" name="product_name" class="form-control" placeholder="Enter product name" required>
                    </div>

                    <div class="mb-3">
                        <label for="product_detail" class="form-label">Product Detail</label>
                        <textarea id="product_detail" name="product_detail" class="form-control" placeholder="Enter product details" rows="4" required><?= $product['product_detail'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" id="price" value="<?= $product['price'] ?>" name="price" class="form-control" placeholder="Enter product price" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Upload New Image</label>
                        <input type="file" id="image" name="image" class="form-control">
                        <input type="hidden" name="existing_image" value="<?= $product['image'] ?>">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>