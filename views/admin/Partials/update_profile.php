<?php
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

// Get form data
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];

// Handle image upload
$image = null;
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($_FILES['profileImage']['tmp_name']);
    if (!in_array($file_type, $allowed_types)) {
        header("Location: admin/profile.php?error=Invalid image type. Only JPEG, PNG, and GIF are allowed.");
        exit();
    }

    // Validate file size (max 2MB)
    $max_size = 2 * 1024 * 1024; // 2MB in bytes
    if ($_FILES['profileImage']['size'] > $max_size) {
        header("Location: admin/profile.php?error=Image size too large. Maximum 2MB allowed.");
        exit();
    }

    $image = file_get_contents($_FILES['profileImage']['tmp_name']); // Read the image as binary data
}

// Prepare the SQL query
if ($image) {
    // If a new image is uploaded, update all fields including the image
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, image = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $name, $email, $image, $user_id);
} else {
    // If no new image, update only name and email
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id);
}

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the profile page with a success message
    header("Location: admin/profile.php?success=Profile updated successfully");
} else {
    // Redirect with an error message
    header("Location: admin/profile.php?error=Failed to update profile: " . $conn->error);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

