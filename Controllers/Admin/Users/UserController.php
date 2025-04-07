<?php
namespace YourNamespace\Controllers\Admin\Users;
require_once './controllers/BaseController.php'; // Correct path to BaseController.php
require_once './Models/UserModel.php';

use YourNamespace\BaseController; // Ensure the namespace matches BaseController
use YourNamespace\Models\UserModel; // Add this line

class UserController extends BaseController
{
    private $model;

    function __construct()
    {
        // Make sure sessions are started if you're using $_SESSION
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new UserModel(); // Use the namespaced UserModel
    }

    function index()
    {
        $users = $this->model->getUsers();
        $this->views('user/list', ['users' => $users]); // Remove the .php extension
    }

    function create()
    {
        $this->views('user/create');
    }

    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set up the target directory for image uploads
            $uploadDir = 'uploads/users/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Handle file upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageName = basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . uniqid() . '_' . $imageName;
                
                // Validate image file type
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                
                if (in_array($imageFileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $imagePath = $uploadFile;
                    } else {
                        $_SESSION['error'] = 'Failed to upload image';
                        $this->redirect('/admin/users/create');
                        return;
                    }
                } else {
                    $_SESSION['error'] = 'Only JPG, JPEG, PNG & GIF files are allowed';
                    $this->redirect('/admin/users/create');
                    return;
                }
            }
    
            $data = [
                'image' => $imagePath,
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'role' => $_POST['role'] ?? 'user',
                'password' => $_POST['password'],
            ];
    
            // Check if email exists
            if ($this->model->emailExists($data['email'])) {
                $_SESSION['error'] = 'The email address is already in use.';
                $this->redirect('/admin/users/create');
                return;
            }
    
            if ($this->model->createUser($data)) {
                $_SESSION['success'] = 'User created successfully.';
                $this->redirect('/admin/users');
            } else {
                $_SESSION['error'] = 'Failed to create user';
                $this->redirect('/admin/users/create');
            }
        }
    }
    function edit($id)
    {
        $user = $this->model->getUser($id);
        $this->views('user/edit.php', ['user' => $user]);
    }

    function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'image' => $_POST['image'],
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'role' => $_POST['role'],
            ];

            $this->model->updateUser($id, $data);
            $this->redirect('/admin/users');
        }
    }

    function destroy()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $id = $_POST['user_id'];
        if ($this->model->deleteUser($id)) {
            $_SESSION['success'] = 'User deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }
    }
    $this->redirect('/admin/users');
}
}
