<div class="main-panel ">
    <div class="container w-50 p-3 ">
        <form action="/product/store" method="POST" enctype="multipart/form-data" class="border border-dark p-5">
            <div class="row">
                <div class="form-group mb-3 col">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="product_name" id="product_name" name="product_name" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="phone" class="form-label">Price:</label>
                    <input type="price" id="price" name="price" class="form-control">
                </div>
            </div>

            <div class="form-group mb-3 col">
                <label for="email" class="form-label">Product Detail:</label>
                <input type="product_detail" id="product_detail" name="product_detail" class="form-control">
            </div>
            
            <div class="form-group mb-3 col ">
                <label for="profile" class="form-label">Image:</label>
            </div>
            <input type="file" id="image" name="image" class="form-control">

            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </div>
    <?php require_once 'views/layout/footer.php' ?>
</div>