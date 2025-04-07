<?php
// Start session to access user data
session_start();

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "drink_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current user data (assuming user_id is stored in session)
$user_id = $_SESSION['user_id'] ?? 0;

$stmt = $conn->prepare("SELECT user_id, name, email, role FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <!-- Include your CSS and JS files here -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>
    <?php include '../partials/navbar.php'; ?>
    <?php include '../partials/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Page content goes here -->
            
            <!-- Display success or error messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <!-- Profile content here -->
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">Profile</h1>
                <!-- Profile card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Your Profile</h6>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#adminProfileModal">
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Profile Modal -->
    <div class="modal fade" id="adminProfileModal" tabindex="-1" aria-labelledby="adminProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-right modal-md h-100 my-0">
            <div class="modal-content h-100 shadow-lg border-0">

                <!-- Modal Header -->
                <div class="modal-header bg-gradient-primary text-white px-4 py-3">
                    <h5 class="modal-title font-weight-bold" id="adminProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body with Form -->
                <div class="modal-body p-4 bg-light">
                    <!-- Profile Form -->
                    <form action="../update_profile.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        
                        <!-- Profile Picture with Upload -->
                        <div class="text-center mb-4">
                            <div class="d-inline-block position-relative">
                                <img src="../get_image.php?user_id=<?php echo $user['user_id']; ?>" class="rounded-circle shadow-sm border border-2 border-white profile-img" width="120" height="120" alt="Profile">
                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-3 border-white"></span>
                            </div>
                            <div class="mt-3">
                                <label for="profileImage" class="btn btn-sm btn-outline-primary rounded-pill px-3">Change Photo</label>
                                <input type="file" id="profileImage" name="profileImage" accept="image/*" class="d-none" onchange="previewImage(event)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label text-muted small font-weight-bold">Full Name</label>
                            <input type="text" class="form-control form-control-lg rounded-pill" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small font-weight-bold">Email Address</label>
                            <input type="email" class="form-control form-control-lg rounded-pill" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" placeholder="Enter your email" required>
                        </div>
                        <div class="text-center">
                            <span class="badge bg-primary text-white px-3 py-1 rounded-pill"><?php echo htmlspecialchars($user['role'] ?? 'User'); ?></span>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="mt-4 text-right">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom CSS for right-aligned modal */
        .modal-dialog-right {
            position: fixed;
            right: 0;
            margin-right: 0;
            max-width: 400px;
            transition: transform 0.3s ease-out;
        }

        .modal.fade .modal-dialog-right {
            transform: translateX(100%);
        }

        .modal.show .modal-dialog-right {
            transform: translateX(0);
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #00b4ff);
        }

        .rounded-lg {
            border-radius: 0.5rem !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        }

        .form-control {
            border-color: #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-label {
            margin-bottom: 0.3rem;
        }

        .profile-img {
            object-fit: cover;
            height: 120px;
        }
    </style>

    <script>
        // JavaScript for image preview
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.querySelector('.profile-img');
                    imgElement.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php include '../partials/footer.php'; ?>
</body>
</html>

