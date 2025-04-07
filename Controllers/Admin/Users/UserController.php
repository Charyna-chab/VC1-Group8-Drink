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
            $data = [
                'image' => $_POST['image'],
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'role' => $_POST['role'] ?? 'user',
                'password' => $_POST['password'],
            ];

            // Check if the email already exists
            if ($this->model->emailExists($data['email'])) {
                $_SESSION['error'] = 'The email address is already in use.';
                $this->redirect('/admin/users/create');
                return;
            }

            $this->model->createUser($data);
            $_SESSION['success'] = 'User created successfully.';
            $this->redirect('/admin/users');
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

    function destroy($id)
    {
        $this->model->deleteUser($id);
        $this->redirect('/admin/users');
    }
}
