<?php
require_once 'Database.php';

class ProfileManager {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function updateProfile($userId, $fullName, $email, $file) {
        try {
            // Handle image upload
            $imagePath = null;
            if ($file && $file['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($file['type'], $allowedTypes)) {
                    return ['success' => false, 'message' => 'Invalid file type'];
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newFileName = 'profile_' . $userId . '_' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/uploads/profiles/';
                
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $imagePath = '/uploads/profiles/' . $newFileName;
                move_uploaded_file($file['tmp_name'], __DIR__ . $imagePath);
            }

            // Update database
            $query = "UPDATE admins SET full_name = :full_name, email = :email";
            if ($imagePath) {
                $query .= ", profile_image = :profile_image";
            }
            $query .= " WHERE admin_id = :admin_id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':full_name', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':admin_id', $userId);
            
            if ($imagePath) {
                $stmt->bindParam(':profile_image', $imagePath);
            }

            $result = $stmt->execute();

            return [
                'success' => $result,
                'message' => $result ? 'Profile updated successfully' : 'Failed to update profile'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}

// Handle the request
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = 1; // Replace with actual user ID from session
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $file = $_FILES['profile_image'] ?? null;

    $profileManager = new ProfileManager();
    $result = $profileManager->updateProfile($userId, $fullName, $email, $file);
    echo json_encode($result);
}