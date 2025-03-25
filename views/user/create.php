<div class="main-panel ">
    <div class="container w-50 p-3 ">
        <form action="/user/store" method="POST" enctype="multipart/form-data" class="border border-dark p-5">
            <div class="row">
                <div class="form-group mb-3 col">
                    <label for="name" class="form-label">Name:</label>
                    <input type="name" id="name" name="name" class="form-control">
                </div>
                <div class="form-group mb-3 col">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="phone" id="phone" name="phone" class="form-control">
                </div>
            </div>

            <div class="form-group mb-3 col">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group mb-3 col">
                <label for="address" class="form-label">Address:</label>
                <input type="address" id="address" name="address" class="form-control">
            </div>
            <div class="form-group mb-3 col ">
                <label for="profile" class="form-label">Profile:</label>
            </div>
            <input type="file" id="image" name="image" class="form-control">

            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </div>
    <?php require_once 'views/layouts/admin/footer.php' ?>
</div>