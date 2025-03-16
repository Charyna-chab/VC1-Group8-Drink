<?php
require_once 'Models/UserModel.php';
require_once 'BaseController.php';

class UserController extends BaseController
{
    private $model;

    function __construct()
    {
        $this->model = new UserModel();
    }

    function index()
    {
        $users = $this->model->getUsers();
        $this->views('user/list.php', ['users' => $users]);
    }

    function create()
    {
        $this->views('user/create.php');
    }

    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
            $data = [
                'name' => $_POST['name'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
            ];
            print_r($data); // Debugging: Print the data
            $this->model->createUser($data);
            $this->redirect('/user');
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
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
        ];
        $this->model->updateUser($id, $data); // Only call updateUser
        $this->redirect('/user');
    }
}

function destroy($id)
{
    $this->model->deleteUser($id);
    $this->redirect('/user');
}



    public function profile()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit; // Use exit to stop further execution
        }

        // Fetch user profile data (assuming you have a method in the model)
        $user = $this->model->getUser($_SESSION['user_id']);
        $this->views('profile.php', ['user' => $user]);
    }

    public function notifications()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'User not logged in']);
            exit; // Use exit to stop further execution
        }

        // Fetch notifications (assuming you have a method in the model)
        // $notifications = $this->model->getNotifications($_SESSION['user_id']);
        // header('Content-Type: application/json');
        // echo json_encode($notifications);
    }
}