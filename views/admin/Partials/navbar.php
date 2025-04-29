<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Load admin data from a JSON file (simulating a database)
$admin_data_file = __DIR__ . '/admin_data.json';
if (file_exists($admin_data_file)) {
    $admin_data = json_decode(file_get_contents($admin_data_file), true);
    $admin_id = $_SESSION['user']['id'] ?? '1';
    if (isset($admin_data[$admin_id]['avatar'])) {
        $_SESSION['user']['avatar'] = $admin_data[$admin_id]['avatar'];
    }
} else {
    // If the JSON file doesn't exist, set a default avatar
    if (!isset($_SESSION['user']['avatar'])) {
        $_SESSION['user']['avatar'] = '/assets/image/default_avatar.jpg';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - XING FU CHA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add any additional styles if needed */
        .img-profile {
            transition: transform 0.3s ease;
        }
        .img-profile:hover {
            transform: scale(1.1);
        }
        .profile-img {
            transition: transform 0.3s ease;
        }
        .profile-img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <div id="wrapper">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow-sm" style="background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars text-primary"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto align-items-center">
                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw text-gray-600"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw text-gray-600"></i>
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header bg-primary text-white">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw text-gray-600"></i>
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header bg-primary text-white">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                        problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how
                                        would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="/assets/image/undraw_profile_3.svg" alt="...">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with
                                        the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                        alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                        told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>

                    <!-- Nav Item - Shopping Cart -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-shopping-cart text-gray-600"></i>
                        </a>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="d-flex flex-column mr-2 d-none d-lg-block">
                                <span class="text-dark font-weight-semibold">
                                    <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Admin User'); ?>
                                </span>
                            </div>
                            <img class="img-profile rounded-circle border border-2 border-primary shadow-sm"
                                src="<?php echo htmlspecialchars($_SESSION['user']['avatar'] ?? '/assets/image/default_avatar.jpg'); ?>"
                                style="width: 40px; height: 40px; object-fit: cover;" id="topbarProfilePic">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#adminProfileModal">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Admin Profile Modal -->
            <div class="modal fade" id="adminProfileModal" tabindex="-1" role="dialog" aria-labelledby="adminProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-gradient-primary text-white">
                            <h5 class="modal-title font-weight-bold" id="adminProfileModalLabel">Admin Profile</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body p-5">
                            <div class="text-center mb-5">
                                <div class="position-relative d-inline-block">
                                    <img id="preview" src="<?php echo htmlspecialchars($_SESSION['user']['avatar'] ?? '/assets/image/default_avatar.jpg'); ?>"
                                        class="rounded-circle profile-img shadow-lg border border-3 border-white"
                                        alt="Profile Image" width="150" height="150">
                                    <label for="profileImageUpload" class="position-absolute bottom-0 right-0 text-white rounded-circle p-2 shadow-sm"
                                        style="cursor: pointer; transform: translate(20%, 20%); background-color: #ff6769;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" name="profile_image" id="profileImageUpload" class="d-none" accept="image/*" onchange="updateProfileImage(event)">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user']['id'] ?? '1'); ?>">
                                </div>
                            </div>

                            <form id="adminProfileForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="fullName" class="form-label font-weight-semibold text-gray-700">Full Name</label>
                                            <input type="text" class="form-control form-control-lg shadow-sm"
                                                id="fullName" name="fullName"
                                                value="<?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Admin User'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="email" class="form-label font-weight-semibold text-gray-700">Email</label>
                                            <input type="email" class="form-control form-control-lg shadow-sm"
                                                id="email" name="email"
                                                value="<?php echo htmlspecialchars($_SESSION['user']['email'] ?? 'admin@example.com'); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="username" class="form-label font-weight-semibold text-gray-700">Username</label>
                                            <input type="text" class="form-control form-control-lg shadow-sm"
                                                id="username" name="username"
                                                value="<?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'admin_user'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="role" class="form-label font-weight-semibold text-gray-700">Role</label>
                                            <input type="text" class="form-control form-control-lg shadow-sm"
                                                id="role" value="Super Admin" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="lastLogin" class="form-label font-weight-semibold text-gray-700">Last Login</label>
                                    <input type="text" class="form-control form-control-lg shadow-sm"
                                        id="lastLogin" value="<?php echo date('Y-m-d H:i:s'); ?>" disabled>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="bio" class="form-label font-weight-semibold text-gray-700">Bio</label>
                                    <textarea class="form-control form-control-lg shadow-sm" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($_SESSION['user']['bio'] ?? 'System administrator with full access rights'); ?></textarea>
                                </div>

                                <div class="d-flex justify-content-between mt-5">
                                    <button type="button" class="btn btn-outline-secondary px-4 py-2 font-weight-semibold" onclick="cancelProfileChanges()">Cancel</button>
                                    <button type="button" class="btn btn-primary px-4 py-2 font-weight-semibold" onclick="saveProfile()" id="saveProfileBtn" style="display: none;">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    let originalProfileImage = '<?php echo htmlspecialchars($_SESSION['user']['avatar'] ?? '/assets/image/default_avatar.jpg'); ?>';
    let newImageFile = null;

    function updateProfileImage(event) {
        const file = event.target.files[0];
        if (!file) {
            alert('Please select an image file.');
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Invalid file type. Please upload a JPEG, PNG, or GIF image.');
            return;
        }

        newImageFile = file;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('topbarProfilePic').src = e.target.result;
            document.getElementById('saveProfileBtn').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function cancelProfileChanges() {
        document.getElementById('preview').src = originalProfileImage;
        document.getElementById('topbarProfilePic').src = originalProfileImage;
        document.getElementById('saveProfileBtn').style.display = 'none';
        newImageFile = null;
        $('#adminProfileModal').modal('hide');
    }

    function saveProfile() {
        const formData = new FormData(document.getElementById('adminProfileForm'));
        formData.append('user_id', '<?php echo htmlspecialchars($_SESSION['user']['id'] ?? '1'); ?>');

        if (newImageFile) {
            formData.append('profile_image', newImageFile);
        }

        const saveBtn = document.getElementById('saveProfileBtn');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Saving...';
        saveBtn.disabled = true;

        fetch('/update_admin_image.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Profile updated successfully!');
                document.getElementById('preview').src = data.image_url || originalProfileImage;
                document.getElementById('topbarProfilePic').src = data.image_url || originalProfileImage;
                document.querySelector('.text-dark.font-weight-semibold').textContent = data.name || '<?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Admin User'); ?>';
                originalProfileImage = data.image_url || originalProfileImage;
                document.getElementById('saveProfileBtn').style.display = 'none';
                $('#adminProfileModal').modal('hide');
                newImageFile = null;
                window.location.reload(); // Reload to ensure session sync
            } else {
                alert('Failed to update profile: ' + data.message);
                document.getElementById('preview').src = originalProfileImage;
                document.getElementById('topbarProfilePic').src = originalProfileImage;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating profile: ' + error.message);
            document.getElementById('preview').src = originalProfileImage;
            document.getElementById('topbarProfilePic').src = originalProfileImage;
        })
        .finally(() => {
            saveBtn.textContent = originalText;
            saveBtn.disabled = false;
        });
    }
    </script>
</body>
</html>