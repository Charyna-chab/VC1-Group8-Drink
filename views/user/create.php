<div class="main-panel">
    <div class="container">
        <form action="/user/store" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="name" id="name" name="name" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="phone" id="phone" name="phone" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="address" id="address" name="address" class="form-control">
            </div>
            <div class="form-group mb-3 ">
                <label for="profile" class="form-label">Profile:</label>
            </div>
            <input type="file" id="profile" name="image" class="form-control">

            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </div>
    <?php require_once 'views/layout/footer.php' ?>
</div>