<div class="card shadow mb-4 ml-3 mr-3" style="width:50%;">
    <div class="card-body ">
        <div class="container ">
            <form action="/product/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <div class="form-group mb-3 col">
                    <label for="product_name" class="form-label">Name:</label>
                    <input type="text" value="<?= $product['product_name'] ?>" name="product_name" class="form-control">
                </div>

                <div class="form-group mb-3 col">
                    <label for="product_detail" class="form-label">Product Detail:</label>
                    <input type="text" value="<?= $product['product_detail'] ?>" name="product_detail"
                        class="form-control">
                </div>

                <div class="form-group mb-3 col">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" value="<?= $product['price'] ?>" name="price" class="form-control">
                </div>

                <div class="form-group mb-3 col">
                    <label for="category" class="form-label">Category:</label>
                    <select name="category" class="form-control">
                        <option value="milk-tea" <?= $product['category'] == 'milk-tea' ? 'selected' : '' ?>>Milk Tea</option>
                        <option value="fruit-tea" <?= $product['category'] == 'fruit-tea' ? 'selected' : '' ?>>Fruit Tea</option>
                        <option value="coffee" <?= $product['category'] == 'coffee' ? 'selected' : '' ?>>Coffee</option>
                        <option value="smoothie" <?= $product['category'] == 'smoothie' ? 'selected' : '' ?>>Smoothie</option>
                    </select>
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