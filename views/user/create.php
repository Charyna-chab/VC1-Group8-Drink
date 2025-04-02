<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="/user/store" method="POST" enctype="multipart/form-data" class="border border-2 rounded p-4 shadow-sm bg-white">
                <h3 class="mb-4 text-center text-primary">User Information</h3>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter your address" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="" selected disabled>Select your role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Profile Picture</label>
                    <input type="file" id="image" name="image" class="form-control">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>