<?php
require_once 'Models/UserModel.php';
require_once 'BaseController.php';

class UserController extends BaseController
{
    private $model;

    function __construct()
    {
        // Make sure sessions are started if you're using $_SESSION
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new UserModel();
    }

    function index()
    {
        $users = $this->model->getUsers();
        $this->views('user/list.php', ['users' => $users]); // Removed .php extension
    }

    function create()
    {
        $this->views('user/create.php'); // Removed .php extension
    }

    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set up the target directory for image uploads
            $uploadDir = 'uploads/user/';

            // Check if the directory exists, if not create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Creates the directory if it doesn't exist
            }

            // Set the image file path
            $imageName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $imageName;

            // Check if file is an image
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($imageFileType, $allowedTypes)) {
                // Try to upload the file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image_url = $uploadFile;  // Image URL or path saved to the database

                    // Prepare the data for the user
                    $data = [
                        'image' => $image_url,
                        'name' => isset($_POST['name']) ? $_POST['name'] : null,
                        'phone' => isset($_POST['phone']) ? $_POST['phone'] : null,
                        'email' => isset($_POST['email']) ? $_POST['email'] : null,
                        'address' => isset($_POST['address']) ? $_POST['address'] : null,
                    ];

                    // Validate that all required fields are present
                    if (empty($data['name']) || empty($data['phone']) || empty($data['email']) || empty($data['address'])) {
                        $_SESSION['error'] = 'All fields except the image are required!';
                        $this->views('user/create.php', ['error' => $_SESSION['error']]); // Removed .php extension
                        return;
                    }
                }
            }

            $this->model->createUser($data);
            $this->redirect('/user');
        }
    }

    function edit($id)
    {
        $user = $this->model->getUser($id);
        $this->views('user/edit.php', ['user' => $user]); // Removed .php extension
    }

    function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address']
            ];
            $this->model->updateUser($id, $data);
            $this->redirect('/user');
        }
    }

    function destroy($id)
    {
        $this->model->deleteUser($id);
        $this->redirect('/user');
    }
}
