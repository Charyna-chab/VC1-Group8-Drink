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

// Get user ID from request
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

// Prepare and execute query to get image
$stmt = $conn->prepare("SELECT image FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();

// If no image is found, return a default image
if (!$image) {
    // Path to a default image
    $default_image = file_get_contents('assets/image/default.jpg');
    header("Content-Type: image/jpeg");
    echo $default_image;
    exit();
}

// Set the content type to image
header("Content-Type: image/jpeg"); // Adjust based on the image type
echo $image;

$stmt->close();
$conn->close();
?>

