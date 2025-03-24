
<div class="card shadow mb-4 ml-3 mr-3" style="width:50%;">
  <div class="card-body ">
        <div class="container ">
            <!-- Update the form action and method -->
            <form action="/product/update/?id=<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data" >
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
