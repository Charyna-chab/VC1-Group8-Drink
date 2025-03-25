<div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="/user/update?id=<?= $user['user_id'] ?>" method="POST" class="border border-2 rounded p-4 shadow-sm bg-white">
                    <h3 class="mb-4 text-center text-primary">Update User</h3>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" value="<?= $user['name'] ?>" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" id="phone" value="<?= $user['phone'] ?>" name="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" value="<?= $user['email'] ?>" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" id="address" value="<?= $user['address'] ?>" name="address" class="form-control" placeholder="Enter your address" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>