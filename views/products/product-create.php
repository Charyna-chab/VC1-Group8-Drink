<div class="card shadow mb-4 ml-3 mr-3" style="width:50%;">
    <div class="card-body ">
        <div class="container">
            <form action="/product/store" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="form-label">Product Name:</label>
                    <input type="product_name" id="product_name" name="product_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Price:</label>
                    <input type="price" id="price" name="price" class="form-control">
                </div>


                <div class="form-group">
                    <label for="email" class="form-label">Product Detail:</label>
                    <input type="product_detail" id="product_detail" name="product_detail" class="form-control">
                </div>

                <div class="form-group ">
                    <label for="profile" class="form-label">Image:</label>
                </div>
                <input type="file" id="image" name="image" class="form-control">

                <button type="submit" class="btn btn-success">Submit</button>
            </form>

    </div>
    <?php require_once 'views/layouts/admin/footer.php' ?>
</div>