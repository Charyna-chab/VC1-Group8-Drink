<?php

namespace YourNamespace\Controllers;

use YourNamespace\BaseController;
use PDO;
use PDOException;

require_once 'Database/database.php';

use YourNamespace\Database\Database;

class ProfileController extends BaseController
{
    private $conn;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize database connection
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function updateProfileImage()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        // Check if file was uploaded
        if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
            return;
        }

        $file = $_FILES['profile_image'];
        $userId = $_SESSION['user_id'];

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.']);
            return;
        }

        // Validate file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 5MB.']);
            return;
        }

        try {
            // Create uploads directory if it doesn't exist
            $uploadDir = 'uploads/profiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate a unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . $userId . '_' . uniqid() . '.' . $extension;
            $filepath = $uploadDir . $filename;

            // Move the uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Update the database with the new image path
                $stmt = $this->conn->prepare("UPDATE users SET image = :image WHERE user_id = :user_id");
                $stmt->bindParam(':image', $filepath);
                $stmt->bindParam(':user_id', $userId);
                
                if ($stmt->execute()) {
                    // Update the session with the new image path
                    $_SESSION['user']['avatar'] = '/' . $filepath;
                    
                    // Return success response
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Profile image updated successfully',
                        'image_url' => '/' . $filepath
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update database']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save uploaded file']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
